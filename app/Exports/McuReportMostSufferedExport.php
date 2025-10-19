<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class McuReportMostSufferedExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
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
   // protected $diagnosis;
	
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
        $this->client = $client;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        //$this->diagnosis = $diagnosis;
    }

    public function headings(): array
    {
        return [
            'ID PASIEN', 'NIP', 'NAMA PASIEN', 'TGL LAHIR', 'JK', 'BAGIAN', 'Tgl MCU', 'TEMUAN'
        ];
    }

    public function map($d): array
    {
		
		$dig = $d->diagnosis_count;//[0]['name'];
		
		return [$d->id,$d->no_nip,$d->nama_pasien,$d->tgl_lahir,$d->jenis_kelamin,$d->bagian,$d->tgl_input, $dig];
	
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    
	
	public function query(){
		
		$m = Mcu::whereHas('diagnosis', function ($query) {
						$query->where('deleted', 0);
				})
                ->with('vendorCustomer.customer')
                ->withCount('diagnosis');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = $m->count();

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

        // Filter Tgl Lahir
        if($this->tglLahir != '') {
            $tglLahir = $this->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($this->lp != '') {
            $lp = $this->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($this->bagian != '') {
            $bagian = $this->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter client
        if($this->client != '') {
            $client = $this->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
        //if($this->idPerusahaan != '') {
            //$idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
            //$m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        //}
		
				if(session()->get('user.user_group_id')==1) { //admin 
					// Filter Id Perusahaan
					 if($this->idPerusahaan != '') {
						$idPerusahaan = $this->idPerusahaan; //str_pad($request->idPerusahaan, 4, 0, 0); //$request->idPerusahaan;
						$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
							$q->where('id', $idPerusahaan);
						});
					 }

					// Filter Id Vendor
					 if($this->idVendor != '') {
						 $idVendor = $this->idVendor;//str_pad($request->idVendor, 4, 0, 0); //$request->idVendor;
						 $m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
							$q->where('id', $idVendor);
						});
					 }
				}
		
				if(session()->get('user.user_group_id')==2){ //vendor
					
					 if($this->idPerusahaan != '') {
						$idPerusahaan = $this->idPerusahaan;
						$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
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
