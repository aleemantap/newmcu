<?php

namespace App\Exports;

use App\Mcu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class WaReportExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $idPasien;
    protected $nama;
    protected $nip;
    protected $bagian;
    protected $startDate;
    protected $endDate;
    protected $client;
    protected $sendwa;
    protected $statuswa;
    protected $statusdelivery;
   
   
	
    public function __construct($idPasien = '', 
								$nama = '', 
								$nip = '',
								$bagian = '',
								$client = '',
								$startDate = '',
								$endDate = '',
								$sendwa = '',
								$statuswa = '',
								$statusdelivery = ''
								)
    {
        $this->idPasien = $idPasien;
        $this->nama = $nama;
        $this->nip = $nip;
        $this->bagian = $bagian;
        $this->client = $client;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->sendwa = $sendwa;
        $this->statuswa = $statuswa;
        $this->statusdelivery = $statusdelivery;
    }

    public function headings(): array
    {
        return [
            'ID Pasien', 'NIP', 'Nama Pasien', 'BAGIAN', 'Client', 'Waktu Kirim WA', 'Send WA', 'Status WA', 'Status Delivery'
        ];
    }

    public function map($d): array
    {
		//$dt = $d->reportsendwa?$d->reportsendwa->note:null;
		
		//$del = $d->reportsendwa->note;
		//$del = null;
		//if($dt!==null)
		//{
			//$del = json_decode($dt, true)['message']['status'];
		//} 
		//else
		//{
		//	 $del = $d->reportsendwa->note;
		//}
		
		$status = ($d->reportsendwa) ?$d->reportsendwa->status : "";
		$delivery = ($d->reportsendwa) ?$d->reportsendwa->delivery : "";
		return [$d->id,$d->no_nip,$d->nama_pasien,$d->bagian,$d->client,$d->published_at,$d->published,$status,$delivery];
	
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    
	
	public function query(){
		
		 $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa']);

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }
		
		if($this->idPasien != '') {
            //$idPasien = str_pad($request->idPasien, 8, 0, 0);
            $idPasien = $this->idPasien;
            //$m->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $m->where('id','like','%' .  $idPasien  . '%'); 
        }

        // Filter NIK
        if($this->nip != '') {
            $nik = $this->nip;
            //$m->where('no_nip', $nik);
            $m->where('no_nip','like','%' .  $nik  . '%'); 
        }
		
		 if($this->nama != '') {
            $name = $this->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }


		 if($this->bagian != '') {
            $bagian = $this->bagian;
            //$m->where('bagian', $bagian);
			 $m->where('bagian','like','%' .  $bagian  . '%'); 
        }

		if($this->client != '') {
            $client = $this->client;
            $m->where('client','like', '%'.$client.'%');
            //$m->where('vendor_customer_id',$project);
        }
		
		
		/* if($this->startDate != '') {
            $startDate = date('Ymd', strtotime($this->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($this->endDate != '') {
            $endDate = date('Ymd', strtotime($this->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        } */

       
	    if($this->sendwa != '') { //status ketika diklik send oleh user
            $sendwa = $this->sendwa;
            //$m->where('tgl_lahir', $sendwa);
             $m->where('published','like','%' .  $sendwa  . '%'); 
        }
		
		if($this->statusdelivery != '') { //status response bahwa data terkirim ke HP apa belum
            $statusdelivery = '"status":"'.$this->statusdelivery.'"';
            //$statusdelivery = '"status":"pending"';
			$m->whereHas('reportsendwa', function($q) use ($statusdelivery) {
                $q->where('note','like','%' .  $statusdelivery . '%');
            });
        }
		
        if($this->statuswa != '') { //status response oleh server WA
            $statuswa = $this->statuswa;
            $m->whereHas('reportsendwa', function($q) use ($statuswa) {
                $q->where('status','like','%' .  $statuswa . '%');
            });
        }
		
		return $m;
		 
	}

}
