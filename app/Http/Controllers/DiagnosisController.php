<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Recommendation;
use App\Models\Icd10;
use App\Models\Customer;
use App\Models\Mcu;
use App\Models\VendorCustomer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
//use App\Exports\DiagnosisReportTopTenExport;
use App\Exports\CollectionExportDiagnosis10;
use App\Exports\CollectionExportAllDiseases;
use App\Exports\McuReportExportDetailDiagnosis;
use App\Exports\CollectionExportDiagnosisTen;
use App\Exports\McuReportExportDetailStatistika;
use App\Exports\CollectionExportAllDiseasesDkk;
use App\Exports\McuReportExportDetailDiagnosisDkk;
use App\Services\DiagnosisReportService;
use Illuminate\Support\Facades\Cache;
class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $reportService;
    public function __construct(DiagnosisReportService $reportService)
    {
         $this->middleware('auth');
         $this->reportService = $reportService;
    } 
	
	public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnosis $diagnosis)
    {
        //
    }

    // Report
    public function reportTopTenDiagnosis()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        if(!empty($customerId)) {
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        } else {
            //$clients = null;
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.top-ten-diagnosis', 'Diagnosis Top 10','Diagnosis Top 10',[
            'customers' => $customers,
            'vendors' => $vendors,
            'clients' => $clients
        ]);
    }
	
	/*
	
	$customerId = session()->get('user.customer_id');
        $vendor_id = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendor_id))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
		}
		else {
            //$departments = null;
            //$clients = null;
			 $departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			 $clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

	
	*/

    public function reportAllDiagnosis()
    {
        $vc = VendorCustomer::with(['customer','vendor']);
		$c = Customer::where('active', 'Y');
        $v = Vendor::where('active', 'Y'); 
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
		$customers = null;
		$vendors = null;
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendorId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })->get(); 
           
			$customers = Customer::
						 join('vendor_customer', 'vendor_customer.customer_id', '=', 'customer.id')
						->where('vendor_customer.vendor_id',$vendorId)
						->where('active', 'Y')
						->get();
			
		} else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
			$vendors = $v->get();
			$customers = $c->get();
        }

        return $this->view('reports.all-diagnosis','Report All Diagnosis','All Diagnosis', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportAllDiagnosisDkk()
    {
        $vc = VendorCustomer::with(['customer','vendor']);
        $c = Customer::where('active', 'Y');
        $v = Vendor::where('active', 'Y'); 
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
        $customers = null;
        $vendors = null;
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
        else if(!empty($vendorId))
        {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })->get(); 
           
            $customers = Customer::
                         join('vendor_customer', 'vendor_customer.customer_id', '=', 'customer.id')
                        ->where('vendor_customer.vendor_id',$vendorId)
                        ->where('active', 'Y')
                        ->get();
            
        } else {
            //$departments = null;
            //$clients = null;
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
            $clients = Mcu::selectRaw('distinct(client) as client')->get();
            $vendors = $v->get();
            $customers = $c->get();
        }

        return $this->view('reports.all-diagnosis-dkk', 'Diagnosis DKK','Diagnosis DKK', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }


    // Graphic
    public function reportTopTenDiagnosisData(Request $request)
    {
        // Initial empty where
        $mcuWhere = "";

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		 // Check is has customer
        if(!empty(session()->get('user.vendor_id'))) {
            $customerId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$customerId;
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$mcuWhere .= " AND vc.vendor_id=".$idVendor;
			}
        }
		if(session()->get('user.user_group_id')==2){ //vendor
			
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}
		
		}

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

        $m = DB::select("SELECT COUNT(d.id) AS total, ri.code, ri.name
            FROM (
                SELECT d.id, d.recommendation_id
                FROM diagnoses d
                JOIN (
                    SELECT m.id
                    FROM mcu m
                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                    WHERE 1=1 ".$mcuWhere."
                ) m ON d.mcu_id=m.id
				where d.deleted='0'
            ) d
            JOIN (
                SELECT r.id AS rid, i.id, i.code, i.name
                FROM recommendations r
                JOIN icd10s i ON r.icd10_id=i.id
            ) ri ON d.recommendation_id=ri.rid
            GROUP BY ri.code, ri.name
            ORDER BY total DESC
            LIMIT 10"
        );

        return response()->json($m);
    }


    // Report Datatables
    public function reportTopTenDiagnosisDatatables(Request $request)
    {
        // Initial empty where
        /*
		$mcuWhere = "";

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		   // Check is has vendor
		 if(!empty(session()->get('user.vendor_id'))) {
            $customerId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$customerId;
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$mcuWhere .= " AND vc.vendor_id=".$idVendor;
			}
        }
		
		if(session()->get('user.user_group_id')==2){ //vendor
		
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

		}
	
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }
		*/
		
		$mcuWhere = $this->sqlwheretopten($request);
		
        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];
		
		$m = $this->sqltopten($mcuWhere,$orderColumn,$orderDir);

       /*  $m = DB::select("SELECT COUNT(d.id) AS total, ri.id, ri.code, ri.name
            FROM (
                SELECT d.id, d.recommendation_id
                FROM diagnoses d
                JOIN (
                    SELECT m.id
                    FROM mcu m
                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                    WHERE 1=1 ".$mcuWhere."
                ) m ON d.mcu_id=m.id
				where d.deleted = '0'
            ) d
            JOIN (
                SELECT r.id AS rid, i.id, i.code, i.name
                FROM recommendations r
                JOIN icd10s i ON r.icd10_id=i.id
            ) ri ON d.recommendation_id=ri.rid
            GROUP BY ri.id, ri.code, ri.name
            ORDER BY ".$orderColumn." ".$orderDir."
            LIMIT 10"
        ); */

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => count($m),
            'recordsFiltered'   => count($m),
            'data'              => $m,
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
	
	public function sqlwheretopten($request){
		 $mcuWhere  = '';
        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		   // Check is has vendor
		 if(!empty(session()->get('user.vendor_id'))) {
            $customerId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$customerId;
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$mcuWhere .= " AND vc.vendor_id=".$idVendor;
			}
        }
		
		if(session()->get('user.user_group_id')==2){ //vendor
		
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

		}
	
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }
		
		return $mcuWhere;
	}
	
	public function sqltopten($mcuWhere,$orderColumn,$orderDir)
	{
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
				where d.deleted = '0'
            ) d
            JOIN (
                SELECT r.id AS rid, i.id, i.code, i.name
                FROM recommendations r
                JOIN icd10s i ON r.icd10_id=i.id
            ) ri ON d.recommendation_id=ri.rid
            GROUP BY ri.id, ri.code, ri.name
            ORDER BY ".$orderColumn." ".$orderDir."
            LIMIT 10"
        );
		
		return $m;
	}

    public function reportDiagnosisDetailDkk($code, $total, $parentMenu = 'All Diseases Dkk', $filter=null)
    {
        $icd = Icd10::where('code', $code)->first();
        //$customers = Customer::where('active', 'Y')->get();
        //$vendors = Vendor::where('active', 'Y')->get();
        //$customerId = session()->get('user.customer_id');
        //-----
        $vc = VendorCustomer::with(['customer','vendor']);
        $c = Customer::where('active', 'Y');
        $v = Vendor::where('active', 'Y'); 
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
        $customers = null;
        $vendors = null;
        $departments = null;
        $clients = null;
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
        else if(!empty($vendorId))
        {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })->get(); 
           
            $customers = Customer::
                         join('vendor_customer', 'vendor_customer.customer_id', '=', 'customer.id')
                        ->where('vendor_customer.vendor_id',$vendorId)
                        ->where('active', 'Y')
                        ->get();
            
        } else {
            
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
            $clients = Mcu::selectRaw('distinct(client) as client')->get();
            $vendors = $v->get();
            $customers = $c->get();
        }
        
        
        
        
    
        $R = str_replace("#","",$filter);
        $R = str_replace("'","*",$R);
        $R = str_replace('*','"',$R);
        $filter2 = json_decode($R); 
    
        //$ar_wh = array()
        return $this->view('reports.diagnosis-detail-dkk','Diagnosis DKK Detail','Diagnosis DKK Detail', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients,
            'code' => $code,
            'diagnosis' => $icd->name,
            'total' => $total,
            'parentMenu' => $parentMenu,
            'perusahaan'=> $filter2->perusahaan, 
            'vendor'=> $filter2->vendor, 
            'klient'=> trim($filter2->client), 
            'sex' =>$filter2->sex, 
            'startDate' => $filter2->startDate,
            'endDate'=> $filter2->endDate,
            'wh_id'=> $filter2->penyakit,
            'wh'=> ($filter2->penyakit) ? \App\Helpers\Report::getWh($filter2->penyakit) : null
            
            
            
        ]);
    }

	public function reportDiagnosisDetail($code, $total, $parentMenu = 'Top 10 Diseases', $filter=null)
    {
        $icd = Icd10::where('code', $code)->first();
        //$customers = Customer::where('active', 'Y')->get();
        //$vendors = Vendor::where('active', 'Y')->get();
        //$customerId = session()->get('user.customer_id');
		//-----
		$vc = VendorCustomer::with(['customer','vendor']);
		$c = Customer::where('active', 'Y');
        $v = Vendor::where('active', 'Y'); 
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
		$customers = null;
		$vendors = null;
		$departments = null;
        $clients = null;
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendorId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })->get(); 
           
			$customers = Customer::
						 join('vendor_customer', 'vendor_customer.customer_id', '=', 'customer.id')
						->where('vendor_customer.vendor_id',$vendorId)
						->where('active', 'Y')
						->get();
			
		} else {
            
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
			$vendors = $v->get();
			$customers = $c->get();
        }
		
		
        
		
	
		$R = str_replace("#","",$filter);
		$R = str_replace("'","*",$R);
		$R = str_replace('*','"',$R);
		$filter2 = json_decode($R); 
	
        return $this->view('reports.diagnosis-detail','Diagnosis detail','Diagnosis detail', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients,
			'code' => $code,
			'diagnosis' => $icd->name,
			'total' => $total,
            'parentMenu' => $parentMenu,
            'perusahaan'=> $filter2->perusahaan, 
			'vendor'=> $filter2->vendor, 
			'klient'=> trim($filter2->client), 
			'sex' =>$filter2->sex, 
			'startDate' => $filter2->startDate,
			'endDate'=> $filter2->endDate
			
			
        ]);
    }

	public function reportDiseasesDatatables(Request $request)
    {
        $m = Mcu::with('vendorCustomer');

		$code = $request->code;
		$m =  $m->whereHas('diagnosis.recommendation.icd10', function($q) use ($code) {
            $q->where('code', $code);
        });
		
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

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2){ //vendor
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}
		
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        //$m->orderBy($orderColum, $orderDir);
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

    public function reportDiseasesDatatablesDkk(Request $request)
    {
        $m = Mcu::with('vendorCustomer');

        $code = $request->code;
        $wh = $request->penyakit;
        
      

        $m = $m->whereHas('diagnosis.recommendation', function($q) use ($code,$wh) {
              if($wh!='')
              {
                 $q->where('work_health_id', $wh);
              }
             
              $q->whereHas('icd10',function($v) use ($code){
                    $v->where('code', $code);
              });
        });
        
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

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }
        if(session()->get('user.user_group_id')==1) { //admin 
            // Filter Id Perusahaan
            if($request->idPerusahaan != '') {
                $idPerusahaan = $request->idPerusahaan;
                $m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
                    $q->where('id', $idPerusahaan);
                });
            }

            // Filter Id Vendor
            if($request->idVendor != '') {
                $idVendor = $request->idVendor;
                $m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
                    $q->where('id', $idVendor);
                });
            }
        }
        if(session()->get('user.user_group_id')==2){ //vendor
            // Filter Id Perusahaan
            if($request->idPerusahaan != '') {
                $idPerusahaan = $request->idPerusahaan;
                $m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
                    $q->where('id', $idPerusahaan);
                });
            }
        
        }
        
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
        $m->select('mcu.id','mcu.nama_pasien','mcu.no_nip','mcu.tgl_lahir','mcu.tgl_input','mcu.jenis_kelamin','mcu.bagian','mcu.jenis_kelamin');
        
        $recordFiltered = $m->count();
        $m->groupBy('mcu.id','mcu.nama_pasien','mcu.no_nip','mcu.tgl_lahir','mcu.tgl_input','mcu.jenis_kelamin','mcu.bagian','mcu.jenis_kelamin');


        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        //$m->orderBy($orderColum, $orderDir);
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

	public function sqlAllDis(Request $request)
	{
		$mcuWhere = "";
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            //$customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $customerId = session()->get('user.customer_id');
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            //$vendorId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $vendorId = session()->get('user.vendor_id');
            $mcuWhere .= " AND vc.vendor_id=".$vendorId;
        }

		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$mcuWhere .= " AND vc.vendor_id=".$idVendor;
			}
		
		}
		
		if(session()->get('user.user_group_id')==2){ //vendor
				
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}
				
					
		}

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

		return $mcuWhere;

	}

    public function reportAllDiagnosisDatatables(Request $request)
    {
        // Initial empty where
        $mcuWhere = "";

		// Initial Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];

        // Records totals
        $recordsTotalSQL = $this->createAllDiagnosisSQL($orderColumn, $orderDir, null, null, null);
        $recordsTotal = DB::select("SELECT COUNT(*) AS total FROM (".$recordsTotalSQL.") rt");

        $mcuWhere = $this->sqlAllDis($request);

        // Records filtered
        $recordsFilteredSQL = $this->createAllDiagnosisSQL($orderColumn, $orderDir, $mcuWhere, null, null);
        $recordsFiltered = DB::select("SELECT COUNT(*) AS total FROM (".$recordsFilteredSQL.") rf");
        //print_r($recordsFilteredSQL);
        // Records Paging
        $recordsFilteredPagingSQL = $this->createAllDiagnosisSQL($orderColumn, $orderDir, $mcuWhere, $request->start, $request->length);
        $recordsPaging =  DB::select($recordsFilteredPagingSQL);
       // $recordsPaging = $this->reportService->getSummaryReport();// DB::select($recordsFilteredPagingSQL);
       

        // $recordsPaging  = Cache::remember('diagnosis_report_all_diseases', 3600, function () use($recordsFilteredPagingSQL) {
        //     //return app(DiagnosisReportService::class)->getSummaryReport();
        //     return  DB::select($recordsFilteredPagingSQL);
        // });
        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordsTotal[0]->total,
            'recordsFiltered'   => $recordsFiltered[0]->total,
            'data'              => $recordsPaging,
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
	
    public function reportAllDiagnosisDatatablesDkk(Request $request) //ali
    {
        // Initial empty where
        $mcuWhere = "";
        $where2 = "";


        if($request->wh != '') {
            $wh = $request->wh;
            $where2 .= " and r2.work_health_id='".$wh."'";
        }

        if($request->code != '') {
            $code = $request->code;
            $where2 .= " and is2.code='".$code."'";
        }

        if($request->nameCode != '') {
            $nameCode = $request->nameCode;
            $where2 .= " and is2.name like'%".$nameCode."%'";
        }

        // Initial Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];

        // Records totals
        $recordsTotalSQL = $this->createAllDiagnosisSQLDkk($orderColumn, $orderDir, null, null, null,$where2);
        $recordsTotal = DB::select("SELECT COUNT(*) AS total FROM (".$recordsTotalSQL.") rt");

        $mcuWhere = $this->sqlAllDisDkk($request);

        // Records filtered
        $recordsFilteredSQL = $this->createAllDiagnosisSQLDkk($orderColumn, $orderDir, $mcuWhere, null, null,$where2);
        $recordsFiltered = DB::select("SELECT COUNT(*) AS total FROM (".$recordsFilteredSQL.") rf");
        //print_r($recordsFilteredSQL);
        // Records Paging
        $recordsFilteredPagingSQL = $this->createAllDiagnosisSQLDkk($orderColumn, $orderDir, $mcuWhere, $request->start, $request->length,$where2);
        $recordsPaging = DB::select($recordsFilteredPagingSQL);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordsTotal[0]->total,
            'recordsFiltered'   => $recordsFiltered[0]->total,
            'data'              => $recordsPaging,
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

    public function sqlAllDisDkk(Request $request)
    {
        $mcuWhere = "";
        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            //$customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $customerId = session()->get('user.customer_id');
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
        
        // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            //$vendorId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $vendorId = session()->get('user.vendor_id');
            $mcuWhere .= " AND vc.vendor_id=".$vendorId;
        }

        if(session()->get('user.user_group_id')==1) { //admin 
            // Filter Id Perusahaan
            if($request->idPerusahaan != '') {
                $idPerusahaan = $request->idPerusahaan;
                $mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
            }

            // Filter Id Vendor
            if($request->idVendor != '') {
                $idVendor = $request->idVendor;
                $mcuWhere .= " AND vc.vendor_id=".$idVendor;
            }
        
        }
        
        if(session()->get('user.user_group_id')==2){ //vendor
                
            // Filter Id Perusahaan
            if($request->idPerusahaan != '') {
                $idPerusahaan = $request->idPerusahaan;
                $mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
            }
                
                    
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

        return $mcuWhere;

    }

    private function createAllDiagnosisSQLDkk($orderColumn, $orderDir, $where = null, $take = null, $limit = null, $where2 = null)
    {
        if($orderColumn == null and $orderDir == null)
        {
            $op = "";
        }
        else
        {
            // $op = "ORDER BY ".$orderColumn." ".$orderDir;
            $op = "";
        }
        // join work_healths  on work_healths.id = d.work_health_id
        // 
        $SQL = "select d.*, 
            IFNULL(laki.totalLaki,0) AS TL, 
            d.total - IFNULL(laki.totalLaki,0) AS TP, 
            IFNULL(atas40.total40,0) AS atas_empatpuluh,    
            IFNULL(under30.total30,0) AS bawah_tigapuluh,
            d.total - (IFNULL(atas40.total40,0) + IFNULL(under30.total30,0)) AS tigapuluh_sd_empatpuluh,
            work_healths.name as nameWH 
           
    
      from        
        (
             select count(*) as total, s.name, s.idC, s.code,s.work_health_id from 
                (
                    select  b.idC, b.code, b.name, b.work_health_id,m.id from mcu m         
                    inner join(
                        select d.mcu_id,r2.work_health_id, is2.name,is2.id as idC, is2.code FROM diagnoses d 
                        join recommendations r2 on r2.id=d.recommendation_id 
                        join icd10s is2 on is2.id =r2.icd10_id 
                        where 
                            r2.deleted = 0 and r2.active = 1 and d.deleted =0 ".$where2." 
                    ) b on b.mcu_id=m.id
                    join vendor_customer vc on vc.id = m.vendor_customer_id 
                    join customer c on c.id = vc.customer_id
                    where 1=1 ".$where."
                    -- group by m.id,b.work_health_id 
                    
                    
               )s group by s.idC,s.name,s.code,s.work_health_id
               
      )as d

      join work_healths  on work_healths.id = d.work_health_id
     
      
      left join (
            
            select count(*) as totalLaki, s.name, s.idC from 
                (
                    select  b.idC, b.code,b.name from mcu m         
                    inner join(
                        select d.mcu_id,r2.work_health_id, is2.name,is2.id as idC, is2.code FROM diagnoses d 
                        join recommendations r2 on r2.id=d.recommendation_id 
                        join icd10s is2 on is2.id =r2.icd10_id 
                        where 
                        
                         r2.deleted = 0 and r2.active = 1 and d.deleted =0 ".$where2."
                    ) b on b.mcu_id=m.id
                    join vendor_customer vc on vc.id = m.vendor_customer_id 
                    join customer c on c.id = vc.customer_id
                    where 1=1 and m.jenis_kelamin='L' ".$where."
                   
                    
               )s group by s.idC,s.name
      
      )as laki on laki.idC = d.idC
      
      
     
      
      
       left join (
            
            select count(*) as total40, s.name, s.idC from 
                (
                    select  b.idC, b.code,b.name from mcu m         
                    inner join(
                        select d.mcu_id,r2.work_health_id, is2.name,is2.id as idC, is2.code FROM diagnoses d 
                        join recommendations r2 on r2.id=d.recommendation_id 
                        join icd10s is2 on is2.id =r2.icd10_id 
                        where 
                        
                         r2.deleted = 0 and r2.active = 1 and d.deleted =0 ".$where2."
                    ) b on b.mcu_id=m.id
                    join vendor_customer vc on vc.id = m.vendor_customer_id 
                    join customer c on c.id = vc.customer_id
                    where TIMESTAMPDIFF(YEAR, m.tgl_lahir, m.tgl_input) > 40 ".$where."
                   
                    
               )s group by s.idC,s.name
      
      )as atas40 on atas40.idC = d.idC
      
      left join (
            
            select count(*) as total30, s.name, s.idC from 
                (
                    select  b.idC, b.code,b.name from mcu m         
                    inner join(
                        select d.mcu_id,r2.work_health_id, is2.name,is2.id as idC, is2.code FROM diagnoses d 
                        join recommendations r2 on r2.id=d.recommendation_id 
                        join icd10s is2 on is2.id =r2.icd10_id 
                        where 
                         
                         r2.deleted = 0 and r2.active = 1 and d.deleted =0 ".$where2."
                    ) b on b.mcu_id=m.id
                    join vendor_customer vc on vc.id = m.vendor_customer_id 
                    join customer c on c.id = vc.customer_id
                    where  TIMESTAMPDIFF(YEAR, m.tgl_lahir, m.tgl_input) < 30 ".$where."
                   
                    
               )s group by s.idC,s.name
      
      )as under30 on under30.idC = d.idC

      order by d.total desc
      
      
      ";

      
     


        if($take != null && $limit != null) {
            $SQL .= " LIMIT ".$take.",".$limit;
        }
        //echo $SQL;
        return $SQL;
    }


    private function createAllDiagnosisSQL($orderColumn, $orderDir, $where = null, $take = null, $limit = null)
    {
        //echo $orderColumn;echo"--";echo $orderDir; //total--desctotal--desctotal--desc
        //echo $orderColumn; //totaltotaltotal
		//echo $orderDir; //descdescdesc
        
		if($orderColumn == null and $orderDir == null)
		{
			$op = "";
		}
        else
		{
			$op = "ORDER BY ".$orderColumn." ".$orderDir;
		}
        //echo $op;

		/*$SQL = "SELECT COUNT(ri.id) AS total, ri.id, ri.code, ri.name
        FROM (
            SELECT d.id, d.recommendation_id
            FROM diagnoses d
            JOIN (
                SELECT m.id
                FROM mcu m
                JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                WHERE 1=1 ".$where."
            ) m ON d.mcu_id=m.id
			where d.deleted = '0'
        ) d 
        JOIN (
            SELECT r.id AS rid, i.id, i.code, i.name
            FROM recommendations r
            JOIN icd10s i ON r.icd10_id=i.id
        ) ri ON d.recommendation_id=ri.rid
        GROUP BY ri.id, ri.code, ri.name ".$op;
		*/
	$SQL = "select 
                    a.*,
                      IFNULL(b.TL,0) AS TL,
                      (a.total - IFNULL(b.TL,0)) as TP,
                       IFNULL(c.bawah_tigapuluh,0) AS bawah_tigapuluh,
                       IFNULL(cc.atas_empatpuluh,0) AS atas_empatpuluh,
                        IFNULL(a.total - (
                          IFNULL(c.bawah_tigapuluh,0) + IFNULL(cc.atas_empatpuluh,0) 
                        ),0)
                       as tigapuluh_sd_empatpuluh 
		    from (
			SELECT COUNT(ri.id) as total, ri.id, ri.code, ri.name
			FROM (
            SELECT d.id, d.recommendation_id
            FROM diagnoses d
            JOIN (
                SELECT m.id
                FROM mcu m
                JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                WHERE 1=1 ".$where."
            ) m ON d.mcu_id=m.id
			where d.deleted = '0'
        ) d 
        JOIN (
            SELECT r.id AS rid, i.id, i.code, i.name
            FROM recommendations r
            JOIN icd10s i ON r.icd10_id=i.id
        ) ri ON d.recommendation_id=ri.rid
        GROUP BY ri.id, ri.code, ri.name ".$op."
	) a

	left join(SELECT COUNT(ri2.id) as TL, ri2.code
        FROM (
            SELECT d.id, d.recommendation_id
            FROM diagnoses d
            JOIN (
                SELECT m.id
                FROM mcu m
                JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                WHERE 1=1 and m.jenis_kelamin='L' ".$where."
            ) m ON d.mcu_id=m.id
			where d.deleted = '0'
        ) d2 
        JOIN (
            SELECT r.id AS rid, i.id, i.code, i.name
            FROM recommendations r
            JOIN icd10s i ON r.icd10_id=i.id
        ) ri2 ON d2.recommendation_id=ri2.rid
        GROUP BY  ri2.code) b on b.code = a.code
		left join( SELECT COUNT(ri2.id) as bawah_tigapuluh, ri2.code
        FROM (
            SELECT d.id, d.recommendation_id
            FROM diagnoses d
            JOIN (
                SELECT m.id  
                FROM mcu m
                JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                WHERE 1=1 and TIMESTAMPDIFF(YEAR, tgl_lahir, tgl_input) < 30  ".$where."
            ) m ON d.mcu_id=m.id
			where d.deleted = '0'
        ) d2 
        JOIN (
            SELECT r.id AS rid, i.id, i.code, i.name
            FROM recommendations r
            JOIN icd10s i ON r.icd10_id=i.id
        ) ri2 ON d2.recommendation_id=ri2.rid
        GROUP BY  ri2.code) c on c.code = a.code
		
		left join( SELECT COUNT(ri2.id) as atas_empatpuluh, ri2.code
        FROM (
            SELECT d.id, d.recommendation_id
            FROM diagnoses d
            JOIN (
                SELECT m.id  
                FROM mcu m
                JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                WHERE 1=1 and TIMESTAMPDIFF(YEAR, tgl_lahir, tgl_input) > 40  ".$where."
            ) m ON d.mcu_id=m.id
			where d.deleted = '0'
        ) d2 
        JOIN (
            SELECT r.id AS rid, i.id, i.code, i.name
            FROM recommendations r
            JOIN icd10s i ON r.icd10_id=i.id
        ) ri2 ON d2.recommendation_id=ri2.rid
        GROUP BY  ri2.code) cc on cc.code = a.code";
		
		


        if($take != null && $limit != null) {
            $SQL .= " LIMIT ".$take.",".$limit;
        }
        //echo $SQL;
        return $SQL;
    }

	function export(Request $request)
    {
		
		$mcuWhere = $this->sqlwheretopten($request);
		$data = $this->sqltopten($mcuWhere,'total','desc');
		
		return Excel::download(new CollectionExportDiagnosisTen($data), 'report-diagnoses-top-ten.xlsx');
    }

    function export_all_diseases_dkk(Request $request)
    {

        $where2 = "";
        if($request->id_wh != '') {
            $id_wh = $request->id_wh;
            $where2 .= " and r2.work_health_id='".$id_wh."'";//kaprok
        }

        if($request->code != '') {
            $code = $request->code;
            $where2 .= " and is2.code='".$code."'";
        }

        if($request->nameCode != '') {
            $nameCode = $request->nameCode;
            $where2 .= " and is2.name like'%".$nameCode."%'";
        }

        $mcuWhere = $this->sqlAllDisDkk($request);//alay
        $p = $this->createAllDiagnosisSQLDkk('total', 'desc', $mcuWhere, null, null, $where2);
        $data = DB::select($p);
        //$wh_name = \App\Helpers\Report 
        return Excel::download(new CollectionExportAllDiseasesDkk($data), 'report-all-diseases-dkk.xlsx');
    }

	function export_all_diseases(Request $request)
	{

		$mcuWhere = $this->sqlAllDis($request);//alay
		$p = $this->createAllDiagnosisSQL('total', 'desc', $mcuWhere, null, null);
        $data = DB::select($p);

		return Excel::download(new CollectionExportAllDiseases($data), 'report-all-diseases.xlsx');
	}
	
	public function reportAllDiagnosisKerjaDatatables(Request $request)
    {
       // Initial empty where
        $mcuWhere = "";
        $topWhere = "";

        // Initial Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];

        // Records totals
        $recordsTotalSQL = $this->createWHDSQL($orderColumn, $orderDir, $topWhere, null, null, null, null);
        $recordsTotal = DB::select("SELECT COUNT(*) AS total FROM (".$recordsTotalSQL.") rt");

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$vendor_id;
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			 if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan; //str_pad($request->idPerusahaan, 4, 0, 0); //$request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			 }

			// Filter Id Vendor
			 if($request->idVendor != '') {
				 $idVendor = $request->idVendor;//str_pad($request->idVendor, 4, 0, 0); //$request->idVendor;
				 $mcuWhere .= " AND vc.vendor_id=".$idVendor;
			 }
		}
		
		if(session()->get('user.user_group_id')==2){ //vendor
			
			 if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			 }
		
		}
        // Filter Client
        //if($request->client != '') {
          //  $client = $request->client;
            //$mcuWhere .= " AND m.client='".$client."'";
        //}

        // Filter ID pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $mcuWhere .= "AND substring(m.id, 13, 8) = '".$idPasien."'";
        }

        // Filter NIK
        //if($request->nip != '') {
          //  $nik = $request->nip;
            //$mcuWhere .= " AND m.no_nip = '".$nik."'";
        //}

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $mcuWhere .= " AND m.nama_pasien like '%".$name."%'";
        }

        // Filter Tgl lahir
        // if($request->tglLahir != '') {
            // $tglLahir = $request->tglLahir;
            // $mcuWhere .= " AND m.tgl_lahir = '".$tglLahir."'";
        // }

        // Filter Sex
        // if($request->sex != '') {
            // $sex = $request->sex;
            // $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        // }

        // Filter Bagian
        // if($request->bagian != '') {
            // $bagian = $request->bagian;
            // $mcuWhere .= " AND m.bagian='".$bagian."'";
        // }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

        // Filter Bagian
        // if($request->bagian != '') {
            // $bagian = $request->bagian;
            // $mcuWhere .= " AND m.bagian='".$bagian."'";
        // }

        // Filter Diagnosis
        // if($request->diagnosis != '') {
            // $diagnosis = $request->diagnosis;
            // $topWhere .= " AND wh_id='".$diagnosis."'";
        // }

        // Records filtered
        $recordsFilteredSQL = $this->createWHDSQL($orderColumn, $orderDir, $mcuWhere, $topWhere, null, null, null);
        $recordsFiltered = DB::select("SELECT COUNT(*) AS total FROM (".$recordsFilteredSQL.") rf");

        // Records Paging
        $recordsFilteredPagingSQL = $this->createWHDSQL($orderColumn, $orderDir, $mcuWhere, $topWhere, $request->start, $request->length, false);
        $recordsPaging = DB::select($recordsFilteredPagingSQL);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordsTotal[0]->total,
            'recordsFiltered'   => $recordsFiltered[0]->total,
            'data'              => $recordsPaging,
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
	
	 private function createWHDSQL($orderColumn, $orderDir, $where = null, $topWhere = null, $take = null, $limit = null, $group = false)
    {
        $fields = "m.id, CAST(substring(m.id, 13, 8) AS UNSIGNED) AS id_pasien, m.nama_pasien, m.tgl_input, wh.id AS wh_id, wh.name AS wh_name, icd.name AS penyakit ";
        $orderOrGroup = " ORDER BY ".$orderColumn." ".$orderDir;

		if($group) {
            $fields = "wh.id AS wh_id, wh.name AS wh_name, COUNT(wh.id) AS total, wh.recommendation ";
            $orderOrGroup = " GROUP BY wh.id, wh.name";
        }

        $SQL = "SELECT ".$fields."
        FROM (
            SELECT m.*
            FROM mcu m
            JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
            WHERE 1=1 ".$where."
        ) m
        JOIN (
            SELECT d.mcu_id, r.work_health_id AS wh_id,r.icd10_id
            FROM (
                SELECT mcu_id, recommendation_id
                FROM diagnoses
                WHERE mcu_id IN (
                    SELECT m.id
                    FROM mcu m
                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                    WHERE 1=1 ".$where."
                ) AND deleted = '0'
            ) d
            JOIN (
                SELECT id, work_health_id, icd10_id
                FROM recommendations r
                WHERE id IN (
                    SELECT recommendation_id
                    FROM diagnoses
					where deleted = '0'
                    GROUP BY recommendation_id
                )
            ) r ON d.recommendation_id=r.id
           
        ) d ON m.id=d.mcu_id
       JOIN work_healths wh ON d.wh_id=wh.id
       JOIN icd10s icd ON icd.id=d.icd10_id
      
        WHERE 1=1 "
        .$topWhere
        .$orderOrGroup;
		// 
        if($take != null && $limit != null) {
            $SQL .= " LIMIT ".$take.",".$limit;
        }

        return $SQL;
    }
	
	public function reportWorkHealthDiagnosisDatatables(Request $request)
    {
		
		$m = Mcu::with(['vendorCustomer']); //'diagnosis.recommendation.workHealth' 
		//$m = Mcu::with(['vendorCustomer','diagnosis.recommendations.workHealth'  => function($q) {
			
		//}]); 
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

				if($request->idPasien != '') {
					$idPasien = str_pad($request->idPasien, 8, 0, 0);
					$m->whereRaw('substring(mcu.id, 13, 8) = '.$idPasien);
				}

				// Filter NIK
				if($request->nip != '') {
					$nik = $request->nip;
					$m->where('no_nip', $nik);
				}

				// Filter Tgl lahir
				if($request->tglLahir != '') {
					$tglLahir = $request->tglLahir;
					$m->where('tgl_lahir', $tglLahir);
				}

				// Filter LP
				if($request->sex != '') {
					$lp = $request->sex;
					$m->where('jenis_kelamin', $lp);
				}

				// Filter Name
				if($request->nama != '') {
					$name = $request->nama;
					$m->where('nama_pasien', 'like', '%'.$name.'%');
				}

				// Filter Id bagian
				if($request->bagian != '') {
					$bagian = $request->bagian;
					$m->where('bagian', $bagian);
				}

				// Filter Client
				if($request->client != '') {
					$client = $request->client;
					$m->where('client', $client);
				}

				// Filter diagnosis
				if($request->diagnosis != '') {
					$diagnosis = $request->diagnosis;
					
					 /*$m->join('diagnoses', 'diagnoses.mcu_id', '=', 'mcu.id')
						->join('recommendations', 'recommendations.id', '=', 'diagnoses.recommendation_id')
					  ->join('work_healths', 'work_healths.id', '=', 'recommendations.work_health_id')
					  ->where('work_healths.id',$diagnosis) 
					  ->where('recommendations.deleted','0')
					  ->where('diagnoses.deleted','0')
					  ->orderBy('work_healths.sequence','desc');
                      */
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
                  })->join('work_healths', 'work_healths.id', '=', 'd.wh_id');
                  $m->where('work_healths.id',$diagnosis);
                  
				}
				else
				{
					 // $m->join('diagnoses', 'diagnoses.mcu_id', '=', 'mcu.id')
					// 	->join('recommendations', 'recommendations.id', '=', 'diagnoses.recommendation_id')
					 //  ->join('work_healths', 'work_healths.id', '=', 'recommendations.work_health_id')
                     //  ->where('recommendations.deleted','0')
					 //   ->where('diagnoses.deleted','0')
					 //  ->orderBy('work_healths.sequence','desc');
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
                  })->join('work_healths', 'work_healths.id', '=', 'd.wh_id');
				}

				// Filter Id Perusahaan
				//if($request->idPerusahaan != '') {
				//	$idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
				//	$m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
				//}
				
				if(session()->get('user.user_group_id')==1) { //admin 
				
					if($request->idPerusahaan != '') {
						$idPerusahaan = $request->idPerusahaan;
						$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
							$q->where('id', $idPerusahaan);
						});
					} 

					// Filter Id Vendor
					if($request->idVendor != '') {
						$idVendor = $request->idVendor;
						$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
							$q->where('id', $idVendor);
						});
					}
				
				}
		
				if(session()->get('user.user_group_id')==2){ //vendor
						
					if($request->idPerusahaan != '') {
						$idPerusahaan = $request->idPerusahaan;
						$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
							$q->where('id', $idPerusahaan);
						});
					} 
					
				}
				
				

				// Filter Date
				if($request->startDate != '') {
					$startDate = date('Ymd', strtotime($request->startDate));
					$m->whereRaw('substring(mcu.id, 1, 8) >= '.$startDate);
				}
				if($request->endDate != '') {
					$endDate = date('Ymd', strtotime($request->endDate));
					$m->whereRaw('substring(mcu.id, 1, 8) <= '.$endDate);
				}


		if($request->diagnosis != '') {
			$m1 = $m->select('mcu.id as id','no_nip','nama_pasien','tgl_lahir','jenis_kelamin','bagian','tgl_input','work_healths.name as diagnosis','work_healths.id as IDW')->groupBy('mcu.id','no_nip','tgl_lahir','nama_pasien','jenis_kelamin','bagian','tgl_input','work_healths.name','work_healths.id'); //'work_healths.name','work_healths.id'
			$recordFiltered = $m1->get()->count();
			
		}
		else
		{
			$m1 = $m->select('mcu.id as id','no_nip','nama_pasien','tgl_lahir','jenis_kelamin','bagian','tgl_input','work_healths.name as diagnosis','work_healths.id as IDW')->
			groupBy('mcu.id','no_nip','tgl_lahir','nama_pasien','jenis_kelamin','bagian','tgl_input','work_healths.name','work_healths.id'); //
            $recordFiltered = $m1->get()->count();
			//$recordTotal = $m->count();
		}
		
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

	function exportDetaildiagnosis(Request $request)
    {

		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        $code = $request->code;

        return Excel::download(new McuReportExportDetailDiagnosis($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate,
												   $code
												   ), 'report-mcu-detail-diagnosis.xlsx');
    }
	
	function reportStatistikaDetail($tabel, $nilai, $total, $parentMenu, $filter=null)
	{
		 //$icd = Icd10::where('code', $code)->first();
        //$customers = Customer::where('active', 'Y')->get();
        //$vendors = Vendor::where('active', 'Y')->get();
        //$customerId = session()->get('user.customer_id');
		//-----
		$vc = VendorCustomer::with(['customer','vendor']);
		$c = Customer::where('active', 'Y');
        $v = Vendor::where('active', 'Y'); 
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
		$customers = null;
		$vendors = null;
		$departments = null;
        $clients = null;
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendorId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })->get(); 
           
			$customers = Customer::
						 join('vendor_customer', 'vendor_customer.customer_id', '=', 'customer.id')
						->where('vendor_customer.vendor_id',$vendorId)
						->where('active', 'Y')
						->get();
			
		} else {
            
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
			$vendors = $v->get();
			$customers = $c->get();
        }
		
		
        
		/*
		if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        } else {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                //->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                  //  $q->where('id', $customerId);
                //})
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                //->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                  //  $q->where('id', $customerId);
                //})
                ->get();
        }*/
	
		$R = str_replace("#","",$filter);
		$R = str_replace("'","*",$R);
		$R = str_replace('*','"',$R);
		$filter2 = json_decode($R); 
	
        return $this->view('reports.statistika-detail','Statistika Detail','Statistika Detail', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients,
			'tabel' => $tabel,
			'nilai' => $nilai,
			'total' => $total,
            'parentMenu' => $parentMenu,
            'perusahaan'=> $filter2->perusahaan, 
			'vendor'=> $filter2->vendor, 
			'klient'=> trim($filter2->client), 
			//'sex' =>$filter2->sex, 
			'startDate' => $filter2->startDate,
			'endDate'=> $filter2->endDate
			
			
        ]);
	}
	
	public function reportStatistikaDetailDatatables(Request $request)
    {
        $m = Mcu::with('vendorCustomer');

		
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
		
		if($request->tabel=='paket')
		{
			 $m->where('paket_mcu', $request->nilai);
            
		}
		else if($request->tabel=='bagian')
		{
			 $m->where('bagian', $request->nilai);
		}	
		else if($request->tabel=='client')
		{
			 $m->where('client', $request->nilai);
		}	
		

        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2){ //vendor
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}
		
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        //$m->orderBy($orderColum, $orderDir);
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

	function exportDetailStatistika(Request $request)
    {

		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        $tabel = $request->tabel;
        $nilai = $request->nilai;

        return Excel::download(new McuReportExportDetailStatistika($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate,
												   $tabel,
												   $nilai
												   ), 'report-mcu-detail-statistik.xlsx');
    }

    function exportDetaildiagnosisDkk(Request $request)
    {

        $idPasien = $request->idPasien;
        $nama = $request->nama;
        $nip = $request->nip;
        $tglLahir = $request->tglLahir;
        $lp = $request->lp;
        $bagian = $request->bagian;
        $idPerusahaan = $request->idPerusahaan;
        $idVendor = $request->idVendor;
        $client = $request->client;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $code = $request->code;
        $id_wh = $request->id_wh;

        return Excel::download(new McuReportExportDetailDiagnosisDkk($idPasien,
                                                   $nama,
                                                   $nip,
                                                   $tglLahir,
                                                   $lp,
                                                   $bagian,
                                                   $idPerusahaan,
                                                   $idVendor,
                                                   $client,
                                                   $startDate,
                                                   $endDate,
                                                   $code,
                                                   $id_wh
                                                   ), 'report-mcu-detail-diagnosis-dkk.xlsx');
    }
	

}
