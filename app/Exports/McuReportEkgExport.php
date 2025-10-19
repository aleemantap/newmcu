<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class McuReportEkgExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $idPasien;
    protected $nama;
    protected $nip;
    protected $lp;
    protected $bagian;
    protected $idPerusahaan;
    protected $ekg;
    protected $tglLahir;
    protected $startDate;
    protected $endDate;
    protected $idVendor;
    protected $client;
   // protected $diagnosis;
	
	public function __construct($idPasien = '', 
								$nama = '', 
								$nip = '',
								$tglLahir = '',
								$lp = '',
								$bagian = '',
								$idPerusahaan = '',
								$idVendor = '',
								$ekg = '',
								$client = '',
								$startDate = '',
								$endDate = ''
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
        $this->ekg = $ekg;
        $this->client = $client;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        //$this->diagnosis = $diagnosis;
    }

    public function headings(): array
    {
        return [
            'ID PASIEN', 'NIP', 'NAMA PASIEN', 'TGL LAHIR', 'JK', 'BAGIAN', 'Tgl MCU', 'KESIMPULAN EKG'
        ];
    }

    public function map($d): array
    {
		
		$dig = $d->ekg->kesimpulan_ekg;
		
		if($dig === 'Normal EKG') {
			$dig = 'Normal';
		} else {
			$dig = 'Abnormal';
		}
		
		
		return [$d->id,$d->no_nip,$d->nama_pasien,$d->tgl_lahir,$d->jenis_kelamin,$d->bagian,$d->tgl_input, $dig];
	
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    
	
	public function query(){
		
		$m = Mcu::has('ekg')->with('ekg');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vId) {
                $q->where('id', $vId);
            });
        }

      

        if($this->ekg != '') {
            $ekg = $this->ekg;
            $m->whereHas('ekg', function($q) use($ekg) {
                if($ekg == 'Normal') {
                    $q->where('kesimpulan_ekg', 'Normal EKG');
                } else {
                    $q->where('kesimpulan_ekg', '!=', 'Normal EKG');
                }
            });
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

        // Filter Tgl Lahir
        if($this->tglLahir != '') {
            $tglLahir = $this->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Lp
        if($this->lp != '') {
            $lp = $this->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Name
        if($this->nama != '') {
            $name = $this->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($this->bagian != '') {
            $bagian = $this->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id client
        if($this->client != '') {
            $client = $this->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
        //if($this->idPerusahaan != '') {
        //    $idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
        //    $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        //}
		
		if(session()->get('user.user_group_id')==1) { //admin 
			 // Check is has customer
			if($this->idPerusahaan != '') {
				$customerId = $this->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
			
			 // Check is has vendor
			if($this->idVendor != '') {
				$vId = $this->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($vId) {
					$q->where('id', $vId);
				});
			}
        }
		
		if(session()->get('user.user_group_id')==2) { //vendro 
		
			if($this->idPerusahaan != '') {
				$customerId = $this->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
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
