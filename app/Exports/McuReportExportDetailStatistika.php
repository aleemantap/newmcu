<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class McuReportExportDetailStatistika implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $idPasien;
    protected $nama;
    protected $nip;
    protected $lp;
    protected $bagian;
    protected $idPerusahaan;
    protected $tglLahir;
    protected $startDate;
    protected $endDate;
    protected $idVendor;
    protected $client;
    protected $tabel;
    protected $nilai;
	
    public function __construct($idPasien = '', 
								$nama = '', 
								$nip = '',
								$tglLahir = '',
								$lp = '',
								$bagian = '',
								$idPerusahaan = '',
								$idVendor = '',
								$client = '',
								$startDate = '',
								$endDate = '',
								$tabel = '',
								$nilai = ''
								)
    {
        $this->idPasien = $idPasien;
        $this->nama = $nama;
        $this->nip = $nip;
        $this->tglLahir = $tglLahir;
        $this->lp = $lp;
        $this->bagian = $bagian;
        $this->idPerusahaan = $idPerusahaan;
        $this->idVendor = $idVendor;
        $this->client = $client;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tabel = $tabel;
        $this->nilai = $nilai;
    }

    public function headings(): array
    {
        return [
            'ID Pasien', 'NIP', 'Nama Pasien', 'Tgl Lahir', 'JK', 'Bagian', 'Client', 'Tgl MCU'
        ];
    }

    public function map($d): array
    {
		return [$d->id,$d->no_nip,$d->nama_pasien,$d->tgl_lahir,$d->jenis_kelamin,$d->bagian,$d->client,$d->tgl_input];
	
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    
	
	public function query(){
		
		$m = Mcu::with(['vendorCustomer','diagnosis']); 
		//$m = Mcu::with(['vendorCustomer']); 
		
		//$cd = $this->code;
		//$m->whereHas('diagnosis.recommendation.icd10', function($q) use ($cd){
		//	 $q->where('code', $cd);
		//});
	
        // Check is has customer $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
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
		
		if($this->tabel=='paket')
		{
			 $m->where('paket_mcu', $this->nilai);
            
		}
		else if($this->tabel=='bagian')
		{
			 $m->where('bagian', $this->nilai);
		}	
		else if($this->tabel=='client')
		{
			 $m->where('client', $this->nilai);
		}	
       
		
        if($this->idPasien != '') {
            $idPasien = str_pad($this->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($this->nip != '') {
            $nik = $this->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($this->nama != '') {
            $name = $this->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl lahir
        if($this->tglLahir != '') {
            $tglLahir = $this->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($this->lp != '') {
            $lp = $this->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($this->bagian != '') {
            $bagian = $this->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Client
        if($this->client != '') {
            $client = $this->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
		if(session()->get('user.user_group_id')==1) { //admin 
				
			if($this->idPerusahaan != '') {
				$idPerusahaan = $this->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			} 

			// Filter Id Vendor
			if($this->idVendor != '') {
				$idVendor = $this->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		
		}
		
		if(session()->get('user.user_group_id')==2){ //vendor
				
			if($this->idPerusahaan != '') {
				$idPerusahaan = $this->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			} 
			
		}

        // Filter Date
        if($this->startDate != '') {
            $startDate = date('Ymd', strtotime($this->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($this->endDate != '') {
            $endDate = date('Ymd', strtotime($this->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        } 
		
		return $m;
		 
	}

}
