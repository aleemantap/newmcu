<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vendor;
use App\Models\VendorCustomer;
use App\Exports\ProjectExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->view('pages.project.index','Project','Project', [
            'vendors' => Vendor::where('active', 'Y')->get(),
            'customers' => Customer::where('active', 'Y')->get()
        ]);
        
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
        $c = new VendorCustomer();
        $c->vendor_id = $request->vendor_id;
        $c->customer_id = $request->customer_id;

        if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add project. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Project has been added successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(VendorCustomer $project, $id)
    {
        $c = $project::find($id);
        return response()->json($c);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorCustomer $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorCustomer $project)
    {
        $c = $project->find($request->id);
        $c->vendor_id = $request->vendor_id;
        $c->customer_id = $request->customer_id;

        if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t update project. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Project has been updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorCustomer $project, $id)
    {
        $c = $project->find($id);

        if(!$c->delete()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete project. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Project has been deleted successfuly']);
    }

    /**
     * User datatables
     *
     * @return type JSON user
     */
	  

	 
	 
    public function datatables()
    {
        $c = VendorCustomer::with(['customer','vendor']);
		
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $c->whereHas('customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $customerId = session()->get('user.vendor_id');
            $c->whereHas('vendor', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		
        return datatables($c)
            ->addColumn('action', function($c) {
                return '<button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$c->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$c->id.'><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['action', 'active'])
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Export project
     *
     * @return type file .xlsx
     */
    public function export()
    {
        return Excel::download(new ProjectExport(), 'projects.xlsx');
    }
}
