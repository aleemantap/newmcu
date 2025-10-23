<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\VendorCustomer;
use App\Models\Ttd;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
  
    public function view($view,$title1=null,$title2=null,$array=[])
    {
        $data = [
           'title_page_left' => $title1,
           'title_page_right' => $title2,
        ]+$array;
        return view($view,$data);
    }

     public function setInteger2($integer)
    {
        if($integer == "0")
		{
			
			return $integer;
		}
		else
		{
			if(empty($integer)) {
				return NULL;
			}

			if(is_string($integer)) {
				return (int) $integer;
			}
		}
		
		return $integer;

        
    }

    public function setDouble2($double)
    {
        if(empty($double)) {
            return NULL;
        }

        if(is_string($double)) {
            return str_replace(",", ".", $double);
        }

        return $double;
    }

    public function tanggalFormatTtd($date)
    {
        //tahun-bulan-tanngal
        $r = explode("-",$date);
        $thn = $r[0];
        $bln = $r[1];
        $tgl = $r[2];

        $b = "";

        switch($bln)
        {
            case '01':
                 $b = "Januari";
                break;
            case '02':
                $b = "Febuari";
                break;
            case '03':
                $b = "Maret";
                break;
            case '04':
                $b = "April";
                break;
            case '05':
                $b = "Mei";
                break;
            case '06':
                $b = "Juni";
                break;
            case '07':
               $b = "Juli";
               break;
            case '08':
                $b = "Agustus";
                break;
            case '09':
               $b = "September";
                break;
            case '10':
                $b = "Oktober";
                break;
            case '11':
                $b = "November";
                break;
            case '12':
                $b = "Desember";
                break;
          
        }

        return $tgl." ".$b." ".$thn;
    }

    // public function setDoubleReport($double)
    // {
    //     if(empty($double)) {
    //         return NULL;
    //     }

    //     if(is_string($double)) {
    //         return str_replace(",", ".", $double);
    //     }

    //     return $double;
    // }


    public function getUrlAwsFile2($file)
    {
         //$ur = \Storage::cloud()->temporaryUrl('upload/'.$file,\Carbon\Carbon::now()->addMinutes(5));
        //return $ur;

         //$url = Storage::disk('minio')->url('upload/'.$file,\Carbon\Carbon::now()->addMinutes(5));
        //  $url = Storage::disk('minio')->temporaryUrl(
        //     $file, 
        //     now()->addMinutes(60)
        // );

        $ur = Storage::cloud()->temporaryUrl('upload/'.$file,\Carbon\Carbon::now()->addMinutes(25));
        return $ur;
        //$urlIcon = \Storage::cloud()->temporaryUrl($app[0]['icon_url'],\Carbon\Carbon::now()->addMinutes(10075));
    }
	
	public function getUrlAwsFile($file)
    {
     	return public_path('storage/upload/'.$file);
    }

    public function dataTtd($mcu)
    {
       

            $ttd_a = Ttd::where("jenis","audio")->orderBy('created_at', 'desc')->first(); 
            $ttd_r = Ttd::where("jenis","rontgen")->orderBy('created_at', 'desc')->first(); 
            $ttd_e = Ttd::where("jenis","ekg")->orderBy('created_at', 'desc')->first(); 
            $ttd_sp = Ttd::where("jenis","spiro")->orderBy('created_at', 'desc')->first(); 
       
            $vg = [
            'ttd_e' => ($ttd_e) ?  $this->getUrlAwsFile($ttd_e->gambar_ttd) : "",
            'nama_e' => ($ttd_e) ?  $ttd_e->nama_dokter : "",        
            'ttd_r' => ($ttd_r) ?  $this->getUrlAwsFile($ttd_r->gambar_ttd) : "",
            'nama_r' => ($ttd_r) ?  $ttd_r->nama_dokter : "",
            'ttd_a' => ($ttd_a) ?  $this->getUrlAwsFile($ttd_a->gambar_ttd) : "",
            'nama_a' => ($ttd_a) ?  $ttd_a->nama_dokter : "",
            'tglTTD' => $this->tanggalFormatTtd($mcu['tgl_input']),
            'ttd_sp' => ($ttd_sp) ?  $this->getUrlAwsFile($ttd_sp->gambar_ttd) : "",
            'nama_sp' => ($ttd_sp) ?  $ttd_sp->nama_dokter : "",
            'logo'=> ($mcu->vendorCustomer->vendor->image) ? $this->getUrlAwsFile($mcu->vendorCustomer->vendor->image) : "",
            'sign'=>  ($mcu->vendorCustomer->vendor->sign) ? $this->getUrlAwsFile($mcu->vendorCustomer->vendor->sign) : "",
            
            
            ];
        return $vg;


    }

    
}
