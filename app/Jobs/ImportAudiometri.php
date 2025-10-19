<?php

namespace App\Jobs;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\AudiometriDetail;
use App\Models\Process;
use Screen\Capture;
use Exception;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\Audiometri;
class ImportAudiometri implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    protected $processId;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $processId)
    {
        $this->filename = $filename;
        $this->processId = $processId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //$path = $this->filename;
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$this->filename);
			$reader = ReaderEntityFactory::createReaderFromFile($path);
            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                if($sheet->getIndex() === 0) {
                    $this->calculateRow($sheet, $this->processId);
                    $this->readSheet($sheet, $this->processId);
					break;
                }
            }


            $reader->close();

            // delete file
            unlink($path);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    private function calculateRow($sheet, $processId)
    {
        $totalRow = 0;
        foreach($sheet->getRowIterator() as $i => $row) {
            $totalRow += 1;
        }

        $process = Process::find($processId);
        $process->total = $totalRow;
        $process->save();
    }
	
	private function readSheet($sheet, $processId)
    {
        $mcuIds = [];
		$daa = [];
        foreach ($sheet->getRowIterator() as $i => $row) {

            if($i == 1) {
                continue;
            }

            $this->updateProcess($processId, $i);

            $r = $row->toArray();
			
			$date = is_string($r[5])?date("Ymd", strtotime($r[5])):$r[5]->format('Ymd');
			$mcuId = $date.str_pad(str_replace(" ","", $r[6]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);
			
            //$mcuId = $r[5]->format('Ymd').str_pad(str_replace(" ","", $r[6]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);
            //$mcuId = $r[5]->format('Ymd').str_pad(str_replace(" ","", $r[4]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);
            array_push($mcuIds, $mcuId);

            AudiometriDetail::updateOrCreate(
                [
                    'mcu_id'        => $mcuId,
                    'frekuensi'     => $r[2]
                ],
                [
                    'kiri'          => $r[3],
                    'kanan'         => $r[4]
                ]
            );
			

        }

        // Make screen capture
       foreach($mcuIds as $id) {
            //$this->capture($id);
			////$this->audiometri_kesimpulan($id);
            ImportAudiometri::audiometri_kesimpulan($id);
       }
    }

	public static function audiometri_kesimpulan($id)
	{

		//$tf_ka = 0;
		//$tf_ki = 0;
		// $frekuensi = DB::table('audiometri_details')
        //         ->select('mcu_id','kiri','kanan','frekuensi')
		// 		->where('mcu_id',$id)
        //         ->get();
		// foreach ($frekuensi as $row) {

		// 	$ki  = $row->kiri * $row->frekuensi;
		// 	$ka  = $row->kanan * $row->frekuensi;

		// 	$tf_ki = $ki + $tf_ki;
		// 	$tf_ka = $ka + $tf_ka;

		// }
		$data = DB::table('audiometri_details')
                 ->select('mcu_id',DB::raw('round(AVG(kanan),0) as ratakanan'),DB::raw('round(AVG(kiri),0) as ratakiri'))
				 ->where('mcu_id',$id)
				 ->where('kanan','<>',0)
				 ->where('kiri','<>',0)
                 ->groupBy('mcu_id')
                 ->get();
		foreach ($data as $row) {

			$kanan = $row->ratakanan;
			$kiri = $row->ratakiri;

            $tf_ka = $kanan;
		    $tf_ki = $kiri;
		

			$ratakiri  = "Rata-rata ambang dengar telinga kiri adalah $kiri dB";
			$ratakanan = "rata-rata ambang dengar telinga kanan adalah $kanan dB";


			if($tf_ki >=0 AND $tf_ki <=25)
			{
				$kes_ki = 	"Pendengaran Telinga Kiri Normal ";
			}
			else if($tf_ki >25 AND $tf_ki <=40)
			{
				$kes_ki = 	"Gangguan Pendengaran Telinga Kiri Ringan";
			}
			else if($tf_ki >40 AND $tf_ki <=55)
			{
				$kes_ki = 	"Gangguan Pendengaran Telinga Kiri Sedang ";
			}
		  	else if($tf_ki >55 AND $tf_ki <=70)
			{
				$kes_ki = 	"Gangguan Pendengaran Telinga Kiri Sedang Berat ";
			}
			else if($tf_ki >70 AND $tf_ki <=90)
			{
				$kes_ki = 	"Gangguan Pendengaran Telinga Kiri Berat ";
			}
			else
			{
				$kes_ki = 	"Gangguan Pendengaran Telinga Kiri Sangat Berat ";
			}

			//IIf([Total Frekuensi Kiri]>=0 And [Total Frekuensi Kiri]<=25;"Pendengaran Telinga Kiri Normal, ";
			//IIf([Total Frekuensi Kiri]>25 And [Total Frekuensi Kiri]<=40;"Gangguan Pendengaran Telinga Kiri Ringan, ";
			//IIf([Total Frekuensi Kiri]>40 And [Total Frekuensi Kiri]<=55;"Gangguan Pendengaran Telinga Kiri Sedang, ";
			//IIf([Total Frekuensi Kiri]>55 And [Total Frekuensi Kiri]<=70;"Gangguan Pendengaran Telinga Kiri Sedang Berat, ";
			//IIf([Total Frekuensi Kiri]>70 And [Total Frekuensi Kiri]<=90;"Gangguan Pendengaran Telinga Kiri Berat, ";
			//"Gangguan Pendengaran Telinga Kiri Sangat Berat, ")))))

			//IIf([Total Frekuensi Kanan]>=0 And [Total Frekuensi Kanan]<=25;"Pendengaran Telinga Kanan Normal";
			//IIf([Total Frekuensi Kanan]>25 And [Total Frekuensi Kanan]<=40;"Gangguan Pendengaran Telinga Kanan Ringan";
			//IIf([Total Frekuensi Kanan]>40 And [Total Frekuensi Kanan]<=55;"Gangguan Pendengaran Telinga Kanan Sedang";
			//IIf([Total Frekuensi Kanan]>55 And [Total Frekuensi Kanan]<=70;"Gangguan Pendengaran Telinga Kanan Sedang Berat";
			//IIf([Total Frekuensi Kanan]>70 And [Total Frekuensi Kanan]<=90;"Gangguan Pendengaran Telinga Kanan Berat";
			//"Gangguan Pendengaran Telinga Kanan Sangat Berat")))))

			if($tf_ka >=0 AND $tf_ka <=25)
			{
				$kes_ka = 	"Pendengaran Telinga Kanan Normal ";
			}
			else if($tf_ka >25 AND $tf_ka <=40)
			{
				$kes_ka = 	"Gangguan Pendengaran Telinga Kanan Ringan ";
			}
			else if($tf_ka >40 AND $tf_ka <=55)
			{
				$kes_ka = 	"Gangguan Pendengaran Telinga Kanan Sedang ";
			}
		  	else if($tf_ka >55 AND $tf_ka <=70)
			{
				$kes_ka= 	"Gangguan Pendengaran Telinga Kanan Sedang Berat ";
			}
			else if($tf_ka >70 AND $tf_ka <=90)
			{
				$kes_ka = 	"Gangguan Pendengaran Telinga Kanan Berat";
			}
			else
			{
				$kes_ka = 	"Gangguan Pendengaran Telinga Kanan Sangat Berat ";
			}


			$kesimpulan = $kes_ki.", ".$kes_ka;


			Audiometri::updateOrCreate(
                   [
                        'mcu_id'                => $id
                    ],
                    [
                        'hasil_telinga_kiri'    => $ratakiri,
                        'hasil_telinga_kanan'   => $ratakanan,
                        'kesimpulan_audiometri' => $kesimpulan
                    ]
                 );


		}



	}

    /*private function capture($id)
    {
        //$url = 'http://gmeds.plazamedis.web.id/database/audiometri-chart/'.$id; //'https://www.google.com/';//url('database/audiometri-chart/'.$id); 
        $url = url('database/audiometri-chart/'.$id); 
        $screenCapture = new Capture();
        $screenCapture->setUrl($url);
        $screenCapture->setClipWidth(820);
        $screenCapture->setClipHeight(300);
        $screenCapture->setBackgroundColor('#FFFFFF');
        $fileLocation = storage_path('app/public/audiometri/'.$id);
        $screenCapture->save($fileLocation);
		
		
		//$idx = $id.'-'.time().'.jpg';
		$idx = $id.'.jpg';
		// Audiometri::updateOrCreate(
                // [
                    // 'mcu_id'    => $id
                // ],
                // [
                    // 'foto'        => $idx 
                // ]
            // );		
		$file = Storage::disk('public')->get('audiometri/'.$idx);
		$uploadedPath = Storage::disk('s3')->put('audiometri/'.$idx, $file);
		unlink(storage_path('app/public/audiometri/'.$idx));
		
		
    }*/

    private function updateProcess($processId, $i)
    {
        $process = Process::find($processId);

        $process->processed = $i;
        $process->success = $i;

        if($process->total == $i) {
            $process->status = 'DONE';
        }

        $process->save();
    }
}
