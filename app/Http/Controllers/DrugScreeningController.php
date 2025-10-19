<?php

namespace App\Http\Controllers;

use App\Models\DrugScreeningDetail;
use App\Models\Customer;
use App\Models\VendorCustomer;
use App\Models\Process;
use App\Exports\DrugscreeningExport;
use App\Jobs\ImportDrugscreening;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DrugScreeningController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    
    public function index()
    {
        $client = Customer::where('active', 'Y')->get();
		$project =  VendorCustomer::all();
        $process = Process::where('upload','drug screening')->where('status','ON PROGRESS')->first();
        return $this->view('pages.drug-screening.index','DrugScreening','Drug Screening',['process' => $process,
            'project' => $project,'client'=>$client]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $d = new DrugScreeningDetail();
        $d->tgl_pemeriksaan	= $request->tglPemeriksaan;
        $d->status_pemeriksaan	= $request->statusPemeriksaan;
        $d->parameter_drug_screening = $request->parameter;
        $d->hasil_drug_screening= $request->hasil;
        $d->mcu_id              = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create or update drug screening']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Drug screening has been created or updated successfully']);
    }

    /**
     * Show drug screening data
     * 
     * @param DrugScreening $drugScreening
     * @param type $id
     * @return type
     */
    public function show(DrugScreeningDetail $drugScreening, $id)
    {
        $ds = $drugScreening::find($id);
        $idPasien = (int) substr($ds->mcu_id, 12, 8);
        $idPerusahaan = (int) substr($ds->mcu_id, 8, 4);
        $inputDate = substr($ds->mcu_id, 0, 4).'-'.substr($ds->mcu_id, 4, 2).'-'.substr($ds->mcu_id, 6, 2);
        
        $ds['id_pasien'] = $idPasien;
        $ds['id_perusahaan'] = $idPerusahaan;
        $ds['input_date'] = $inputDate;
        
        return response()->json($ds);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrugScreeningDetail $drugScreening)
    {
        $d = $drugScreening::find($request->id);
        $d->tgl_pemeriksaan     = $request->tglPemeriksaan;
        $d->status_pemeriksaan  = $request->statusPemeriksaan;
        $d->parameter_drug_screening= $request->parameter;
        $d->hasil_drug_screening= $request->hasil;
        $d->mcu_id              = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update drug screening']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Drug screening has been updated successfully']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrugScreeningDetail $drugScreening, $id)
    {
        $d = $drugScreening::find($id);

        if(!$d->delete()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update drug screening']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Drug screening has been deleted successfully']);
    }
    
    /**
     * Bulk Delete
     * 
     * @param Rontgen $drugScreening
     * @param Request $request
     * @return type
     */
    public function bulkDelete(DrugScreeningDetail $durgScreening, Request $request)
    {
        $ds = $durgScreening::where('mcu_id', '!=' , null);
        
        // Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $ds->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }
        
        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
            $ds->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }
        
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $ds->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $ds->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }
        
        if($request->idPasien != '' || $request->idPerusahaan != '' || $request->startDate != '' || $request->endDate != '') {
            if(!$ds->delete()) {
                return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Failed to execute bulk delete']); 
            }
            
            return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Bulk delete has been finished']);
        }
    }
    
    /**
     * Drug screening datatables
     * 
     * @param Request $request
     * @return type
     */
    public function datatables(Request $request)
    {
        $r = DrugScreeningDetail::where('mcu_id', '!=' , null);
        
        // Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $r->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }
        
        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
            $r->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }
        
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $r->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $r->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        return datatables($r)
            ->addColumn('action', function($r) {
                return '<button type="button" class="btn btn-warning btn-xs btn-flat" data-id='.$r->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-flat btn-delete" data-id='.$r->id.'><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('id_pasien', function($r) {
                return (int)substr($r->mcu_id, 12, 8);
            })
            ->addColumn('tgl_input', function($r) {
                return substr($r->mcu_id, 0, 4).'-'.substr($r->mcu_id, 4, 2).'-'.substr($r->mcu_id, 6, 2);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    
    /**
    * Import drug screening
    *
    * @param Request $request
    * @return type database
    */
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $processId = null;

            if($file->isValid()) {
                $nameStripped = str_replace(" ", "-", $file->getClientOriginalName());
                 $file->storeAs('upload', $nameStripped,'public');

                // Push into process
                $process = new Process();
                $process->fill([
                    'upload'    => 'drug screening',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();

                $processId = $process->id;

                ImportDrugscreening::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->onQueue('drug')->delay(now()->addSeconds(3));
            }

            return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]);
        }
    }

    /**
    * Export Drug Screening
    *
    * @return type file .xlsx
    */
    public function export(Request $request)
    {
        $starDate = $request->startDate;
        $endDate = $request->endDate;
        $idPerusahaan = $request->idPerusahaan;
        return Excel::download(new DrugscreeningExport($starDate, $endDate, $idPerusahaan), 'database-drug-screening.xlsx');
    }
}
