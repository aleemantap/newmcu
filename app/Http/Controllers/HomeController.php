<?php

namespace App\Http\Controllers;

use App\Models\Mcu;
use App\Models\Parameter;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Dompdf\Options;

class HomeController extends Controller
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
        if(session()->get('user.user_group_id')==2) // vendor
		{
			
			
			$totalTransaction = Mcu::whereHas('vendorCustomer', function($q){
						$q->where('vendor_id', session()->get('user.vendor.id'));
					})->count(); 
			
			$totalPatient = Mcu::selectRaw('count(distinct(concat(nama_pasien,tgl_lahir,jenis_kelamin))) as total')
			
			->whereHas('vendorCustomer', function($q){
						$q->where('vendor_id', session()->get('user.vendor.id'));
					})
			
			->first()->total;
			$totalPacket = Mcu::selectRaw('count(distinct(paket_mcu)) as total')
			->whereHas('vendorCustomer', function($q){
						$q->where('vendor_id', session()->get('user.vendor.id'));
					})
			->first()->total;
			$totalDepartment = Mcu::selectRaw('count(distinct(bagian)) as total')
			->whereHas('vendorCustomer', function($q){
						$q->where('vendor_id', session()->get('user.vendor.id'));
					})
			->first()->total;
		
			
			
			 return $this->view('home', 'Dashboard','Dashboard',[
					'totalTransaction' => $totalTransaction,
					'totalPatient' => $totalPatient,
					'totalPacket' => $totalPacket,
					'totalDepartment' => $totalDepartment,
				]);
			
		}						
		else if(session()->get('user.user_group_id')==3) //customer
		{
			 $totalTransaction = Mcu::whereHas('vendorCustomer', function($q){
						$q->where('customer_id', session()->get('user.customer.id'));
					})->count(); 
			
			$totalPatient = Mcu::selectRaw('count(distinct(concat(nama_pasien,tgl_lahir,jenis_kelamin))) as total')
			
			->whereHas('vendorCustomer', function($q){
						$q->where('customer_id', session()->get('user.customer.id'));
					})
			
			->first()->total;
			$totalPacket = Mcu::selectRaw('count(distinct(paket_mcu)) as total')
			->whereHas('vendorCustomer', function($q){
						$q->where('customer_id', session()->get('user.customer.id'));
					})
			->first()->total;
			$totalDepartment = Mcu::selectRaw('count(distinct(bagian)) as total')
			->whereHas('vendorCustomer', function($q){
						$q->where('customer_id', session()->get('user.customer.id'));
					})
			->first()->total;
			   
			   return $this->view('home', 'Dashboard','Dashboard',[
					'totalTransaction' => $totalTransaction,
					'totalPatient' => $totalPatient,
					'totalPacket' => $totalPacket,
					'totalDepartment' => $totalDepartment,
				]);
			
		}
		else if(session()->get('user.user_group_id')==1) // admin
		{
				$totalTransaction = Mcu::count();
				$totalPatient = Mcu::selectRaw('count(distinct(concat(nama_pasien,tgl_lahir,jenis_kelamin))) as total')->first()->total;
				$totalPacket = Mcu::selectRaw('count(distinct(paket_mcu)) as total')->first()->total;
				$totalDepartment = Mcu::selectRaw('count(distinct(bagian)) as total')->first()->total;
		
				 return $this->view('home','Dashboard','Dashboard', [
					'totalTransaction' => $totalTransaction,
					'totalPatient' => $totalPatient,
					'totalPacket' => $totalPacket,
					'totalDepartment' => $totalDepartment,
				]);
		}	
        else
        {
			//echo "inputer";
			$totalTransaction = Mcu::count();
				$totalPatient = Mcu::selectRaw('count(distinct(concat(nama_pasien,tgl_lahir,jenis_kelamin))) as total')->first()->total;
				$totalPacket = Mcu::selectRaw('count(distinct(paket_mcu)) as total')->first()->total;
				$totalDepartment = Mcu::selectRaw('count(distinct(bagian)) as total')->first()->total;
		
				 return $this->view('home', 'Dashboard','Dashboard',[
					'totalTransaction' => $totalTransaction,
					'totalPatient' => $totalPatient,
					'totalPacket' => $totalPacket,
					'totalDepartment' => $totalDepartment,
					]);
		}			
		
		
        
        
        //return $this->view('home','Dashboard','Dashboard',[]);
    }

    public function parameter()
    {
       
        return $this->view('pages.paramter.parameter','Parameter','Parameter',[]);
    }
	
	public function parameter_data(Request $request)
    {
        $m = \Illuminate\Support\Facades\DB::table('parameters')
				   ->select('parameters.id','parameters.name','parameters.field','parameters.index_of_colom_excel','parameters.kategori');


        $recordTotal = $m->get()->count();


        $r = $request->search;
		$q = $r["value"];

		if($q)
		{
			 $m->Where('name', 'LIKE', '%'.$q.'%');
			 $m->orWhere('field', 'LIKE', '%'.$q.'%');
			 $m->orWhere('index_of_colom_excel', 'LIKE', '%'.$q.'%');
			 $m->orWhere('kategori', 'LIKE', '%'.$q.'%');

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

	public function edit(Request $request)
	{
		$id = $request->id;
		$pr = Parameter::find($id);
        return response()->json(['responseCode' => 200, 'responseMessage' => $pr]);

	}

	public function save(Request $request)
    {
        $d = new Parameter();

        $d->name 	     = $request->nama_parameter;
        $d->field        = $request->field;
        $d->index_of_colom_excel       = $request->excelindex;
        $d->kategori       = $request->kategori_pr;

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create  Parameter']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Parameter has been created or updated successfully']);
    }

	public function update(Request $request, Parameter $parameter)
    {
        $d = $parameter::find($request->id);

        $d->name   = $request->nama_parameter;
        $d->field        = $request->field;
        $d->index_of_colom_excel       = $request->excelindex;
        $d->kategori       = $request->kategori_pr;

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update parameter']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'parameter has been updated successfully']);
    }

	public function delete(Parameter $parameter, Request $request)
    {

		$m = \Illuminate\Support\Facades\DB::table('rumus_details')
				   ->select('rumus_details.parameter_id')->Where('rumus_details.parameter_id',$request->id)->get();
		if($m->count()>0)
		{
			return response()->json(['responseCode' => 500, 'responseStatus' => 'OK', 'responseMessage' => 'Failed to execute  delete']);

		}
		else
        {
			$a = $parameter::find($request->id);

			if(!$a->delete()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Failed to execute  delete']);
			}

			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Parameter delete has been finished']);

		}

    }


    public function underDevelopment()
    {
        return view('development');
    }
	
}
