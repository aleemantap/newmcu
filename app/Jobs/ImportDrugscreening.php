<?php

namespace App\Jobs;

use App\Models\DrugScreeningDetail;
use App\Models\DrugScreening;
use App\Models\Process;
use Exception;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportDrugscreening implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	protected $filename;
    protected $processId;
    
	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename,$processId)
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
       foreach ($sheet->getRowIterator() as $i => $row) {

            if($i == 1) {
                continue;
            }

            $this->updateProcess($processId, $i);

            $r = $row->toArray();
            $mcuId = $this->setAsDate($r[6], 'Ymd').str_pad(str_replace(" ","", $r[7]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);

            DrugScreeningDetail::updateOrCreate(
                [
                    'parameter_drug_screening'=> $r[4],
                    'mcu_id'        	  => $mcuId
                ],
                [
                    'tgl_pemeriksaan'     => $this->setAsDate($r[2], 'Y-m-d'),
                    'status_pemeriksaan'  => $r[3],                    
                    'hasil_drug_screening'=> $r[5],
                ]
            );
        }
    }
	
    private function readSheet2($sheet, $processId)
    {
       foreach ($sheet->getRowIterator() as $i => $row) {

            if($i == 1) {
                continue;
            }

            $this->updateProcess($processId, $i);

            $r = $row->toArray();
			
			if(isset($r[1]))
			{	
				
			    //$date = is_string($r[5])?date("Ymd", strtotime($r[5])):$r[5]->format('Ymd');
			    //$mcuId = $date.str_pad(str_replace(" ","", $r[6]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);	
			
				$mcuId = $this->setAsDate($r[6], 'Ymd').str_pad(str_replace(" ","", $r[7]), 4, 0, 0) . str_pad(str_replace(" ","", $r[1]), 8, 0, 0);
				$ck = DrugScreening::where('mcu_id',$mcuId)->get()->count();
				if($ck > 0)
				{	
					DrugScreeningDetail::updateOrCreate(
						[
							'parameter_drug_screening'=> $r[4],
							'mcu_id'        	  => $mcuId
						],
						[
							'tgl_pemeriksaan'     => $this->setAsDate($r[2], 'Y-m-d'),
							'status_pemeriksaan'  => $r[3],                    
							'hasil_drug_screening'=> $r[5],
						]
					);
				}
			}
        }
    }
    
    private function setAsDate($date, $format) {
        if(is_string($date)) {
            return date($format, strtotime($date));
        }
        
        return $date->format($format);
    }

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
