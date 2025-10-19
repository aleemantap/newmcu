<?php

namespace App\Http\Controllers;

// use App\Jobs\SendReportWhatsAppGetNewStatusDelivery;
use App\Models\Mcu;
use App\Models\Process;
use App\Models\Customer;
use App\Models\VendorCustomer;
use App\Models\Reportsendwa;
use App\Jobs\SendGetNewReportWhatsApp;
use App\Exports\WaReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Setting; 
use App\Jobs\SendReportWhatsApp;



class WaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $process = Process::where('upload','sendwa')->where('status','ON PROGRESS')->first();
        //$processwa = Process::where('upload','sendwa')->where('status','ON PROGRESS')->first();
        
        $customers = Customer::where('active', 'Y')->get();
        $vendorCustomer = VendorCustomer::all();
        $departments = Mcu::selectRaw('distinct(bagian)')->get();
       
        return $this->view('pages.reportwa.index','Report Sending WA','Report Sending WA',[
            'process' => $process,
            'customers' => $customers,
            'vendorCustomer' => $vendorCustomer,
            'departments' => $departments
        ]);
    }


    public function datatables(Request $request)
    {
        $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa']);

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $customerId = session()->get('user.vendor_id');
            $m->whereHas('vendor', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }


        $recordTotal = $m->count();

        if($request->idPasien != '') {
            //$idPasien = str_pad($request->idPasien, 8, 0, 0);
            $idPasien = $request->idPasien;
            //$m->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $m->where('id','like','%' .  $idPasien  . '%'); 
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            //$m->where('no_nip', $nik);
            $m->where('no_nip','like','%' .  $nik  . '%'); 
        }

        if($request->sendwa != '') { //status ketika diklik send oleh user
            $sendwa = $request->sendwa;
            //$m->where('tgl_lahir', $sendwa);
             $m->where('published','like','%' .  $sendwa  . '%'); 
        }
		
		if($request->statusdelivery != '') { //status response bahwa data terkirim ke HP apa belum
            //$statusdelivery = '"status":"'.$request->statusdelivery.'"';
            $statusdelivery = $request->statusdelivery;
			$m->whereHas('reportsendwa', function($q) use ($statusdelivery) {
                $q->where('delivery','like','%' .  $statusdelivery . '%');
            });
        }
		
       if($request->statuswa != '') { //status response oleh server WA
            $statuswa = $request->statuswa;
            $m->whereHas('reportsendwa', function($q) use ($statuswa) {
                $q->where('status','like','%' .  $statuswa . '%');
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            //$m->where('bagian', $bagian);
			 $m->where('bagian','like','%' .  $bagian  . '%'); 
        }

        // Filter Client
        /*if($request->client != '') {
            $client = $request->client;
            $m->where('client','like', '%'.$client.'%');
            //$m->where('vendor_customer_id',$project);
        }*/

        if($request->client != '') {
   
            $client = $request->client;
            $m->whereHas('vendorCustomer.customer', function($q) use($client) {
               $q->where('id',$client);
            });
            
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
         //   $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
          //  $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        //}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		// Filter mucid
        if($request->fromId != '' and $request->toId != '') {
            $fromId = $request->fromId;
            $toId = $request->toId;
            $m->whereBetween('id',[$fromId,$toId]);
			
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

	function export(Request $request)
    {

		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$bagian = $request->bagian;
		$client = $request->client;
		$startDate = "";//$request->startDate;
        $endDate = "";//$request->endDate;
        $sendwa = $request->sendwa;
        $statuswa = $request->statuswa;
        $statusdelivery = $request->statusdelivery;
        
        return Excel::download(new WaReportExport($idPasien,
												   $nama,
												   $nip,
												   $bagian,
												   $client,
												   $startDate,
												   $endDate,
												   $sendwa,
												   $statuswa,
												   $statusdelivery
												   ), 'report-wa.xlsx');
    }

	public function detail(Request $request)
	{
		$id = $request->id;
		$pr = Mcu::find($id); 
		
		$dt = $pr->reportsendwa?$pr->reportsendwa->note:'';
		
		$del = '';
       // print_r($dt);
	    
        
        if($dt!=='')
		 {
		    $del = json_decode($dt, true)['message']['messageId'];

            return $this->view('pages.reportwa.wa','Detail WA','Detail WA', [
                'data' => $pr,
                'sts_del' => $pr->reportsendwa->delivery,
                'msg_id' => $del,
                'sts_wa'=>$pr->reportsendwa->status
            ]);
     

		 }
         else
         {
            return $this->view('pages.reportwa.wa','Detail WA','Detail WA', [
                'data' => $pr,
                'sts_del' => '',
                'msg_id' => $del,
                'sts_wa' => '',
            ]);

            //print_r($pr);

         }
		 
       
		
	}


	public function updatewa(Request $request)
    {
         $d = Mcu::find($request->mcu_id);

         $d->telepon   = $request->hp;
        
         if(!$d->save()) {
             return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update Telepon']);
         }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Telepon has been updated successfully']);
    }
	
	
	public function resendwa_xx(Request $request)
    {
        
        $ckhp = Mcu::find($request->mcu_id);
        
        if($ckhp->telepon==null or $ckhp->telepon=="")
        {
            return response()->json(['responseCode' => 201, 'responseStatus' => 'OK', 'responseMessage' => 'No Hp Tidak tersedia Di Database, silahkan Update No Hp']);

        }
        else
        {
            $ids = [$request->mcu_id];
            //SendReportWhatsApp::dispatch($ids, session()->get('user.name'));
            //$this->resendWa($request->mcu_id);
            $process = new Process();
            $process->fill([
                'upload'    => 'resendwa',
                'processed' => 0,
                'success'   => 0,
                'failed'    => 0,
                'total'     => count($ids),
                'status'    => 'ON PROGRESS'
            ]);
            $process->save();

            $processId = $process->id;
            SendReportWhatsApp::dispatch($ids, session()->get('user.name'), $processId)->onQueue('wa')->delay(now()->addSeconds(2));
            return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'WA has been sent successfully']);
        }
        
        
 
    }
	
	public function resendw(Request $request)
    {
        
        $ckhp = Mcu::find($request->mcu_id);
        
        if($ckhp->telepon==null or $ckhp->telepon=="")
        {
            return response()->json(['responseCode' => 201, 'responseStatus' => 'OK', 'responseMessage' => 'No Hp Tidak tersedia Di Database, silahkan Update No Hp']);

        }
        else
        {
            $ids = [$request->mcu_id];
            //SendReportWhatsApp::dispatch($ids, session()->get('user.name'));
            //$this->resendWa($request->mcu_id);
            try
			{
					$mcus = Mcu::whereIn('id', $ids)->get();
					$i = 1;
					foreach($mcus as $mcu) {
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
						$this->sendWhatsAppMessage($phone, $message, $mcu->id, $mcu->process_id, session()->get('user.name'),$i);
						$i++;
					}
					
					return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'WA has been sent successfully']);

			}
			catch(Exception $e) {
			   //echo 'Message: ' .$e->getMessage();
			   return response()->json(['responseCode' => 201, 'responseStatus' => 'OK', 'responseMessage' => $e->getMessage()]);
			}  
				
		}
        
    }
	
	public function sendWhatsAppMessage($phone, $message, $mcu_id, $idpro, $sender, $i)
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
	
	public function newDelivery_xx(Request $request)
	{
		 $ids = [$request->mcu_id];
		 SendGetNewReportWhatsApp::dispatch($ids)->onQueue('wa');
		 return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'WA has been sent successfully']);
	}
	
	public function newDelivery(Request $request)
	{
		 $ids = $request->mcu_id;
		 try {
		     $this->getNewStatusWhatsAppMessage($ids);
		     return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'WA has been sent successfully']);
		 }
		 catch(Exception $e) {
		   //echo 'Message: ' .$e->getMessage();
		   return response()->json(['responseCode' => 201, 'responseStatus' => 'OK', 'responseMessage' => $e->getMessage()]);
		}  
	}
	
	public function getNewStatusWhatsAppMessage($mcu_id)
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
	
	
	
	public function checkNumber(Request $request)
	{
		$phone_no = $request->hp;
		//$key = '9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4'; //env('WOOWA_KEY');  
		$key = Setting::keyWa();
        $url ='http://116.203.191.58/api/check_number';
		$data = array(
		  "phone_no" => $phone_no,
		  "key"    => $key
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
		curl_close($ch);
		return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => $res]);
	}
	

	function newDeliveryFilter(Request $request)
    {
        $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa']);

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $customerId = session()->get('user.vendor_id');
            $m->whereHas('vendor', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }


      

        if($request->idPasien != '') {
            //$idPasien = str_pad($request->idPasien, 8, 0, 0);
            $idPasien = $request->idPasien;
            //$m->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $m->where('id','like','%' .  $idPasien  . '%'); 
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            //$m->where('no_nip', $nik);
            $m->where('no_nip','like','%' .  $nik  . '%'); 
        }

        if($request->sendwa != '') { //status ketika diklik send oleh user
            $sendwa = $request->sendwa;
            //$m->where('tgl_lahir', $sendwa);
             $m->where('published','like','%' .  $sendwa  . '%'); 
        }
		
		if($request->statusdelivery != '') { //status response bahwa data terkirim ke HP apa belum
            //$statusdelivery = '"status":"'.$request->statusdelivery.'"';
            $statusdelivery = $request->statusdelivery;
			$m->whereHas('reportsendwa', function($q) use ($statusdelivery) {
                $q->where('delivery','like','%' .  $statusdelivery . '%');
            });
        }
		
       if($request->statuswa != '') { //status response oleh server WA
            $statuswa = $request->statuswa;
            $m->whereHas('reportsendwa', function($q) use ($statuswa) {
                $q->where('status','like','%' .  $statuswa . '%');
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            //$m->where('bagian', $bagian);
			 $m->where('bagian','like','%' .  $bagian  . '%'); 
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client','like', '%'.$client.'%');
            //$m->where('vendor_customer_id',$project);
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
         //   $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
          //  $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        //}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		// Filter mucid
        if($request->fromId != '' and $request->toId != '') {
            $fromId = $request->fromId;
            $toId = $request->toId;
            $m->whereBetween('id',[$fromId,$toId]);
			
        }

        

        // Get filtered mcu ids
        $ids = collect($m->get())->pluck('id')->toArray();

        //if(!$m->update(['published' => 'Y', 'published_at' => date('Y-m-d H:i:s')])) {
          //  return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to publish (send wa) data. Please try again']);
        //}

        // Dispatch job
        //SendReportEmail::dispatch($ids);
        SendGetNewReportWhatsApp::dispatch($ids)->onQueue('wa');

        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Data has been get successfully']);
    }
	
		

	
}
