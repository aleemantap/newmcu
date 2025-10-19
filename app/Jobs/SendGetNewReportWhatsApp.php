<?php

namespace App\Jobs;

use App\Models\Mcu;
use App\Models\Reportsendwa;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Helpers\Setting; 


class SendGetNewReportWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mcuIds;
    //protected $message_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mcuIds)
    {
        $this->mcuIds = $mcuIds;
        //$this->message_id = $message_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mcus = Mcu::whereIn('id', $this->mcuIds)->get();
        foreach($mcus as $mcu) {
            // Skip if patient don't have email address
            /* if(empty($mcu->telepon)) {
                continue;
            }

            // Correct phone number
            $phone = $mcu->telepon;
            if(substr($phone, 0, 1) == '0') {
                $phone = '+62' . substr($phone, 1);
            } */
			$this->getNewStatusWhatsAppMessage($mcu->id);
        }
    }

  
    private function getNewStatusWhatsAppMessage($mcu_id)
    {
       
		//$key = '9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4'; //env('WOOWA_KEY');  
        $key = Setting::keyWa();
		$url='http://116.203.191.58/api/check_delivery_status';
		
		
		$st = Reportsendwa::where('mcu_id', $mcu_id)->first();
		
		$data = array(
		  "key"         => $key,
		  "messageId"   => json_decode($st->note, true)['message']['messageId']
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
		
        $res=curl_exec($ch);
		$del = $this->isJson($res);
		
		$d = json_decode($res,true);
		$ar = array();
		$ar2 = array();
		$ar['status'] = $d['status'];
	
		//array_push($ar2, array("messageId"=>$data['messageId'],"status"=>$d['message']['status'], "sentDate"=>$d['message']['sentDate'],"statusDate"=>$d['message']['statusDate'],"content"=>$d['message']['content']));
		$ar['message'] = array("messageId"=>$data['messageId'],"status"=>$d['message']['status'], "sentDate"=>$d['message']['sentDate'],"statusDate"=>$d['message']['statusDate'],"content"=>$d['message']['content']);
		$res_new = json_encode($ar,true);
		
		
		Reportsendwa::updateOrCreate(
                [
                    'mcu_id'         => $mcu_id
                ],
                [
                    'note'           => $res_new, 
					'delivery'           => ($del)?json_decode($res)->message->status:$res, //staus delivery ke hp
                    'status'        => ($del)?json_decode($res)->status:$res,
                    //'sender'         => $sender, 
                    //'process_id' => $idpro
                ]
            );
        curl_close($ch);
    }
	
	private function isJson($str) {
		$json = json_decode($str);
		return $json && $str != $json;
	}
	
	

   
}
