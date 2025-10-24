<?php

namespace App\Http\Controllers;


use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
//====
use App\Models\Recommendation;
use App\Models\Diagnosis;
use App\Models\Mcu;
use App\Models\Umum;
use App\Models\AudiometriDetail;
use App\Models\RontgenDetail;
use App\Models\Riwayat;
use App\Models\Antrovisus;
use App\Models\Fisik;
use App\Models\Hematologi;
use App\Models\Kimia;
use App\Models\Oae;
use App\Models\Rontgen;
use App\Models\Serologi;
use App\Models\Spirometri;
use App\Models\Treadmill;
use App\Models\Audiometri;
use App\Models\Feses;
use App\Models\Urin;
use App\Models\PapSmear;
use App\Models\Ekg;
use App\Models\RectalSwab;
use App\Models\DrugScreening;
use App\Models\Customer;
use App\Models\VendorCustomer; 
use App\Models\Process;
use App\Exports\McuExport;
use App\Jobs\ImportMcu;
use App\Jobs\SendReportEmail;
use App\Jobs\SendReportWhatsApp;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
//use PhpOffice\PhpWord\TemplateProcessor;
// use PHPJasper\PHPJasper;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
// use Screen\Capture;
use Carbon\Carbon;
use DateTime;
use App\Exports\McuReportExport;
use App\Exports\McuReportDiagnosisExport;
use App\Exports\McuReportMostSufferedExport;
use App\Exports\McuReportEkgExport;
use App\Exports\CollectionExportRadiology;
use App\Exports\CollectionExportAudiometri;
use App\Exports\CollectionExportSpirometri;
use App\Exports\CollectionExportDrugScreening; 
//use Dompdf\Dompdf;
use App\Models\Parameter;
use App\Models\Vendor;
// use App\Models\WorkHealth;
use App\Models\Reportsendwa;
// use Dompdf\Options;
// use QuickChart; 
use App\Models\Ttd;
use Illuminate\Support\Facades\Log;

//====

class McuPdfReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index()
    {
        $process = Process::where('upload','mcu')->where('status','ON PROGRESS')->first();
        //$processwa = Process::where('upload','sendwa')->where('status','ON PROGRESS')->first();
        $customers = Customer::where('active', 'Y')->get();
        $vendorCustomer = VendorCustomer::all();
        $departments = Mcu::selectRaw('distinct(bagian)')->get();
       
        return $this->view('pages.mcu.index','MCU','MCU Data',
            ['process' => $process,
            //'processwa' => $processwa,
            'customers' => $customers,
            'vendorCustomer' => $vendorCustomer,
            'departments' => $departments]);
    }

  
    public function download2($id)
    {
        $mcu = Mcu::findOrFail($id);

        $pdf = SnappyPdf::loadView('reports.patient.pdf.emcu_report.generate.pdf_emcu', compact('mcu'))
        ->setOptions([
            'no-outline' => true,
            'page-size' => 'A4',
            'dpi' => 300,
            'enable-local-file-access' => true,
        ]);

        $path = "reports/mcu_{$mcu->id}.pdf";
        //Log::info('PDF Options:', $pdf->getOptions());
        \Illuminate\Support\Facades\Storage::put($path, $pdf->output());
        
        return \Illuminate\Support\Facades\Storage::download($path);
   }

    public function download($id) 
    {
        
        $mcu = Mcu::find($id);
       
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);
        
        $pdf =  SnappyPdf::loadview('reports.patient.pdf.emcu_report', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
        ]+$this->dataTtd($mcu)) ->setOptions([
            'no-outline' => true,
            'page-size' => 'A4',
            'dpi' => 400,
            'enable-local-file-access' => true,
        ]);
        //$file = str_replace(" ","-",$id).'-'.$mcu->nama_pasien.'.pdf';
        //return $pdf->download($file);
         $path = "reports/mcu_{$mcu->id}.pdf";
        //Log::info('PDF Options:', $pdf->getOptions());
        \Illuminate\Support\Facades\Storage::put($path, $pdf->output());
        
        return \Illuminate\Support\Facades\Storage::download($path);
       
    }

    public function chart($mcuId)
    {
        $audios = AudiometriDetail::where('mcu_id', $mcuId)->get();

        $categories = array();
        $leftAudio = array();
        $rightAudio = array();

        foreach($audios as $i => $audio) {
			array_push($categories,$audio->frekuensi);
			array_push($leftAudio,$audio->kiri);
			array_push($rightAudio,$audio->kanan);
            // if($i == 0) {
                // $categories .= $audio->frekuensi;
                // $leftAudio .= $audio->kiri;
                // $rightAudio .= $audio->kanan;
            // } else {
                // $categories .= ', '.$audio->frekuensi;
                // $leftAudio .= ', '.$audio->kiri;
                // $rightAudio .= ', '.$audio->kanan;
            // }
        }
		return [$categories,$leftAudio,$rightAudio];
	}


    public function getChartFromImagechart($id)
	{
		$c = $this->chart($id);
		$labels =  implode(", ", $c[0]); 
		$kiri = implode(", ", $c[1]);
		$kanan = implode(", ", $c[2]);
		$audiometriChart  = url("https://image-charts.com/chart.js/2.8.0?bkg=white&c={
									  type: 'line', 
									  data: { 
										labels: [".$labels."],

                                       


										datasets: [
										  {
											label: 'Kiri', 
                                            backgroundColor: 'rgb(255, 99, 132)',
                                            borderColor: 'rgb(255, 99, 132)',
                                            data: [$kiri],
                                            fill: false,
                                            pointRadius: 2,
                                            borderWidth : 2,
											
											
											
										  },
										  {
											label: 'Kanan',
											fill: false,
                                            backgroundColor: 'rgb(54, 162, 235)',
                                            borderColor: 'rgb(54, 162, 235)',
                                            data: [$kanan],
                                            pointRadius: 2,
                                            borderWidth : 2,
										  },
										],
									  },
									  options: {
										title: {
										  display: true,
										  text: 'AUDIOGRAM',
										},
										scales: {
										  xAxes: [
											{
											  display: true,
											  scaleLabel: {
												display: true,
												labelString: 'FREQUENCY(Hz)',
											  },


                                             
											},
                                            
										  ],
										  yAxes: [
											{
											  display: true,
											  scaleLabel: {
												display: true,
												labelString: 'HEARING LEVEL (dB)',
											  },
                                              ticks: {min: 0, max:100},

											},
                                           
										  ],
										},
									  },
									}");
		return $audiometriChart;
     
		
	}


    /*public function download2($id)
    {
        $mcu = Mcu::findOrFail($id);
        $path = "reports/mcu_{$mcu->id}.pdf";

        // Jika sudah pernah dibuat dan masih relevan (tidak ada perubahan)
        if (Storage::exists($path)) {
            return Storage::download($path);
        }

        // Kalau belum ada, generate baru
        $pdf = SnappyPdf::loadView('reports.patient.pdf.emcu_report.generate.pdf_emcu', compact('mcu'))
            ->setOption('page-size', 'A4')
            ->setOption('enable-local-file-access', true)
            ->setOption('dpi', 300);

        Storage::put($path, $pdf->output());

        return Storage::download($path);
    }


    public function emcuReport($id)
    {
        // Ambil data MCU berdasarkan ID
        $mcu = Mcu::with(['dokter', 'pemeriksaan'])->findOrFail($id);

        // Generate PDF dari view
        $pdf = PDF::loadView('reports.patient.pdf.emcu_report.generate.pdf_emcu', compact('mcu'))
            ->setOption('page-size', 'A4')
            ->setOption('dpi', 300)
            ->setOption('enable-local-file-access', true);

        // Bisa pilih salah satu: langsung tampil atau download
        return $pdf->inline('Laporan_MCU_'.$mcu->nama.'.pdf'); // tampil di browser
        // return $pdf->download('Laporan_MCU_'.$mcu->nama.'.pdf'); // langsung download
    } */
}
