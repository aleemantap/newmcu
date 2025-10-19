<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatistikumumBagianExport  implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	 protected $kolom;
	 protected $order;
	 protected $perusahaan;
	 protected $vendor;
	 protected $client;
	 protected $startDate;
	 protected $endDate;
	 protected $search;
	 
	public function __construct($kolom = '', $order='', $perusahaan='',$vendor='',$client='',$startDate='',$endDate='',$search='')
    {
        $this->kolom = $kolom;
        $this->order = $order;
        $this->perusahaan = $perusahaan;
        $this->vendor = $vendor;
        $this->client = $client;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }
    public function collection()
    {
         $m = Mcu::selectRaw('bagian, count(bagian) as total')->groupBy('bagian');

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

        //$recordTotal = count($m->get());

        // Search
		
		if($this->search != '') {
			 $m->where('bagian', 'like' ,'%'.$this->search.'%');
		}
		
       
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($this->perusahaan != '') {
				$idPerusahaan = $this->perusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($this->vendor != '') {
				$idVendor = $this->vendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2) { //vendor 
			// Filter Id Perusahaan
			if($this->perusahaan != '') {
				$idPerusahaan = $this->perusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		}
        // Filter Client
        if($this->client != '') {
            $client = $this->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($this->startDate != '' && $this->endDate == '') {
            $m->where('tgl_input', '>', $this->startDate);
        }

        if($this->startDate == '' && $this->endDate != '') {
            $m->where('tgl_input', '<', $this->endDate);
        }

        if($this->startDate != '' && $this->endDate != '') {
            $m->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }

        //$recordFiltered = count($m->get());
		
		
		$orderDir = $this->order;
        $orderColum = $this->kolom;

      
        $m->orderBy($orderColum, $orderDir);
        //$m->skip($request->start)->take($request->length);
		return $m->get();

    }
	
	public function headings(): array
    {
        return [
            'Department',
            'Total'
        ];
    }
}
