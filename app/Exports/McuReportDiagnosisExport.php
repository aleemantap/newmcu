<?php

namespace App\Exports;

use App\Models\Mcu;
use App\Models\Diagnosis;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class McuReportDiagnosisExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
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
    protected $diagnosis;
    protected $kt;
	
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
								$diagnosis = '',
								$kt = '')
								
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
        $this->diagnosis = $diagnosis;
        $this->kt = $kt;
    }

    public function headings(): array
    {
        
		if($this->kt == "dk")
		{
			return [
            
				'ID PASIEN', 'NAMA PASIEN', 'TGL INPUT', 'DIAGNOSIS'
			];
		}
		else
		{
				return [
					'ID PASIEN',  'NAMA PASIEN',   'Tgl MCU', 'DIAGNOSIS'
				];
		}
		
		
    }


    public function map($d): array
    {
		
		if($this->kt == "dk")
		{
			//return [(int) substr($d->mcu_id, 12, 8), $d->nama_pasien, $d->tgl_input, $d->name];
			return [$d->mcu_id, $d->nama_pasien, $d->tgl_input, $d->name];
			
		}
		else
		{
			//$dig = $d->diagnosis[0]['name'];
			//$dig = $d->diagnosis;
			/*if(count($d->diagnosis) === 0 ) {
				$dig =  'Fit On Job';
				
			} else {
				//$dig = $d->diagnosis[count($d->diagnosis)-1]->name;
				//$dig = $d->diagnosis[0]->name;
				//$dig = $d->diagnosis; //->name;
				//$dig = collect($d->diagnosis->recommendation)->sortBy('sequence')->first();
				//$dig = $d->diagnosis['recommendation'];
				$dig = "tes";
			}*/
			$dig=$d->name;
		   	
		    //return [(int) substr($d->id, 12, 8),$d->nama_pasien,$d->tgl_input, $dig];
		    return [$d->mcu_id,$d->nama_pasien,$d->tgl_input, $dig];
		}
		
	
    }

    /**
     * @return \Illuminate\Support\Collection
     */
	public function query(){
		
		if($this->kt == "dk")
		{
				
				
				$m = Diagnosis::where("diagnoses.deleted","0")
				 ->join("mcu","mcu.id","=","diagnoses.mcu_id")
				 ->join("recommendations","recommendations.id","=","diagnoses.recommendation_id")
				 ->join("icd10s","icd10s.id","=","recommendations.icd10_id");
				 
				 // Check is has customer
				if(!empty(session()->get('user.customer_id'))) {
					$customerId = session()->get('user.customer_id');
					$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
						$q->where('id', $customerId);
					});
				}
				else if(!empty(session()->get('user.vendor_id'))) { 	// Check is has vendor
			
					$vendor_id = session()->get('user.vendor_id');
					$m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
						$q->where('id', $vendor_id);
					});
				}
				
				if(session()->get('user.user_group_id')==1) { //admin 
					// Filter Id Perusahaan
					 if($this->idPerusahaan != '') {
						$idPerusahaan = $this->idPerusahaan; //str_pad($request->idPerusahaan, 4, 0, 0); //$request->idPerusahaan;
						//$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
						//$m->whereRaw('vc.customer_id >= '.$idPerusahaan);
						$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($idPerusahaan) {
							$q->where('id', $idPerusahaan);
						});
					 }

					// Filter Id Vendor
					 if($this->idVendor != '') {
						 $idVendor = $this->idVendor;//str_pad($request->idVendor, 4, 0, 0); //$request->idVendor;
						 //$mcuWhere .= " AND vc.vendor_id=".$idVendor;
						 //$m->whereRaw('vc.vendor_id >= '.$idVendor);
						 $m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($idVendor) {
							$q->where('id', $idVendor);
						});
					 }
				}
		
				if(session()->get('user.user_group_id')==2){ //vendor
					
					 if($this->idPerusahaan != '') {
						$idPerusahaan = $this->idPerusahaan;
						//$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
						//$m->whereRaw('vc.customer_id >= '.$idPerusahaan);
						$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($idPerusahaan) {
							$q->where('id', $idPerusahaan);
						});
					 }
				
				}
				
				 
				 if($this->idPasien != '') {
						$idPasien = str_pad($this->idPasien, 8, 0, 0);
						$m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
				 }
				 
				 if($this->nama != '') {
					$name = $this->nama;
					$m->where('nama_pasien', 'like', '%'.$name.'%');
				}
				
				// Filter Date
				if($this->startDate != '') {
					$startDate = date('Ymd', strtotime($this->startDate));
					//$m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
					$m->whereRaw('tgl_input >= '.$startDate);
				}
				if($this->endDate != '') {
					$endDate = date('Ymd', strtotime($this->endDate));
					//$m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
					$m->whereRaw('tgl_input <= '.$endDate);
				}

			return $m;
		}
		else /* diagnosis kesehatan kerja */
		{
			    
				  $m = Mcu::query();

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
				
				$m->join(DB::raw("(SELECT d.mcu_id, MIN(r.work_health_id) AS wh_id
				            FROM (
				                SELECT mcu_id, recommendation_id
				                FROM diagnoses
				                WHERE mcu_id IN (
				                    SELECT m.id
				                    FROM mcu m
				                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
				                    WHERE 1=1 
				                ) AND deleted = '0'
				            ) d
				            JOIN (
				                SELECT id, work_health_id
				                FROM recommendations r
				                WHERE id IN (
				                    SELECT recommendation_id
				                    FROM diagnoses
									where deleted = '0'
				                    GROUP BY recommendation_id
				                )
				            ) r ON d.recommendation_id=r.id
				            GROUP BY d.mcu_id
				      ) as d"),function($join){
				        $join->on("mcu.id","=","d.mcu_id");
				  })
				  ->join('work_healths', 'work_healths.id', '=', 'd.wh_id');
				  if($this->diagnosis != '') {
				  	 $m->where('work_healths.id',$this->diagnosis);
				  }

				  if($this->idPasien != '') {
					$idPasien = str_pad($this->idPasien, 8, 0, 0);
					$m->whereRaw('substring(mcu.id, 13, 8) = '.$idPasien);
				}

				// Filter NIK
				if($this->nip != '') {
					$nik = $this->nip;
					$m->where('no_nip', $nik);
				}

				// Filter Tgl lahir
				if($this->tglLahir != '') {
					$tglLahir = $this->tglLahir;
					$m->where('tgl_lahir', $tglLahir);
				}

				// Filter LP
				if($this->lp != '') {
					$lp = $this->lp;
					$m->where('jenis_kelamin', $lp);
				}

				// Filter Name
				if($this->nama != '') {
					$name = $this->nama;
					$m->where('nama_pasien', 'like', $name);
				}

				// Filter Id bagian
				if($this->bagian != '') {
					$bagian = $this->bagian;
					$m->where('bagian', $bagian);
				}

				// Filter Client
				if($this->client != '') {
					$client = $this->client;
					$m->where('client', $client);
				}

				// Filter Date
				if($this->startDate != '') {
					$startDate = date('Ymd', strtotime($this->startDate));
					$m->whereRaw('substring(mcu.id, 1, 8) >= '.$startDate);
				}
				if($this->endDate != '') {
					$endDate = date('Ymd', strtotime($this->endDate));
					$m->whereRaw('substring(mcu.id, 1, 8) <= '.$endDate);
				}
				 
				  
				return $m;

				/*$m = Mcu::query();
				if($this->diagnosis != '') {
					$diagnosis = $this->diagnosis;
					$m->whereHas('diagnosis.recommendation', function($q) use ($diagnosis) {
						$q->where('work_health_id', $diagnosis);
						$q->where('deleted',0);
					});
				    
				    $diagnosis = $this->diagnosis;
				    $m->whereHas('diagnosis', function($q) use ($diagnosis) {
						$q->where('deleted',0);
						$q->whereHas('recommendation', function($q) use ($diagnosis) {
							$q->where('deleted',0);
							$q->where('work_health_id',$diagnosis);	
							$q->whereHas('workHealth', function($q) use ($diagnosis) {
								$q->where('id',$diagnosis);

							});
						});

					});
				
				}
				
				
				$m->with(['diagnosis' => function($q) {

				
				$q->join('recommendations', 'recommendations.id', '=', 'diagnoses.recommendation_id')
					->join('work_healths', 'work_healths.id', '=', 'recommendations.work_health_id')
					->where('recommendations.deleted',0)
					->where('diagnoses.deleted',0);
					//->where('recommendations.work_health_id',2)	te ngaruh	
					//->where('work_healths.id',2)		
					//->selectRaw('MIN(recommendations.work_health_id) as work_health_id', 'work_healths.name');
					//->select('work_healths.name');
					->orderBy('work_healths.sequence','desc');
				}]);

				

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

				//$recordTotal = $m->count();

				if($this->idPasien != '') {
					$idPasien = str_pad($this->idPasien, 8, 0, 0);
					$m->whereRaw('substring(id, 13, 8) = '.$idPasien);
				}

				// Filter NIK
				if($this->nip != '') {
					$nik = $this->nip;
					$m->where('no_nip', $nik);
				}

				// Filter Tgl lahir
				if($this->tglLahir != '') {
					$tglLahir = $this->tglLahir;
					$m->where('tgl_lahir', $tglLahir);
				}

				// Filter LP
				if($this->lp != '') {
					$lp = $this->lp;
					$m->where('jenis_kelamin', $lp);
				}

				// Filter Name
				if($this->nama != '') {
					$name = $this->nama;
					$m->where('nama_pasien', 'like', $name);
				}

				// Filter Id bagian
				if($this->bagian != '') {
					$bagian = $this->bagian;
					$m->where('bagian', $bagian);
				}

				// Filter Client
				if($this->client != '') {
					$client = $this->client;
					$m->where('client', $client);
				}

				// Filter diagnosis
				

				// Filter Id Perusahaan
				//if($this->idPerusahaan != '') {
				//	$idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
				//	$m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
				//}
				
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

				//$m = collect($m);
				return $m;*/
				
				
			
		}
		
	}
	
	public function query2(){
		
		$m = Mcu::with(['diagnosis' => function($q) {
           $q->join('recommendations', 'recommendations.id', '=', 'diagnoses.recommendation_id')
               // ->join('work_healths', 'work_healths.id', '=', 'recommendations.work_health_id')
               ->join('icd10s', 'icd10s.id', '=', 'recommendations.icd10_id');
               //->orderBy('work_healths.sequence');
        }]);

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }

        $recordTotal = $m->count();

        if($this->idPasien != '') {
            $idPasien = str_pad($this->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        /* if($this->nip != '') {
            $nik = $this->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Tgl lahir
        if($this->tglLahir != '') {
            $tglLahir = $this->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($this->lp != '') {
            $lp = $this->lp;
            $m->where('jenis_kelamin', $lp);
        } */

        // Filter Name
        if($this->nama != '') {
            $name = $this->nama;
            $m->where('nama_pasien', 'like', $name);
        }

       /*  // Filter Id bagian
        if($this->bagian != '') {
            $bagian = $this->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Client
        if($this->client != '') {
            $client = $this->client;
            $m->where('client', $client);
        }

        // Filter diagnosis
        if($this->diagnosis != '') {
            $diagnosis = $this->diagnosis;
            $m->whereHas('diagnosis.recommendation.workHealth', function($q) use ($diagnosis) {
                $q->where('id', $diagnosis);
            });
        }

        // Filter Id Perusahaan
        if($this->idPerusahaan != '') {
            $idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
            $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        } */

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
