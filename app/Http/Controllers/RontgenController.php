<?php

namespace App\Http\Controllers;

use App\Models\RontgenDetail;
use App\Models\Rontgen;
use App\Models\Process;
use App\Models\Customer;
use App\Models\Ekg;
use App\Models\VendorCustomer;
use App\Exports\RontgenExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ImportRontgen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RontgenController extends Controller
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
        $process = Process::where('upload','rontgen')->where('status','ON PROGRESS')->first();
        $fotoTypes = RontgenDetail::selectRaw('distinct(jenis_foto) as jenis_foto')->get();
        $parameters = RontgenDetail::selectRaw('distinct(parameter) as parameter')->get();
        $temuan = RontgenDetail::selectRaw('distinct(temuan) as temuan')->get();
        $client = Customer::all();// Customer::where('active', 'Y')->get();
        $project =  VendorCustomer::all();
        return $this->view('pages.rontgen.index','Rontgen','Rontgen',['process' => $process,
            'fotoTypes' => $fotoTypes,
            'parameters' => $parameters,
            'temuan' => $temuan,
            'client' => $client,
            'project' => $project]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $d = new RontgenDetail();
        $d->jenis_foto  = $request->jenisFoto;
        $d->parameter   = $request->parameter;
        $d->temuan      = $request->temuan;
        $d->mcu_id      = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create or update rontgen']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Rontgen has been created or updated successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function show(RontgenDetail $rontgen, $id)
    {
        $r = $rontgen::find($id);
        $idPasien = (int) substr($r->mcu_id, 12, 8);
        $idPerusahaan = (int) substr($r->mcu_id, 8, 4);
        $inputDate = substr($r->mcu_id, 0, 4).'-'.substr($r->mcu_id, 4, 2).'-'.substr($r->mcu_id, 6, 2);
        
        $r['id_pasien'] = $idPasien;
        $r['id_perusahaan'] = $idPerusahaan;
        $r['input_date'] = $inputDate;
        
        return response()->json($r);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function edit(RontgenDetail $rontgen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RontgenDetail $rontgen)
    {
        $d = $rontgen::find($request->id);
        $d->jenis_foto  = $request->jenisFoto;
        $d->parameter   = $request->parameter;
        $d->temuan      = $request->temuan;
        $d->mcu_id      = date('Ymd', strtotime($request->tglInput))
                . str_pad($request->idPerusahaan, 4,"0", STR_PAD_LEFT)
                . str_pad($request->idPasien, 8, "0", STR_PAD_LEFT);

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update rontgen']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Rontgen has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rontgen  $rontgen
     * @return \Illuminate\Http\Response
     */
    public function destroy(RontgenDetail $rontgen, $id)
    {
        $d = $rontgen::find($id);

        if(!$d->delete()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update rontgen']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Rontgen has been deleted successfully']);
    }
    
    /**
     * Bulk Delete
     * 
     * @param Rontgen $rontgen
     * @param Request $request
     * @return type
     */
    public function bulkDelete(RontgenDetail $rontgen, Request $request)
    {
        $r = $rontgen::where('mcu_id', '!=' , null);
        
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
        
        if($request->idPasien != '' || $request->idPerusahaan != '' || $request->startDate != '' || $request->endDate != '') {
            if(!$r->delete()) {
                return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Failed to execute bulk delete']); 
            }
            
            return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Bulk delete has been finished']);
        }
    }

    /**
     * Rontgen datatables
     *
     * @return type JSON rontgen
     */
    public function datatables(Request $request)
    {
        $r = RontgenDetail::where('mcu_id', '!=' , null);
        
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
                return '<button type="button" class="btn btn-warning btn-sm btn-flat btn-edit" data-id='.$r->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-sm btn-flat btn-delete" data-id='.$r->id.'><i class="fa fa-trash"></i></button>';
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
     * Export rontgen
     *
     * @return type file .xlsx
     */
    public function export(Request $request)
    {
        $starDate = $request->startDate;
        $endDate = $request->endDate;
        $idPerusahaan = $request->idPerusahaan;
        return Excel::download(new RontgenExport($starDate, $endDate, $idPerusahaan), 'database-rontgen.xlsx');
    }

    /**
     * Import Rontgen
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
                    'upload'    => 'rontgen',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();
				$processId = $process->id;
				//ImportRontgen::dispatch(env('AWS_URL') . $path, $process->id)->delay(now()->addSeconds(3));
                //ImportRontgen::dispatch($path, $process->id)->delay(now()->addSeconds(3));
                ImportRontgen::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->onQueue('rontgen')->delay(now()->addSeconds(3));
				//ImportRontgen::dispatch(env('AWS_URL').DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->delay(now()->addSeconds(3));
				
		   }

            return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]);
        }
    }
	public function showekg($id,$nama)
	{
	     $d = Ekg::where('mcu_id',$id)->first();
		 $url = null;
		 if($d)
		 {	 
			$g = $d->foto;
			//$url = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/ekg/'.$g;
			$url =  "https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/ekg/$g";
		 }
		
		return $this->view('pages.mcu.mcu-ekg','MCU EKG','MCU EKG', [
            'mcu_id' => $id,
            'nama' => $nama,
			'foto' => $url
			
        ]);
	}
	public function importekg(Request $request)
    {
		$d = Ekg::where('mcu_id',$request->id)->first();
		
		if($d)
		{	
			if ($request->hasFile('file')) {

				$file = $request->file('file');
				if($file->isValid()) {
					
					if($d->foto !="")
					{
							Storage::disk('s3')->delete('ekg/'. $d->foto);
					}
					
					$nameStripped = $request->id.'-'.time().str_replace(" ", "-","ekg" ); //$file->getClientOriginalName()
					//$file->storeAs('upload', $nameStripped,'public');
					Storage::disk('s3')->put('ekg/' . $nameStripped, file_get_contents($file));
					 
					$d->foto  = $nameStripped;
					
					if(!$d->save()) {
						return response()->json(['responseCode' => 500, 'responseMessage' => 'Gagal menyimpan foto EKG']);
					}

					return response()->json(['responseCode' => 200, 'responseMessage' => 'Foto EKG berhasil disimpan']);
				}

			}
			else
			{
				return response()->json(['responseCode' => 500, 'responseMessage' => 'File Kosong']);
			}
		}
		else
		{
			return response()->json(['responseCode' => 500, 'responseMessage' => 'Data EKG Kosong']);
			
		}
    }
	public function showrng($id,$nama)
	{
		 $d = Rontgen::where('mcu_id',$id)->first();
		 $url = null;
		 if($d)
		 {	 
			$g = $d->foto;
			//$url = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/ekg/'.$g;
			$url =  "https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/rontgen/$g";
		 }
		 return $this->view('pages.mcu.mcu-rng','MCU RNG','MCU RNG', [
            'mcu_id' => $id,
            'nama' => $nama,
			'foto' => $url
			
        ]);
		
	}
	
	public function importrng(Request $request)
    {
        $d = Rontgen::where('mcu_id',$request->id)->first();
		
		if($d)
		{	
			if ($request->hasFile('file')) {

				
					$file = $request->file('file');
					if($file->isValid()) {
						
						if($d->foto !="")
						{
							Storage::disk('s3')->delete('rontgen/'. $d->foto);
						}
						
						$nameStripped = $request->id.'-'.time().str_replace(" ", "-", "rontgen");
						//$file->storeAs('upload', $nameStripped,'public');
						Storage::disk('s3')->put('rontgen/' . $nameStripped, file_get_contents($file));
						
						$d->foto  = $nameStripped;
						
						if(!$d->save()) {
							return response()->json(['responseCode' => 500, 'responseMessage' => 'Gagal menyimpan foto Rontgen']);
						}

						return response()->json(['responseCode' => 200, 'responseMessage' => 'Foto Rontgen berhasil disimpan']);
					}
				
				

			}
			else
			{
				return response()->json(['responseCode' => 500, 'responseMessage' => 'File Kosong']);
			}
		}
		else
		{
			return response()->json(['responseCode' => 500, 'responseMessage' => 'Data EKG Kosong']);
			
		}
    }
}
