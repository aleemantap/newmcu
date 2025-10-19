<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatistikumumPaketExport implements FromCollection, WithHeadings
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
        $paket = Mcu::selectRaw('paket_mcu, count(paket_mcu) as total')->groupBy('paket_mcu');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $paket->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }

        // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            //$vendor_id = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $vendor_id = session()->get('user.vendor_id');
			$paket->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        //$recordTotal = count($paket->get());

        // Search
        //foreach($request->columns as $column) {
          //  if($column['searchable'] == 'true') {
            //    $paket->where($column['data'], 'like' ,'%'.$request->search['value'].'%');
            //}
        //}
		if($this->search != '') {
			 $paket->where('paket_mcu', 'like' ,'%'.$this->search.'%');
		}
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($this->perusahaan != '') {
				$idPerusahaan = $this->perusahaan;
				$paket->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($this->vendor != '') {
				$idVendor = $this->vendor;
				$paket->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		
		if(session()->get('user.user_group_id')==2) { //vendr 
			
			if($this->perusahaan != '') {
				$idPerusahaan = $this->perusahaan;
				$paket->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

		}
		

        // Filter Client
        if($this->client != '') {
            $client = $this->client;
            $paket->where('client', $client);
        }

        // Filter Date
        if($this->startDate != '' && $this->endDate == '') {
            $paket->where('tgl_input', '>', $this->startDate);
        }

        if($this->startDate == '' && $this->endDate != '') {
            $paket->where('tgl_input', '<', $this->endDate);
        }

        if($this->startDate != '' && $this->endDate != '') {
            $paket->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }

        //$recordFiltered = count($paket->get());

        // Order
        //$orderIndex = (int) $request->order[0]['column'];
        $orderDir = $this->order;
        $orderColum = $this->kolom;

        $paket->orderBy($orderColum, $orderDir);
        //$paket->skip($request->start)->take($request->length);
		
		return $paket->get();
       
    }
	
	 public function headings(): array
    {
        return [
            'paket MCU',
            'Total'
        ];
    }
}

