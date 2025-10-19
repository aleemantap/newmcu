<?php

namespace App\Jobs;

use App\Models\Mcu;
use App\Models\Reportsendwa;
use App\Models\Process;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Helpers\Setting; 


class SendReportWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mcuIds;
    protected $sender;
    protected $processId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mcuIds,$sender,$processId)
    {
        $this->mcuIds = $mcuIds;
        $this->sender = $sender;
        $this->processId = $processId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mcus = Mcu::whereIn('id', $this->mcuIds)->get();
        $i = 1;
        foreach($mcus as $mcu) {
            // Skip if patient don't have email address
            //if(empty($mcu->telepon)) {
            //    continue;
            //}

            // Correct phone number
            
            $phone = $mcu->telepon;
            if($phone!="")
            {
                if(substr($phone, 0, 1) == '0') {
                    $phone = '+62' . substr($phone, 1);
                }
            }
            else
            {
                $phone = '+62xxx';
            }
            
			$kl = 'https://tinyurl.com/SurveyKepuasanPesertaMCU';
            //$url = url('report-mcu/' . encrypt($mcu->id));
            $url = url('report-mcu/' .$mcu->mcu_id_encript);
            $message ='Hallo *'.$mcu->nama_pasien.'* Hasil MCU Anda sudah keluar. Untuk melihat hasil MCU anda berikut link yang dapat Anda akses di :\n\n'.$url.'.\n\nSilakan simpan nomor resmi konsultasi kami, agar bisa menghubungi kami kembali di lain waktu bila ada yang ingin dikonsultasikan.\n\nKonsultasi kami *GRATIS* untuk menjawab setiap permasalahan kesehatan Anda.\n\nDan kiranya Anda dapat meluangkan waktu selama 1 menit untuk memberikan pendapat Anda tentang kami, pada link berikut:\nhttps://tinyurl.com/SurveyKepuasanPesertaMCU.  \nNo. Resmi (08119407055)';
			
            
            
            $this->updateProcess($this->processId, $i);

           
            
            $this->sendWhatsAppMessage($phone, $message, $mcu->id, $mcu->process_id, $this->sender,$i);


            $i++;
        }
    }

    // private function updateProcess2($processId, $i)
    // {
    //     $process = Process::find($processId);
    //     $process->processed = $i;
    //     $process->status  = 'STOPPED';

    //     $process->save();
    // }
	
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

        /*
        $key='db63f5inihanyakeydummycf083dd3ffd025d672e255xxxxx'; //this is demo key please change with your own key
        $url='http://116.203.191.58/api/async_send_message';
        $data = array(
        "phone_no"  => '+628975835238',
        "key"       => $key,
        "message"   => 'DEMO AKUN WOOWA. tes woowa api v3.0 mohon di abaikan',
        "skip_link" => True, // This optional for skip snapshot of link in message
        "pendingTime" => 3 // This optional for delay before send message
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
        );
        echo $res=curl_exec($ch);
        curl_close($ch);


        */
    // Send Whatsapp Message
    // private function sendWhatsAppMessage($phone, $message, $mcu_id, $idpro, $sender, $i){

    //     $key = Setting::keyWa();
	// 	$url='http://116.203.191.58/api/async_send_message';
    //     $phone = str_replace(",","",$phone);
    //     $phone = str_replace(".","",$phone);
    //     $phone = trim(str_replace("-","",$phone));
	// 	$data = [
    //         'phone_no'=> $phone,
    //         'key' => $key,
    //         'message'	=> $message,
	// 		'skip_link' => True,
	// 		"pendingTime" => 3
			
    //     ];
    //     $data_string = json_encode($data);
    //     //$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

		
	// 	$ch = curl_init($url);
	// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_VERBOSE, 0);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 360);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 	  'Content-Type: application/json',
	// 	  'Content-Length: ' . strlen($data_string))
	// 	);
		
		
    //     $res=curl_exec($ch);
	// 	$del = $this->isJson($res);
    //     Mcu::where('id',$mcu_id)->update(array('published' => 'Y', 'published_at'=>date('Y-m-d H:i:s')));
	// 	Reportsendwa::updateOrCreate(
    //             [
    //                 'mcu_id'         => $mcu_id
    //             ],
    //             [
    //                 'note'           => $res, //string json
    //                 'delivery'           => '',
    //                 'status'        => $res,
    //                 'sender'         => $sender, 
    //                 'process_id' => $idpro
    //             ]
    //         );
        
    //     curl_close($ch);

    // }
    private function sendWhatsAppMessage($phone, $message, $mcu_id, $idpro, $sender, $i)
    {
        //$key = '9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4';// env('WOOWA_KEY'); 
        $key = Setting::keyWa();
		$url='http://116.203.191.58/api/send_message';
        $phone = str_replace(",","",$phone);
        $phone = str_replace(".","",$phone);
        $phone = trim(str_replace("-","",$phone));
		$data = [
            'phone_no'=> $phone,
            'key' => $key,
            'message'	=> $message,
			"deliveryFlag" => True,
            //'skip_link' => True,
			//"pendingTime" => 3
			
        ];
        $data_string = json_encode($data);
        //$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  'Content-Length: ' . strlen($data_string))
		);
		
		
        $res=curl_exec($ch);
		$del = $this->isJson($res);
        Mcu::where('id',$mcu_id)->update(array('published' => 'Y', 'published_at'=>date('Y-m-d H:i:s')));
		Reportsendwa::updateOrCreate(
                [
                    'mcu_id'         => $mcu_id
                ],
                [
                    'note'           => $res, //string json
                    'delivery'           => ($del)?json_decode($res)->message->status:$res, //staus delivery ke hp
                    'status'        => ($del)?json_decode($res)->status:$res, //status server wa
                    'sender'         => $sender, 
                    'process_id' => $idpro
                ]
            );
        
        curl_close($ch);
    }

	private function isJson($str) {
		$json = json_decode($str);
		return $json && $str != $json;
	}

    // Send Whatsapp File
    private function sendWhatsAppFile($phone, $url)
    {
        $key = env('WOOWA_KEY');
        $url ='http://116.203.191.58/api/async_send_file_url';
        $file_path = $url;
        $data = [
            "phone_no" => $phone,
            "key"=>$key,
            "url"=>$file_path
        ];
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $res=curl_exec($ch);
		
        curl_close($ch);
    }
}
