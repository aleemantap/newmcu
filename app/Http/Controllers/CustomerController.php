<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->view('pages.customer.index','Customers','Customers',[]);
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
        $c = new Customer();
        $c->name = $request->name;
        $c->address1 = $request->address1;
        $c->address2 = $request->address2;
        $c->city = $request->city;
        $c->zip_code = $request->zipCode;
        $c->phone = $request->phone;
        $c->fax = $request->fax;
        $c->email = $request->email;
        
        if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add customer. Please refresh page and try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Customer has been added successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $id)
    {
        $c = $customer::find($id);
        return response()->json($c);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $c = $customer->find($request->id);
        $c->name = $request->name;
        $c->address1 = $request->address1;
        $c->address2 = $request->address2;
        $c->city = $request->city;
        $c->zip_code = $request->zipCode;
        $c->phone = $request->phone;
        $c->fax = $request->fax;
        $c->email = $request->email;
        
        if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t update customer. Please refresh page and try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Customer has been updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $id)
    {
        $c = $customer->find($id);
        
        if(!$c->delete()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete customer. Please refresh page and try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Customer has been deleted successfuly']);
    }
    
    /**
     * User datatables
     *
     * @return type JSON user
     */
    public function datatables()
    {
        $c = Customer::where('active', 'Y')->get();
		// <button type="button" class="btn btn-xs btn-info" data-id='.$c->id.'>&nbsp;<i class="fa fa-info"></i>&nbsp;</button>
        return datatables($c)
            ->addColumn('action', function($c) {
                return '
                <button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$c->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$c->id.'><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('address', function($c){
                return $c->address1.'. '.$c->address2;
            })
            ->rawColumns(['action', 'active'])
            ->addIndexColumn()
            ->toJson();
    }
    
    /**
     * Export customer
     *
     * @return type file .xlsx
     */
    public function export()
    {
        return Excel::download(new CustomerExport(), 'customers.xlsx');
    }
}
