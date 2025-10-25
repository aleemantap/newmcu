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
use Spatie\Browsershot\Browsershot;

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
	public function emcuDua($id)
{
    $mcu = Mcu::findOrFail($id);
    
    $pdf = Browsershot::html(
        view('reports.patient.pdf.emcu_report.generate.pdf_emcu', compact('mcu'))->render()
    )
    ->noSandbox() // <- Ini yang penting untuk Windows
    ->format('A4')
    ->pdf();

    return response($pdf)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="mcu_'.$mcu->id.'.pdf"');
}
	
	public function emcuDua111($id)
{
    $mcu = Mcu::findOrFail($id);
    $ttd = $this->dataTtd($mcu);
    $audiometriChart = $this->getChartFromImagechart($id);
    $html = view('reports.patient.pdf.emcu_report.generate.pdf_emcu', [
            'mcu' => $mcu,
            'audiometriChart' => $audiometriChart,
			'lg'=> "tes"
        ]+$ttd)->render();

    $path = storage_path("app/public/reports/mcu_{$mcu->id}.pdf");

    Browsershot::html($html)
        ->margins(10, 10, 10, 10)
        ->format('A4')
        ->showBackground()
        ->save($path);

    return response()->download($path);
}
	
	public function emcuDua22($id)
{
    $mcu = Mcu::findOrFail($id);

    $filename = "mcu_{$mcu->id}.pdf";
    $path = 'reports/' . $filename;

    // Pastikan folder ada
    if (!Storage::disk('public')->exists('reports')) {
        Storage::disk('public')->makeDirectory('reports');
    }

    $ttd = $this->dataTtd($mcu);
    $audiometriChart = $this->getChartFromImagechart($id);

    if (!Storage::disk('public')->exists($path)) {

        // ✅ Render HTML dari view Blade
        $html = view('reports.patient.pdf.emcu_report.generate.pdf_emcu', [
            'mcu' => $mcu,
            'audiometriChart' => $audiometriChart,
			'lg'=> "tes"
        ]+$ttd)->render();
	    // file_put_contents(storage_path('app/public/debug_pdf.html'), $html);

        // Log HTML untuk debug (pastikan panjangnya muncul)
       //Log::info('PDF HTML Rendered:', [substr($html, 0, 500)]); // log 500 karakter pertama saja

        // ✅ Generate PDF dari HTML
        $pdf = SnappyPdf::loadHTML($html)
            ->setOptions([
                'no-outline' => true,
                'page-size' => 'A4',
                'dpi' => 300,
                'enable-local-file-access' => true,
                'margin-top' => 10,
                'margin-right' => 10,
                'margin-bottom' => 10,
                'margin-left' => 10,
                'print-media-type' => true,
            ]);

        // ✅ Simpan ke storage publik
        Storage::disk('public')->put($path, $pdf->output());

        //Log::info('PDF saved to: ' . Storage::disk('public')->path($path));
    }

    // ✅ Download file dari storage publik
    return Storage::disk('public')->download($path);
}

	
public function emcuDua222($id)
{
    $mcu = Mcu::findOrFail($id);
    
    $filename = "mcu_{$mcu->id}.pdf";
    $path = 'reports/' . $filename;

    // Gunakan public disk
    if (!Storage::disk('public')->exists('reports')) {
        Storage::disk('public')->makeDirectory('reports');
    }// 'audiometriChart', 'ttd'
    $ttd = $this->dataTtd($mcu);
    $audiometriChart = $this->getChartFromImagechart($id);
    if (!Storage::disk('public')->exists($path)) {
        $pdf = SnappyPdf::loadView(
            'reports.patient.pdf.emcu_report.generate.pdf_emcu',
             compact('mcu')) 
			 ->setOptions([
            'no-outline' => true,
            'page-size' => 'A4',
            'dpi' => 300,
            'enable-local-file-access' => true,
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'print-media-type' => true,
        ]);

        // Simpan ke public disk
        Storage::disk('public')->put($path, $pdf->output());
        \Log::info('PDF HTML Content:', [$pdf]);
        //Log::info('PDF saved to: ' . Storage::disk('public')->path($path));
    }

    // Download dari public disk
    return Storage::disk('public')->download($path);
}

    public function emcuDua3($id)
{
    $mcu = Mcu::findOrFail($id);

    // Gunakan path yang konsisten
    $filename = "mcu_{$mcu->id}.pdf";
    $directory = 'reports';
    $path = $directory . '/' . $filename;

    try {
        // Pastikan folder 'reports' ada
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }

        // Generate PDF hanya jika belum ada
        if (!Storage::disk('local')->exists($path)) {
            $pdf = SnappyPdf::loadView(
                'reports.patient.pdf.emcu_report.generate.pdf_emcu',
                compact('mcu')
            )->setOptions([
                'no-outline' => true,
                'page-size' => 'A4',
                'dpi' => 300,
                'enable-local-file-access' => true,
            ]);

            // Coba metode yang berbeda:
            
            // Metode 1: Simpan langsung
            $pdf->save(storage_path('app/' . $path));
            
            // Atau Metode 2: Gunakan Storage put
            // Storage::disk('local')->put($path, $pdf->output());
            
            Log::info('PDF berhasil disimpan di: ' . storage_path('app/' . $path));
        }

        // Cek apakah file benar-benar ada
        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        } else {
            throw new \Exception("File PDF tidak ditemukan setelah generate");
        }

    } catch (\Exception $e) {
        Log::error('Error generate PDF: ' . $e->getMessage());
        return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
    }
}
  
   public function emcuDua2($id)
    {
        $mcu = Mcu::findOrFail($id);

        $path = "reports/mcu_{$mcu->id}.pdf";

        // Pastikan folder 'reports' ada
        if (!Storage::exists('reports')) {
            Storage::makeDirectory('reports');
        }

        // Generate PDF hanya jika belum ada
        if (!Storage::exists($path)) {
            $pdf = \Barryvdh\Snappy\Facades\SnappyPdf::loadView(
                'reports.patient.pdf.emcu_report.generate.pdf_emcu',
                compact('mcu')
            )->setOptions([
                'no-outline' => true,
                'page-size' => 'A4',
                'dpi' => 300,
                'enable-local-file-access' => true,
            ]);

            //  Storage::put($path, $pdf->output());
             //$pdf->save(storage_path('app/' . $path));
             //Log::info('PDF tersimpan di: ' . storage_path("app/{$path}"));

              Storage::disk('public')->put('pdf/' . $path, $pdf->output());
    
 
        }

        // Unduh file dari storage
        return Storage::download($path);
    }

    
	public function downloadx($id) 
{
    $mcu = Mcu::find($id);
    
    $c = $this->chart($id);
    $labels = implode(", ", $c[0]); 
    $kiri = implode(", ", $c[1]);
    $kanan = implode(", ", $c[2]);
    
    // Return view sebagai HTML (bukan PDF)
    return view('reports.patient.pdf.emcu_report', [
        'data' => $mcu,
        'audiometriChart' => $this->getChartFromImagechart($id),
        'labels' => $labels,
        'kiri' => $kiri, 
        'kanan' => $kanan
    ] + $this->dataTtd($mcu));
}
	public function download($id) 
    {
        
        $mcu = Mcu::find($id);
       
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);
        
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report.generate.pdf_emcu', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
        ]+$this->dataTtd($mcu))->setPaper('A4', 'portrait');
		$pdf->setOptions([
			'dpi' => 72,
			'defaultFont' => 'DejaVu Sans',
			'isRemoteEnabled' => true,
			'isHtml5ParserEnabled' => true,
			'isPhpEnabled' => true,
		]);
		//->setOptions([
          //  'no-outline' => true,
            //'page-size' => 'A4',
            //'dpi' => 400,
            //'enable-local-file-access' => true,
        //]);
        //$file = str_replace(" ","-",$id).'-'.$mcu->nama_pasien.'.pdf';
        //return $pdf->download($file);
        // $path = "reports/mcu_{$mcu->id}.pdf";
        //Log::info('PDF Options:', $pdf->getOptions());
        //\Illuminate\Support\Facades\Storage::put($path, $pdf->output());
        
        //return \Illuminate\Support\Facades\Storage::download($path);
		 $output = $pdf->stream();
		
        return $output;
       
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


public function exportPdf($id)
{
    $mcu = MCU::findOrFail($id);

    // 🔹 Pastikan folder tmp ada
    if (!file_exists(storage_path('app/tmp'))) {
        mkdir(storage_path('app/tmp'), 0777, true);
    }

    // 1️⃣ Render Blade ke HTML file sementara
    //$html = view('reports.patient.pdf.emcu_report.generate.tes_emcu', compact('mcu'))->render();
	$ttd = $this->dataTtd($mcu);
    $audiometriChart = $this->getChartFromImagechart($id);
    $html = view('reports.patient.pdf.emcu_report.generate.tes_emcu', [
            'data' => $mcu,
            'audiometriChart' => $audiometriChart,
			'lg'=> "tes"
        ]+$ttd)->render();
	// $html = view('reports.patient.pdf.emcu_report.generate.pdf', compact('mcu'))->render();
    $tmpHtml = storage_path("app/tmp/mcu_{$id}.html");
    file_put_contents($tmpHtml, $html);

    // 2️⃣ Tentukan path output PDF
    $pdfPath = storage_path("app/public/pdf/mcu_{$id}.pdf");

    // Pastikan folder output ada
    if (!file_exists(dirname($pdfPath))) {
        mkdir(dirname($pdfPath), 0777, true);
    }

    // 3️⃣ Tentukan path Python script
    $python = base_path('scripts/generate_pdf.py');

    // Escape semua path agar aman
    $pythonEsc = escapeshellarg($python);
    $tmpHtmlEsc = escapeshellarg($tmpHtml);
    $pdfPathEsc = escapeshellarg($pdfPath);

    // Gunakan python (Windows) atau python3 (Linux/Mac)
    $pythonCmd = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'python' : 'python3';

    // ⏱️ Mulai timer
    $start = microtime(true);

    // Jalankan perintah Python
    $cmd = "{$pythonCmd} {$pythonEsc} {$tmpHtmlEsc} {$pdfPathEsc}";
    exec($cmd . " 2>&1", $output, $status); // redirect error ke output

    // ⏱️ Hitung waktu eksekusi
    $duration = round(microtime(true) - $start, 2); // dalam detik

    // 4️⃣ Normalisasi path agar file_exists berfungsi di Windows
    $normalizedPath = str_replace(['\\', '"'], ['/', ''], $pdfPath);

    // 5️⃣ Cek hasil
    if ($status === 0 && file_exists($normalizedPath)) {
        return response()->json([
            'success' => true,
            'message' => 'PDF berhasil dibuat',
            'path' => $normalizedPath,
            'duration' => "{$duration} detik",
            'output' => $output,
        ]);
    }

    // 6️⃣ Kalau gagal, kirim pesan debug
    return response()->json([
        'success' => false,
        'message' => 'Gagal generate PDF',
        'duration' => "{$duration} detik",
        'output' => $output,
        'cmd' => $cmd,
    ], 500);
}


public function exportPdf_($id)
{
    $mcu = MCU::findOrFail($id);

    // 🔹 Pastikan folder tmp ada
    if (!file_exists(storage_path('app/tmp'))) {
        mkdir(storage_path('app/tmp'), 0777, true);
    }

    // 1️⃣ Render Blade ke HTML file sementara
    $html = view('reports.patient.pdf.emcu_report.generate.pdf', compact('mcu'))->render();
    $tmpHtml = storage_path("app/tmp/mcu_{$id}.html");
    file_put_contents($tmpHtml, $html);

    // 2️⃣ Tentukan path output PDF
    $pdfPath = storage_path("app/public/pdf/mcu_{$id}.pdf");

    // Pastikan folder output ada
    if (!file_exists(dirname($pdfPath))) {
        mkdir(dirname($pdfPath), 0777, true);
    }

    // 3️⃣ Tentukan path Python script
    $python = base_path('scripts/generate_pdf.py');

    // Escape semua path agar aman
    $pythonEsc = escapeshellarg($python);
    $tmpHtmlEsc = escapeshellarg($tmpHtml);
    $pdfPathEsc = escapeshellarg($pdfPath);

    // Gunakan python (Windows) atau python3 (Linux/Mac)
    $pythonCmd = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'python' : 'python3';

    // ⏱️ Mulai timer
    $start = microtime(true);

    // Jalankan perintah Python
    $cmd = "{$pythonCmd} {$pythonEsc} {$tmpHtmlEsc} {$pdfPathEsc}";
    exec($cmd . " 2>&1", $output, $status); // redirect error ke output

    // ⏱️ Hitung waktu eksekusi
    $duration = round(microtime(true) - $start, 2); // dalam detik

    // 4️⃣ Normalisasi path agar file_exists berfungsi di Windows
    $normalizedPath = str_replace(['\\', '"'], ['/', ''], $pdfPath);

    // 5️⃣ Cek hasil
    if ($status === 0 && file_exists($normalizedPath)) {
        return response()->json([
            'success' => true,
            'message' => 'PDF berhasil dibuat',
            'path' => $normalizedPath,
            'duration' => "{$duration} detik",
            'output' => $output,
        ]);
    }

    // 6️⃣ Kalau gagal, kirim pesan debug
    return response()->json([
        'success' => false,
        'message' => 'Gagal generate PDF',
        'duration' => "{$duration} detik",
        'output' => $output,
        'cmd' => $cmd,
    ], 500);
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
