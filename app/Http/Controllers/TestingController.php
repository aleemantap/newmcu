<?php

namespace App\Http\Controllers;
use App\Recommendation;
use App\Diagnosis;
use App\Mcu;
use App\Umum;
use App\AudiometriDetail;
use App\RontgenDetail;
use App\Riwayat;
use App\Antrovisus;
use App\Fisik;
use App\Hematologi;
use App\Kimia;
use App\Oae;
use App\Rontgen;
use App\Serologi;
use App\Spirometri;
use App\Treadmill;
use App\Audiometri;
use App\Feses;
use App\Urin;
use App\PapSmear;
use App\Ekg;
use App\RectalSwab;
use App\DrugScreening;
use App\Customer;
use App\VendorCustomer; 
use App\Process;
use App\Exports\McuExport;
use App\Jobs\ImportMcu;
use App\Jobs\SendReportEmail;
use App\Jobs\SendReportWhatsApp;
use App\Premcu\JenisPemeriksaanQc;
use App\Premcu\JenisPemeriksaan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use PHPJasper\PHPJasper;
use PDF;
use Screen\Capture;
use Carbon\Carbon;
use DateTime;
use App\Exports\McuReportExport;
use App\Exports\McuReportDiagnosisExport;
use App\Exports\McuReportMostSufferedExport;
use App\Exports\McuReportEkgExport;
use App\Exports\CollectionExportRadiology;
//use Dompdf\Dompdf;
use App\Parameter;
use App\Vendor;
use App\WorkHealth;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;


use App\Icd10;


class TestingController extends Controller
{
   
   public function index(){

   			$m = Mcu::query();

   			$m->with(['diagnosis.recommendation.icd10','diagnosis','vendorCustomer']); 
   			$customerId = 75;
		    $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
            
                $q->where('id', $customerId);
            
            });

   			 $whid = 1;

   			// $m = Icd10::select('code as KODE','name')->with('recommendation'); //=>function($q) {

   			// 	//$q->where('work_health_id', $whid);
   			// 	//$q->where('deleted', 0);

   			// 	// $q->select('work_health_id'); //->where('work_health_id',1);

   			// 	// $q->with(['diagnosis'=>function($q) {

   			// 	// 	$q->select('mcu_id');

   			// 	// }]);

   			// 	//$q->select('mcu_id')->where('work_health_id', $whid)->where('deleted', 0);

   			// $m->where('code','B16');

   			$m->whereHas('diagnosis.recommendation', function($q) use ($whid) {
            
                 $q->where('work_health_id', $whid);

                 // $q->where('deleted', 0);

                 // $q->whereHas('diagnosis', function($c) use ($whid) {

                 // 	$c->where('deleted', 0);

                 // });
            
            });



   			//$m->select('code as KODE','name');
   			$data = $m->take(50000)->get();

   			echo '<pre>';
   			dd($data);
   			echo '</pre>';

   			/*echo "<table>";
   			echo "<tr><td>CODE</td><td>NAME</td><td>Total</td></tr>";
   		
   			foreach($data as $kap)
   			{


   				echo "<tr><td>".$kap->KODE."</td><td>".$kap->diagnosis."</td><td>90</td></tr>";




   			} 

   			echo "</table>";*/

        


   }




}