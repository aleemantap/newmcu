<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Audiometri;
use App\Models\VendorCustomer;
use App\Models\Process;
use App\Models\AudiometriDetail;
use App\Exports\AudiometriExport;
use App\Jobs\ImportAudiometri;
use Maatwebsite\Excel\Facades\Excel;
// use Screen\Capture;
use Illuminate\Http\Request;


class AudiometriController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function index()
    {
        $project =  VendorCustomer::all();// Customer::where('active', 'Y')->get();
		$client = Customer::all();// Customer::where('active', 'Y')->get();
        $process = Process::where('upload','audiometri')->where('status','ON PROGRESS')->first();
     
        return $this->view('pages.audiometri.index','Audiometri','Audiometri',['process' => $process, 'project' => $project, 'customers'=>$client]);
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
        $d = new AudiometriDetail();

        $mcuId = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        $d->frekuensi   = $request->frekuensi;
        $d->kiri        = $request->kiri;
        $d->kanan       = $request->kanan;
        $d->mcu_id      = $mcuId;

        if(!$d->save()) {
			
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create or update audiometri']);
        }

        // Capture chart
        //$this->capture($mcuId);
        ImportAudiometri::audiometri_kesimpulan($mcuId);
        return response()->json(['responseCode' => 200, 'responseMessage' => 'Audiometri has been created or updated successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audiometri  $audiometri
     * @return \Illuminate\Http\Response
     */
    public function show(AudiometriDetail $audiometri, $id)
    {
        $a = $audiometri::find($id);
        $idPasien = (int) substr($a->mcu_id, 12, 8);
        $idPerusahaan = (int) substr($a->mcu_id, 8, 4);
        $inputDate = substr($a->mcu_id, 0, 4).'-'.substr($a->mcu_id, 4, 2).'-'.substr($a->mcu_id, 6, 2);

        $a['id_pasien'] = $idPasien;
        $a['id_perusahaan'] = $idPerusahaan;
        $a['input_date'] = $inputDate;

        return response()->json($a);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audiometri  $audiometri
     * @return \Illuminate\Http\Response
     */
    public function edit(Audiometri $audiometri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audiometri  $audiometri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AudiometriDetail $audiometri)
    {
        $d = $audiometri::find($request->id);

        $mcuId = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        $d->frekuensi   = $request->frekuensi;
        $d->kiri        = $request->kiri;
        $d->kanan       = $request->kanan;
        $d->mcu_id      = $mcuId;

        if(!$d->save()) {
			
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update audiometri']);
        }
		ImportAudiometri::audiometri_kesimpulan($mcuId);
        //$this->capture($mcuId);

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Audiometri has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audiometri  $audiometri
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = AudiometriDetail::find($id);

        if(!$d->delete()) {
			
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update Audiometri']);
        }
        ImportAudiometri::audiometri_kesimpulan($id);
        return response()->json(['responseCode' => 200, 'responseMessage' => 'Audiometri has been deleted successfully']);
    }

    /**
     * Bulk Delete
     *
     * @param Rontgen $audiometri
     * @param Request $request
     * @return type
     */
    public function bulkDelete(AudiometriDetail $audiometri, Request $request)
    {
        $a = $audiometri::where('mcu_id', '!=' , null);

        // Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $a->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
            $a->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $a->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $a->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        if($request->idPasien != '' || $request->idPerusahaan != '' || $request->startDate != '' || $request->endDate != '') {
            if(!$a->delete()) {
                return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Failed to execute bulk delete']);
            }

            return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Bulk delete has been finished']);
        }
    }

    /**
     * User datatables
     *
     * @return type JSON user
     */
    public function datatables(Request $request)
    {
        $a = AudiometriDetail::where('mcu_id', '!=' , null);

        // Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $a->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
            $a->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $a->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $a->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        return datatables($a)
            ->addColumn('action', function($a) {
                return '<button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$a->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$a->id.'><i class="fa fa-trash"></i></button>';
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
     * Export audiometri
     *
     * @return type file .xlsx
     */
    public function export(Request $request)
    {
        $starDate = $request->startDate;
        $endDate = $request->endDate;
        $idPerusahaan = $request->idPerusahaan;
        return Excel::download(new AudiometriExport($starDate, $endDate, $idPerusahaan), 'database-audiometri.xlsx');
    }

    /**
     * Import users
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
                $path = $file->storeAs('upload', $nameStripped,'public');

                // Push into process
                $process = new Process();
                $process->fill([
                    'upload'    => 'audiometri',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();

                $processId = $process->id;

                //ImportAudiometri::dispatch(env('AWS_URL') . $path, $process->id)->delay(now()->addSeconds(3));
				//ImportMcu::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->delay(now()->addSeconds(3));
				ImportAudiometri::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->onQueue('audio')->delay(now()->addSeconds(3));

            }

            return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]);
        }
    }

    /**
     * Generate audiometri chart
     *
     * @return void
     */
    public function chart($mcuId)
    {
        $audios = AudiometriDetail::where('mcu_id', $mcuId)->get();

        $categories = '';
        $leftAudio = '';
        $rightAudio = '';

        foreach($audios as $i => $audio) {
            if($i == 0) {
                $categories .= $audio->frekuensi;
                $leftAudio .= $audio->kiri;
                $rightAudio .= $audio->kanan;
            } else {
                $categories .= ', '.$audio->frekuensi;
                $leftAudio .= ', '.$audio->kiri;
                $rightAudio .= ', '.$audio->kanan;
            }
        }
		
		//print_r($categories);

         return view('pages.audiometri.chart', [
             'categories' => $categories,
             'leftAudio' => $leftAudio,
             'rightAudio' => $rightAudio
         ]);
    }

    /**
     * Capture audiometri chart
     *
     * @param [type] $id
     * @return void
     */
    /*private function capture($id)
    {
        $url = url('/database/audiometri-chart/'.$id);
        $screenCapture = new Capture();
        $screenCapture->setUrl($url);
        $screenCapture->setClipWidth(820);
        $screenCapture->setClipHeight(300);
        $screenCapture->setBackgroundColor('#FFFFFF');
        $fileLocation = storage_path('app/public/audiometri/'.$id);
        $screenCapture->save($fileLocation);
		
		//$idx = $id.'-'.time().'.jpg';
		$idx = $id.'.jpg';
		// Audiometri::updateOrCreate(
                // [
                    // 'mcu_id'    => $id
                // ],
                // [
                    // 'foto'        => $idx 
                // ]
            // );		
		$file = Storage::disk('public')->get('audiometri/'.$idx);
		$uploadedPath = Storage::disk('s3')->put('audiometri/'.$idx, $file);
		unlink(storage_path('app/public/audiometri/'.$idx));
    }*/
	
	

}
