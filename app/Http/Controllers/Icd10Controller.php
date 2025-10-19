<?php

namespace App\Http\Controllers;

use App\Models\Icd10;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\IcdExport;
use Maatwebsite\Excel\Facades\Excel;

class Icd10Controller extends Controller
{
    
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
       
        return $this->view('pages.icd10.index','Icd 10','Icd 10',[]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
		 $validator = Validator::make($request->all(), [
            'name' => 'required|max:300',
            'code' => 'required|max:20|unique:icd10s' 
        ]);
		
		
        if ($validator->fails()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => "Code already exist"]);
        }
		
		$d = new Icd10();

        $d->name 	     = $request->name;
        $d->code        = $request->code;
        $d->deleted       = "N";
       

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create  Icd']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Icd has been created or updated successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Icd10  $icd10
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
		$pr = Icd10::find($id);
        return response()->json(['responseCode' => 200, 'responseMessage' => $pr]);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Icd10  $icd10
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Icd10 $p)
    {
      	
		$check = $p::where([
            ['id',$request->id],
			['name',$request->name]
        ])->first();

        
        $appa = [
            'name' =>  'required|max:300',
            'code' =>  'required'
          
        ];
        
        if(!empty($check)){
     
            $appa['name'] = 'required|max:20|unique:icd10s';
           
           
        }
        $validator = Validator::make($request->all(),$appa);
		
        if ($validator->fails()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => "Code already exist"]);
        }
		
		$d = $p::find($request->id);
        $d->name 	    = $request->name;
        $d->code        = $request->code;
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update Icd']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'parameter has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Icd10  $icd10
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        
		
		$d = Icd10::find($request->id);
        $d->deleted 	    = "Y";
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to Deleted Icd']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Icd has been updated successfully']);
    }

    /**
     * Search icdx by code or name
     *
     * @param Request $request
     * @return type
     */
    public function search(Request $request)
    {
        $q = Icd10::where('code', 'like', '%'.$request->diagnosis.'%')
                ->orWhere('name', 'like', '%'.$request->diagnosis.'%')->get();

        return response()->json($q);

    }

    /**
     * Icd10 datatables
     *
     * @return type JSON Icd10
     */
	public function datatablesx()
    {
        $c = Icd10::where('deleted','N');

        return datatables($c)
            ->addColumn('action', function($c) {
                return '<a href="#"  type="button" class="btn btn-warning btn-xs btn-edit" title="Edit" data-id='.$c->id.'><i class="fa fa-pencil"></i></a>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete-icd" title="Delete" data-id='.$c->id.'><i class="fa fa-trash"></i></button>';
            })
            ->addIndexColumn()
            ->toJson();
    }
	
	public function datatables(Request $request)
    {
        $m = Icd10::where('deleted','N');

        $recordTotal = $m->count();
        // Filter code
        if($request->code != '') {
            $code = $request->code;
            $m->where('code', 'like', '%'.$code.'%');
        }
		
		// Filter name
        if($request->name != '') {
            $name = $request->name;
            $m->where('name', 'like', '%'.$name.'%');
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
	
	/**
     * Export rontgen
     *
     * @return type file .xlsx
     */
    function export(Request $request)
    {
        return Excel::download(new IcdExport(), 'database-mcu.xlsx');
    }
}
