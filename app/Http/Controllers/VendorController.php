<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Exports\VendorExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view('pages.vendor.index','Vendor','Vendor',[]);
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
        $c = new Vendor();
        $c->name = $request->name;
        $c->address1 = $request->address1;
        $c->address2 = $request->address2;
        $c->city = $request->city;
        $c->zip_code = $request->zipCode;
        $c->phone = $request->phone;
        $c->fax = $request->fax;
        $c->email = $request->email;
        $c->doctor_name = $request->doctor_name;
        $c->doctor_license = $request->doctor_license;

        if ($request->hasFile('image')) {
            $fileImage = $request->file('image');
            if($fileImage->isValid()) {
                //$nameStripped = rand().str_replace(" ", "-", $fileImage->getClientOriginalName());
                //$fileImage->storeAs('vendor', $nameStripped,'public');
                //$c->image = $nameStripped;

                $path = $request->file('image')->store('upload', 's3');
                $gmb =   basename($path);
                $c->image = $gmb;
                  

            }
        }

        if ($request->hasFile('sign')) {
            $fileSign = $request->file('sign');
            if($fileSign->isValid()) {
                //$nameStrippedSign = rand().str_replace(" ", "-", $fileSign->getClientOriginalName());
                //$fileSign->storeAs('vendor', $nameStrippedSign,'public');
                //$c->sign = $nameStrippedSign;

                $path = $request->file('sign')->store('upload', 's3');
                $gmb =   basename($path);
                $c->sign = $gmb;

            }
        }

		if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add vendor. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Vendor has been added successfuly']);

	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor, $id)
    {
        $c = $vendor::find($id);
        $image =  ($c->image) ? $this->getUrlAwsFile($c->image) : null; 
        $sign  =  ($c->sign) ? $this->getUrlAwsFile($c->sign) : null; 
        return response()->json([$c,$image,$sign]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $c = $vendor->find($request->id);
        $c->name = $request->name;
        $c->address1 = $request->address1;
        $c->address2 = $request->address2;
        $c->city = $request->city;
        $c->zip_code = $request->zipCode;
        $c->phone = $request->phone;
        $c->fax = $request->fax;
        $c->email = $request->email;
        $c->doctor_name = $request->doctor_name;
        $c->doctor_license = $request->doctor_license;

		if ($request->hasFile('image')) {
            $fileImage = $request->file('image');
            if($fileImage->isValid()) {
                //$nameStripped = rand().str_replace(" ", "-", $fileImage->getClientOriginalName());
                //$fileImage->storeAs('vendor', $nameStripped,'public');
                //$c->image = $nameStripped;

                $path = $request->file('image')->store('upload', 's3');
                $gmb =   basename($path);
                $c->image = $gmb;
            }
        }

        if ($request->hasFile('sign')) {
            $fileSign = $request->file('sign');
            if($fileSign->isValid()) {
                //$nameStrippedSign = rand().str_replace(" ", "-", $fileSign->getClientOriginalName());
                //$fileSign->storeAs('vendor', $nameStrippedSign,'public');
                //$c->sign = $nameStrippedSign;
                $path = $request->file('sign')->store('upload', 's3');
                $gmb =   basename($path);
                $c->sign = $gmb;
            }
        }

        if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t update vendor. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Vendor has been updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor, $id)
    {
        $c = $vendor->find($id);

        if(!$c->delete()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete vendor. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Vendor has been deleted successfuly']);
    }

    /**
     * User datatables
     *
     * @return type JSON user
     */
    public function datatables()
    {
        $c = Vendor::where('active', 'Y')->get();

        return datatables($c)
            ->addColumn('action', function($c) {
                return '<button type="button" class="btn btn-xs btn-info" data-id='.$c->id.'>&nbsp;<i class="fa fa-info"></i>&nbsp;</button>&nbsp; <button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$c->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$c->id.'><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('address', function($c){
                return $c->address1.'. '.$c->address2;
            })
			->addColumn('logo', function($c){

				$foto = $c->image;
			    return $foto;
            })
            ->rawColumns(['action', 'active'])
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Export vendor
     *
     * @return type file .xlsx
     */
    public function export()
    {
        return Excel::download(new VendorExport(), 'vendors.xlsx');
    }
}
