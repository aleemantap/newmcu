<?php

namespace App\Http\Controllers;

use App\Models\Ttd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignDokterController  extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }  
    
    public function index(Request $request)
    {
     
       $ttd_a = Ttd::where("jenis","audio")->orderBy('created_at', 'desc')->first(); 
       $ttd_r = Ttd::where("jenis","rontgen")->orderBy('created_at', 'desc')->first(); 
       $ttd_e = Ttd::where("jenis","ekg")->orderBy('created_at', 'desc')->first(); 
       $ttd_sp = Ttd::where("jenis","spiro")->orderBy('created_at', 'desc')->first(); 
       
       
       //$ur ="https://emcu-bucket.s3.ap-southeast-3.amazonaws.com/upload/";
       return $this->view('pages.sign_dokter.index','TTD','TTD Dokter',[
        'ttd_e' => ($ttd_e) ?  $this->getUrlAwsFile($ttd_e->gambar_ttd) : "",
        'nama_e' => ($ttd_e) ?  $ttd_e->nama_dokter : "",        
        'ttd_r' => ($ttd_r) ?  $this->getUrlAwsFile($ttd_r->gambar_ttd) : "",
        'nama_r' => ($ttd_r) ?  $ttd_r->nama_dokter : "",
        'ttd_a' => ($ttd_a) ?  $this->getUrlAwsFile($ttd_a->gambar_ttd) : "",
        'nama_a' => ($ttd_a) ?  $ttd_a->nama_dokter : "",
        'ttd_sp' => ($ttd_sp) ?  $this->getUrlAwsFile($ttd_sp->gambar_ttd) : "",
        'nama_sp' => ($ttd_sp) ?  $ttd_sp->nama_dokter : "",
       ]);
    }
    
//10075
    public function getUrlAwsFile($file)
    {
        $ur = \Storage::cloud()->temporaryUrl('upload/'.$file,\Carbon\Carbon::now()->addMinutes(5));
        return $ur;
    }

    public function saveAudio(Request $request)
    {
        $c = new Ttd();
        $c->nama_dokter = $request->nama_dokter;
        $c->jenis = 'audio';
        $c->created_by       = session()->get('user.name');
        $c->updated_by       = null;
        $c->created_at       = \Carbon\Carbon::now()->toDateTimeString();
        $c->updated_at       = null;
        $gmb = '';
        if ($request->hasFile('file')) {
            
            $path = $request->file('file')->store('upload', 's3');
            $gmb =   basename($path);
            //"https://emcu-bucket.s3.ap-southeast-3.amazonaws.com/upload/".basename($path);
            //Storage::disk('s3')->url($path);
            $c->gambar_ttd = $gmb;
            $c->note = null;       
        
        }

		if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t save Sign Dokter Audimetri. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 
         'responseStatus' => 'Success',
         'responseMessage' => 'Sign Dokter Audiometri has been Save successfuly',
         //'file' => "https://emcu-bucket.s3.ap-southeast-3.amazonaws.com/upload/".$gmb,
        ]);
    }


    public function saveRontgen(Request $request)
    {
        $c = new Ttd();
        $c->nama_dokter = $request->nama_dokter;
        $c->jenis = 'rontgen';
        $c->created_by       = session()->get('user.name');
        $c->updated_by       = null;
        $c->created_at       = \Carbon\Carbon::now()->toDateTimeString();
        $c->updated_at       = null;
        $gmb = '';
        if ($request->hasFile('file')) {
            
            $path = $request->file('file')->store('upload', 's3');
            $gmb =   basename($path);
          
            $c->gambar_ttd = $gmb;
            $c->note = null;       
        
        }

		if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t save Sign Dokter Rontgen. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 
         'responseStatus' => 'Success',
         'responseMessage' => 'Sign Dokter Rontgen has been Save successfuly',
        
        ]);
    }

    public function saveEkg(Request $request)
    {
        $c = new Ttd();
        $c->nama_dokter = $request->nama_dokter;
        $c->jenis = 'ekg';
        $c->created_by       = session()->get('user.name');
        $c->updated_by       = null;
        $c->created_at       = \Carbon\Carbon::now()->toDateTimeString();
        $c->updated_at       = null;
        $gmb = '';
        if ($request->hasFile('file')) {
            
            $path = $request->file('file')->store('upload', 's3');
            $gmb =   basename($path);
          
            $c->gambar_ttd = $gmb;
            $c->note = null;       
        
        }

		if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t save Sign Dokter EKG. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 
         'responseStatus' => 'Success',
         'responseMessage' => 'Sign Dokter EKG has been Save successfuly',
        
        ]);
    }

    public function saveSpiro(Request $request)
    {
        $c = new Ttd();
        $c->nama_dokter = $request->nama_dokter;
        $c->jenis = 'spiro';
        $c->created_by       = session()->get('user.name');
        $c->updated_by       = null;
        $c->created_at       = \Carbon\Carbon::now()->toDateTimeString();
        $c->updated_at       = null;
        $gmb = '';
        if ($request->hasFile('file')) {
            
            $path = $request->file('file')->store('upload', 's3');
            $gmb =   basename($path);
          
            $c->gambar_ttd = $gmb;
            $c->note = null;       
        
        }

		if(!$c->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t save Sign Dokter SPIRO. Please refresh page and try again']);
        }

        return response()->json(['responseCode' => 200, 
         'responseStatus' => 'Success',
         'responseMessage' => 'Sign Dokter SPIRO has been Save successfuly',
        
        ]);
    }


   
    
    
}
