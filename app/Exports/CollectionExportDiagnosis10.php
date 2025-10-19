<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CollectionExportDiagnosis10 implements FromCollection, WithHeadings
{
    use Exportable;
	
	protected $idPerusahaan;
    protected $client;
    protected $sex;
    protected $startDate;
    protected $endDate;
    //protected $ekg;
    //protected $tglLahir;
    //protected $startDate;
    //protected $endDate;
    protected $idVendor;
    //protected $client;
    // protected $diagnosis;
	
	public function __construct($bagian = '',
								$idPerusahaan = '',
								$client = '',
								$sex = '',
								$startDate = '',
								$idVendor = '',
								$endDate = ''
								)
    {
        
        $this->bagian = $bagian;
        $this->idPerusahaan = $idPerusahaan;
        $this->client = $client;
        $this->sex = $sex;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->idVendor = $idVendor;
        //$this->diagnosis = $diagnosis;
    }

    public function collection()
    {
        $kp = $this->sql();
		$a1 = array();
		$k = 0;
		foreach($kp as $data){
			
			$a1[]= [
					'No'=> $data->code,
					'Diagnosis'=> $data->name,
					'Prevalensi'=> $data->total,
					];
			
		}
		return collect($a1);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Diagnosis',
            'Prevalensi',
           
        ];
    }
	
	public function sql(){
		
		// Initial empty where
        $mcuWhere = "";

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$vendorId;
        }

        // Filter Id Perusahaan
        if($this->idPerusahaan != '') {
            $idPerusahaan = $this->idPerusahaan;
            $mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
        }

        // Filter Id Vendor
        if($this->idVendor != '') {
            $idVendor = $this->idVendor;
            $mcuWhere .= " AND vc.vendor_id=".$idVendor;
        }

        // Filter Client
        if($this->client != '') {
            $client = $this->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter Sex
        if($this->sex != '') {
            $sex = $this->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Date
        if($this->startDate != '' && $this->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$this->startDate."'";
        }

        if($this->startDate == '' && $this->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$this->endDate."'";
        }

        if($this->startDate != '' && $this->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$this->startDate."' AND '".$this->endDate."')";
        }

        // Order
        //$orderIndex = (int) $request->order[0]['column'];
        //$orderDir = $request->order[0]['dir'];
        //$orderColumn = $request->columns[$orderIndex]['data'];
		
        $m = DB::select("SELECT COUNT(d.id) AS total, ri.id, ri.code, ri.name
            FROM (
                SELECT d.id, d.recommendation_id
                FROM diagnoses d
                JOIN (
                    SELECT m.id
                    FROM mcu m
                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                    WHERE 1=1 ".$mcuWhere."
                ) m ON d.mcu_id=m.id
            ) d
            JOIN (
                SELECT r.id AS rid, i.id, i.code, i.name
                FROM recommendations r
                JOIN icd10s i ON r.icd10_id=i.id
            ) ri ON d.recommendation_id=ri.rid
            GROUP BY ri.id, ri.code, ri.name
            
            LIMIT 10"
        );
		//ORDER BY ".$orderColumn." ".$orderDir."
        return $m; 
		
		 
	}

}

?>