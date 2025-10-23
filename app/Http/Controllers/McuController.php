<?php

namespace App\Http\Controllers;
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
use Illuminate\Support\Facades\Storage;
use App\Models\Ttd;

class McuController extends Controller
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

    /**
     * Get department by customer id
     * @param type $cusotmerId
     */
    public function department($idPerusahaan)
    {
        $departments = Mcu::selectRaw('distinct(bagian)')
            ->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
                $q->where('id', $idPerusahaan);
            })->get();
        return response()->json($departments);
    }

    /**
     * Get client by customer id
     * @param type $idPerusahaan
     * @return type
     */
    public function client($idPerusahaan)
    {
        $clients = Mcu::selectRaw('distinct(client)')->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
            $q->where('id', $idPerusahaan);
        })->get();
        return response()->json($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = VendorCustomer::all();
        return view('pages.mcu.form', ['projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if(empty($request->medical_id)) {
            return back()->with('error', 'Medical id can\'t be empty');
        }

        if(empty($request->mcu_tgl_input)) {
            return back()->with('error', 'Tgl input can\'t be empty');
        }

        if(empty($request->mcu_customer_id)) {
            return back()->with('error', 'Please select customer');
        }

        $mcu_id = date('Ymd', strtotime($request->mcu_tgl_input))
                . str_pad($request->mcu_customer_id, 4, 0, 0)
                . str_pad($request->medical_id, 8, 0, 0);

		$this->konvert_post_toData_array($mcu_id, $request);

		return back()->with('success', 'Data has been saved successfully');
    }

	public function store_(Request $request)
    {

        if(empty($request->medical_id)) {
            return back()->with('error', 'Medical id can\'t be empty');
        }

        if(empty($request->mcu_tgl_input)) {
            return back()->with('error', 'Tgl input can\'t be empty');
        }

        if(empty($request->mcu_customer_id)) {
            return back()->with('error', 'Please select customer');
        }

        $mcu_id = date('Ymd', strtotime($request->mcu_tgl_input))
                . str_pad($request->mcu_customer_id, 4, 0, 0)
                . str_pad($request->medical_id, 8, 0, 0);

        // Main MCU
        $mcu = new Mcu;
        $mcu->id = $mcu_id;
        $mcu->no_nip = $request->mcu_no_nip;
        $mcu->no_paper = $request->mcu_no_paper;
        $mcu->tgl_input = $request->mcu_tgl_input;
        $mcu->nama_pasien = $request->mcu_nama_pasien;
        $mcu->tgl_lahir = $request->mcu_tgl_lahir;
        $mcu->jenis_kelamin = $request->mcu_jenis_kelamin;
        $mcu->bagian = $request->mcu_bagian;
        $mcu->paket_mcu = $request->mcu_paket_mcu;
        $mcu->tgl_kerja = $request->mcu_tgl_kerja;
        $mcu->email = $request->mcu_email;
        $mcu->telepon = $request->mcu_telepon;
        $mcu->client = $request->mcu_client;
        $mcu->vendor_customer_id = $request->mcu_vendor_customer_id;

        // Umum
        $umum = new Umum;
        $umum->nadi = $request->umum_nadi;
        $umum->sistolik = $request->umum_sistolik;
        $umum->diastolik = $request->umum_diastolik;
        $umum->respirasi = $request->umum_respirasi;
        $umum->suhu = $request->umum_suhu;
        $umum->mcu_id = $mcu_id;
        $umum->save();

        // Riwayat
        $riwayat = new Riwayat;
        $riwayat->keluhan_utama = $request->riwayat_keluhan_utama;
        $riwayat->riwayat_alergi = $request->riwayat_riwayat_alergi;
        $riwayat->riwayat_penyakit_sekarang = $request->riwayat_riwayat_penyakit_sekarang;
        $riwayat->riwayat_kesehatan_dahulu = $request->riwayat_riwayat_kesehatan_dahulu;
        $riwayat->riwayat_kesehatan_keluarga = $request->riwayat_riwayat_kesehatan_keluarga;
        $riwayat->riwayat_kesehatan_pribadi = $request->riwayat_riwayat_kesehatan_pribadi;
        $riwayat->olahraga = $request->riwayat_olahraga;
        $riwayat->frekuensi_per_minggu = $request->riwayat_frekuensi_per_minggu;
        $riwayat->merokok = $request->riwayat_merokok;
        $riwayat->rokok_bungkus_per_hari = $request->riwayat_rokok_bungkus_per_hari;
        $riwayat->kopi = $request->riwayat_kopi;
        $riwayat->kopi_gelas_per_hari = $request->riwayat_kopi_gelas_per_hari;
        $riwayat->alkohol = $request->riwayat_alkohol;
        $riwayat->alkohol_sebanyak = $request->riwayat_alkohol_sebanyak;
        $riwayat->lama_tidur_per_hari = $request->riwayat_lama_tidur_per_hari;
        $riwayat->pernah_kecelakaan_kerja = $request->riwayat_pernah_kecelakaan_kerja;
        $riwayat->tahun_kecelakaan_kerja = $request->riwayat_tahun_kecelakaan_kerja;
        $riwayat->tempat_kerja_berbahaya = $request->riwayat_tempat_kerja_berbahaya;
        $riwayat->pernah_rawat_inap = $request->riwayat_pernah_rawat_inap;
        $riwayat->hari_lama_rawat_inap = $request->riwayat_hari_lama_rawat_inap;
        $riwayat->rawat_inap_penyakit = $request->riwayat_rawat_inap_penyakit;
        $riwayat->mcu_id = $mcu_id;
        $riwayat->save();

        // Antrovisus
        $antrovisus = new Antrovisus;
        $antrovisus->berat_badan = $request->antrovisus_berat_badan;
        $antrovisus->tinggi_badan = $request->antrovisus_tinggi_badan;
        $antrovisus->bmi = $request->antrovisus_bmi;
        $antrovisus->visus_kanan = $request->antrovisus_visus_kanan;
        $antrovisus->visus_kiri = $request->antrovisus_visus_kiri;
        $antrovisus->rekomendasi_kacamatan = $request->antrovisus_rekomendasi_kacamatan;
        $antrovisus->spheris_kanan = $request->antrovisus_spheris_kanan;
        $antrovisus->cylinder_kanan = $request->antrovisus_cylinder_kanan;
        $antrovisus->axis_kanan = $request->antrovisus_axis_kanan;
        $antrovisus->addition_kanan = $request->antrovisus_addition_kanan;
        $antrovisus->spheris_kiri = $request->antrovisus_spheris_kiri;
        $antrovisus->cylinder_kiri = $request->antrovisus_cylinder_kiri;
        $antrovisus->axis_kiri = $request->antrovisus_axis_kiri;
        $antrovisus->addition_kiri = $request->antrovisus_addition_kiri;
        $antrovisus->pupil_distance = $request->antrovisus_pupil_distance;
        $antrovisus->mcu_id = $mcu_id;
        $antrovisus->save();

        // Fisik
        if($request->fisik_diperiksa == 'DIPERIKSA') {
            $fisik = new Fisik;
            $fisik->kepala = $request->fisik_kepala;
            $fisik->mata = $request->fisik_mata;
            $fisik->telinga = $request->fisik_telinga;
            $fisik->hidung = $request->fisik_hidung;
            $fisik->tenggorokan = $request->fisik_tenggorokan;
            $fisik->leher = $request->fisik_leher;
            $fisik->mulut = $request->fisik_mulut;
            $fisik->gigi = $request->fisik_gigi;
            $fisik->dada = $request->fisik_dada;
            $fisik->abdomen = $request->fisik_abdomen;
            $fisik->extremitas = $request->fisik_extremitas;
            $fisik->anogenital = $request->fisik_anogenital;
            $fisik->anogenital = $request->fisik_anogenital;
            $fisik->mcu_id = $mcu_id;
            $fisik->save();
        }

        // Hematologi
        if($request->hematologi_diperiksa == 'DIPERIKSA') {
            $hematologi = new Hematologi;
            $hematologi->hemoglobin = $request->hematologi_hemoglobin;
            $hematologi->hematokrit = $request->hematologi_hematokrit;
            $hematologi->eritrosit = $request->hematologi_eritrosit;
            $hematologi->leukosit = $request->hematologi_leukosit;
            $hematologi->trombosit = $request->hematologi_trombosit;
            $hematologi->basofil = $request->hematologi_basofil;
            $hematologi->eosinofil = $request->hematologi_eosinofil;
            $hematologi->neutrofil_batang = $request->hematologi_neutrofil_batang;
            $hematologi->neutrofil_segment = $request->hematologi_neutrofil_segment;
            $hematologi->limfosit = $request->hematologi_limfosit;
            $hematologi->monosit = $request->hematologi_monosit;
            $hematologi->laju_endap_darah = $request->hematologi_laju_endap_darah;
            $hematologi->mcv = $request->hematologi_mcv;
            $hematologi->mch = $request->hematologi_mch;
            $hematologi->mchc = $request->hematologi_mchc;
            $hematologi->golongan_darah_abo = $request->hematologi_golongan_darah_abo;
            $hematologi->golongan_darah_rh = $request->hematologi_golongan_darah_rh;
            $hematologi->golongan_darah_rh = $request->hematologi_golongan_darah_rh;
            $hematologi->mcu_id = $mcu_id;
            $hematologi->save();
        }

        if($request->kimia_diperiksa == 'DIPERIKSA') {
            $kimia = new Kimia;
            $kimia->gds = $request->kimia_gds;
            $kimia->gdp = $request->kimia_gdp;
            $kimia->dua_jam_pp = $request->kimia_2_jam_pp; //need help for field name
            $kimia->hba1c = $request->kimia_hba1c;
            $kimia->ureum = $request->kimia_ureum;
            $kimia->kreatinin = $request->kimia_kreatinin;
            $kimia->asam_urat = $request->kimia_asam_urat;
            $kimia->bilirubin_total = $request->kimia_bilirubin_total;
            $kimia->bilirubin_direk = $request->kimia_bilirubin_direk;
            $kimia->bilirubin_indirek = $request->kimia_bilirubin_indirek;
            $kimia->sgot = $request->kimia_sgot;
            $kimia->sgpt = $request->kimia_sgpt;
            $kimia->protein = $request->kimia_protein;
            $kimia->albumin = $request->kimia_albumin;
            $kimia->alkaline_fosfatase = $request->kimia_alkaline_fosfatase;
            $kimia->choline_esterase = $request->kimia_choline_esterase;
            $kimia->gamma_gt = $request->kimia_gamma_gt;
            $kimia->trigliserida = $request->kimia_trigliserida;
            $kimia->kolesterol_total = $request->kimia_kolesterol_total;
            $kimia->hdl = $request->kimia_hdl;
            $kimia->ldl_direk = $request->kimia_ldl_direk;
            $kimia->ldl_indirek = $request->kimia_ldl_indirek;
            $kimia->ck = $request->kimia_ck;
            $kimia->ckmb = $request->kimia_ckmb;
            $kimia->spuktum_bta1 = $request->kimia_spuktum_bta1;
            $kimia->spuktum_bta2 = $request->kimia_spuktum_bta2;
            $kimia->spuktum_bta3 = $request->kimia_spuktum_bta3;
            $kimia->mcu_id = $mcu_id;
            $kimia->save();
        }
        if($request->oae_diperiksa == 'DIPERIKSA') {
            $oae = new Oae;
            $oae->hasil_oae_ka = $request->oae_hasil_oae_ka;
            $oae->hasil_oae_ki = $request->oae_hasil_oae_ki;
            $oae->kesimpulan_oae = $request->oae_kesimpulan;
            $oae->mcu_id = $mcu_id;
            $oae->save();
        }

        if($request->rontgen_diperiksa == 'DIPERIKSA') {
            //$mcu->kesan_rontgen = $request->kesan_rontgen;

			$rontgen = Rontgen::updateOrCreate(
				[
					'mcu_id' => $mcu_id,

				],
				[
					'kesan_rontgen' => $request->kesan_rontgen
				]
			);
			//$rontgen->save();



            foreach($request->rontgen_jenis_foto as $i => $jenis_foto) {
                $rontgen = RontgenDetail::updateOrCreate(
                    [
                        'mcu_id' => $mcu_id,
                        'parameter' => $request->rontgen_parameter[$i]
                    ],
                    [
                        'jenis_foto' => $jenis_foto,
                        'temuan' => $request->rontgen_temuan[$i]
                    ]
                );
                $rontgen->save();
            }
        }

        $serologi = new Serologi;
        $serologi->hbsag = $request->serologi_hbsag;
        $serologi->anti_hbs = $request->serologi_anti_hbs;
        $serologi->tuberculosis = $request->serologi_tuberculosis;
        $serologi->igm_salmonella = $request->serologi_igm_salmonella;
        $serologi->igg_salmonella = $request->serologi_igg_salmonella;
        $serologi->salmonela_typhi_o = $request->serologi_salmonela_typhi_o;
        $serologi->salmonela_typhi_h = $request->serologi_salmonela_typhi_h;
        $serologi->salmonela_parathypi_a_o = $request->serologi_salmonela_parathypi_a_o;
        $serologi->salmonela_parathypi_a_h = $request->serologi_salmonela_parathypi_a_h;
        $serologi->salmonela_parathypi_b_o = $request->serologi_salmonela_parathypi_b_o;
        $serologi->salmonela_parathypi_b_h = $request->serologi_salmonela_parathypi_b_h;
        $serologi->salmonela_parathypi_c_o = $request->serologi_salmonela_parathypi_c_o;
        $serologi->salmonela_parathypi_c_h = $request->serologi_salmonela_parathypi_c_h;
        $serologi->hcg = $request->serologi_hcg;
        $serologi->psa = $request->serologi_psa;
        $serologi->afp = $request->serologi_afp;
        $serologi->cea = $request->serologi_cea;
        $serologi->igm_toxo = $request->serologi_igm_toxo;
        $serologi->igg_toxo = $request->serologi_igg_toxo;
        $serologi->ckmb_serologi = $request->serologi_ckmb;
        $serologi->myoglobin = $request->serologi_myoglobin;
        $serologi->troponin_i = $request->serologi_troponin_i;
        $serologi->mcu_id = $mcu_id;
        $serologi->save();

        if($request->spirometri_diperiksa == 'DIPERIKSA') {
            $spirometri = new Spirometri;
            $spirometri->fev = $request->spirometri_fev;
            $spirometri->fvc = $request->spirometri_fvc;
            $spirometri->pef = $request->spirometri_pef;
            $spirometri->kesimpulan_spirometri = $request->spirometri_kesimpulan;

            if ($request->hasFile('file')) {

				$file = $request->file('file');

				$dt = new DateTime();
				$dt =  $dt->format('YmdHis');
				//$dt = Carbon::now()->toDateTimeString();
				$name = $request->mcu_id."_".$dt;
				$name = $name.".".$file->getClientOriginalExtension();
				$file->move('chart_spirometri',$name);
				$spirometri->chart = $name;




			}
			$spirometri->mcu_id = $mcu_id;
            $spirometri->save();
        }

        if($request->ekg_diperiksa == 'DIPERIKSA') {
            $ekg = new Ekg();
            $ekg->hasil_ekg = $request->ekg_hasil;
            $ekg->kesimpulan_ekg = $request->ekg_kesimpulan;
            $ekg->mcu_id = $mcu_id;
            $ekg->save();
        }

        if($request->treadmill_diperiksa == 'DIPERIKSA') {
            $treadmill = new Treadmill;
            $treadmill->resting_ekg = $request->treadmill_resting_ekg;
            $treadmill->bruce_heart_beat = $request->treadmill_bruce_heart_beat;
            $treadmill->capaian_heart_beat = $request->treadmill_capaian_heart_beat;
            $treadmill->capaian_menit = $request->treadmill_capaian_menit;
            $treadmill->respon_heart_beat = $request->treadmill_respon_heart_beat;
            $treadmill->respon_sistol = $request->treadmill_respon_sistol;
            $treadmill->respon_diastol = $request->treadmill_respon_diastol;
            $treadmill->aritmia = $request->treadmill_aritmia;
            $treadmill->nyeri_dada = $request->treadmill_nyeri_dada;
            $treadmill->gejala_lain = $request->treadmill_gejala_lain;
            $treadmill->perubahan_segmen_st = $request->treadmill_perubahan_segmen_st;
            $treadmill->lead = $request->treadmill_lead;
            $treadmill->lead_pada_menit_ke = $request->treadmill_lead_pada_menit_ke;
            $treadmill->normalisasi_setelah = $request->treadmill_normalisasi_setelah;
            $treadmill->functional_class = $request->treadmill_functional_class;
            $treadmill->kapasitas_aerobik = $request->treadmill_kapasitas_aerobik;
            $treadmill->tingkat_kesegaran = $request->treadmill_tingkat_kesegaran;
            $treadmill->grafik = $request->treadmill_grafik;
            $treadmill->kesimpulan_treadmill = $request->treadmill_kesimpulan;
            $treadmill->mcu_id = $mcu_id;
            $treadmill->save();
        }

        if($request->audiometri_diperiksa == 'DIPERIKSA') {
            foreach($request->audiometri_frekuensi as $i => $frekuensi) {
                $audiometri = Audiometri::updateOrCreate(
                    [
                        'mcu_id' => $mcu_id,
                        'frekuensi' => $frekuensi
                    ],
                    [
                        'kiri' => $request->audiometri_kiri[$i],
                        'kanan' => $request->audiometri_kiri[$i]
                    ]
                );
                $audiometri->save();
            }
        }

        if($request->feses_diperiksa == 'DIPERIKSA') {
            $feses = new Feses;
            $feses->warna_feses = $request->feses_warna;
            $feses->konsistensi = $request->feses_konsistensi;
            $feses->darah_feses = $request->feses_darah;
            $feses->lendir = $request->feses_lendir;
            $feses->eritrosit_feses = $request->feses_eritrosit;
            $feses->leukosit_feses = $request->feses_leukosit;
            $feses->amoeba = $request->feses_amoeba;
            $feses->e_hystolitica = $request->feses_e_hystolitica;
            $feses->e_coli_feses = $request->feses_e_coli;
            $feses->kista = $request->feses_kista;
            $feses->ascaris = $request->feses_ascaris;
            $feses->oxyuris = $request->feses_oxyuris;
            $feses->serat = $request->feses_serat;
            $feses->lemak = $request->feses_lemak;
            $feses->karbohidrat = $request->feses_karbohidrat;
            $feses->benzidine = $request->feses_benzidine;
            $feses->lain_lain = $request->feses_lain_lain;
            $feses->mcu_id = $mcu_id;
            $feses->save();
        }

        if($request->urin_diperiksa == 'DIPERIKSA') {
            $urin = new Urin;
            $urin->warna_urin = $request->urin_warna;
            $urin->kejernihan = $request->urin_kejernihan;
            $urin->berat_jenis = $request->urin_berat_jenis;
            $urin->ph = $request->urin_ph;
            $urin->protein_urin = $request->urin_protein_urin;
            $urin->reduksi = $request->urin_reduksi;
            $urin->keton = $request->urin_keton;
            $urin->bilirubin = $request->urin_bilirubin;
            $urin->urobilinogen = $request->urin_urobilinogen;
            $urin->leukosit_esterase = $request->urin_leukosit_esterase;
            $urin->darah_urin = $request->urin_darah;
            $urin->nitrit = $request->urin_nitrit;
            $urin->sedimen_eritrosit = $request->urin_sedimen_eritrosit;
            $urin->sedimen_leukosit = $request->urin_sedimen_leukosit;
            $urin->epitel = $request->urin_epitel;
            $urin->silinder = $request->urin_silinder;
            $urin->kristal = $request->urin_kristal;
            $urin->bakteri = $request->urin_bakteri;
            $urin->jamur = $request->urin_jamur;
            $urin->hcg_urin = $request->urin_hcg;
            $urin->mcu_id = $mcu_id;
            $urin->save();
        }

        $pap_smear = new PapSmear;
        $pap_smear->tgl_terima = $request->pap_smear_tgl_terima;
        $pap_smear->tgl_selesai = $request->pap_smear_tgl_selesai;
        $pap_smear->bahan_pemeriksaan = $request->pap_smear_bahan_pemeriksaan;
        $pap_smear->makroskopik = $request->pap_smear_makroskopik;
        $pap_smear->mikroskopik = $request->pap_smear_mikroskopik;
        $pap_smear->kesimpulan_pap_smear = $request->pap_smear_kesimpulan;
        $pap_smear->mcu_id = $mcu_id;
        $pap_smear->save();

        if($request->rectal_swab_diperiksa == 'DIPERIKSA') {
            $rectalswab = new RectalSwab();
            $rectalswab->typoid = $request->rectalswab_typoid;
            $rectalswab->diare = $request->rectalswab_diare;
            $rectalswab->disentri = $request->rectalswab_disentri;
            $rectalswab->kolera = $request->rectalswab_kolera;
            $rectalswab->salmonella = $request->rectalswab_salmonella;
            $rectalswab->shigella = $request->rectalswab_shigella;
            $rectalswab->e_coli = $request->rectalswab_e_coli;
            $rectalswab->vibrio_cholera = $request->rectalswab_vibrio_cholera;
            $rectalswab->kesimpulan_rectal_swab = $request->rectalswab_kesimpulan;
            $rectalswab->mcu_id = $mcu_id;
            $rectalswab->save();
        }

        if($request->drug_screening_diperiksa == 'DIPERIKSA') {
//            foreach($request->drug_screening_status_pemeriksaan as $i => $status) {
//                $drug_screening = DrugScreening::updateOrCreate([
//                    'mcu_id' => $mcu_id,
//                    'parameter' => $request->drug_screening_parameter[$i]
//                ],[
//                    'hasil' => $request->drug_screening_hasil[$i],
//                    'tgl_pemeriksaan' => $request->drug_screening_tgl_pemeriksaan[$i],
//                    'status_pemeriksaan' => $status
//                ]);
//                $drug_screening->save();
//            }
        }

        $mcu->save();

        return back()->with('success', 'Data has been saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mcu  $mcu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mcu = Mcu::find($id);
        $customer = Customer::get();

        return view('pages.mcu.edit', ['mcu' => $mcu, 'customers' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mcu  $mcu
     * @return \Illuminate\Http\Response
     */
	
		
    public function edit($id)
    {
        $mcu = Mcu::where('id', $id)->first();
		
		$satuan = DB::select("select  
					
					a.ket_or_satuan,
					d.field
					from formula_details  a

					left join formulas b on b.id = a.formula_id
					left join rumus_details c on  c.rumus_id = b.rumus_id
					left join parameters d on d.id = c.parameter_id

					where 
					a.ket_or_satuan != ''

					group by a.ket_or_satuan,d.field");
		
     
        $projects = VendorCustomer::get();
        return view('pages.mcu.edit', ['mcu' => $mcu, 'projects' => $projects, 'satuan'=> $satuan ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mcu  $mcu
     * @return \Illuminate\Http\Response
     */

	private function setAsDate($date)
    {
        if(empty($date)) {
            return NULL;
        }

        if(is_string($date)) {
            return date('Y-m-d', strtotime($date));
        } else {
            return $date->format('Ymd');
        }
    }

    private function setInteger($integer)
    {
        if(empty($integer)) {
            return NULL;
        }

        if(is_string($integer)) {
            return (int) $integer;
        }

        return $integer;
    }

    private function setDouble($double)
    {
        if(empty($double)) {
            return NULL;
        }

        if(is_string($double)) {
            return str_replace(",", ".", $double);
        }

        return $double;
    }

    private function setYN($yn)
    {
        if($yn == TRUE || $yn == 1 ) {
            return 'Y';
        } else {
            return 'N';
        }
    }
	public function konvert_post_toData_array($id_mcu, $request)
    {

		    //$mcuId = $request->mcu_id;
		    $mcuId = $id_mcu;
		    $r = array();
		    //Medical Check Up
		    $r[1] = $request->mcu_no_nip;
		    $r[2] = $request->mcu_no_paper;
		    $r[13] =  $request->mcu_tgl_input;
		    $r[3] = $request->mcu_nama_pasien;
		    $r[4] = $request->mcu_tgl_lahir;
		    $r[5] = $request->mcu_jenis_kelamin;
		    $r[6] = $request->mcu_bagian;
		    $r[12] = $request->mcu_paket_mcu;
		    $r[8] = $request->mcu_tgl_kerja;
		    $r[9] = $request->mcu_email;
		    $r[10] = $request->mcu_telepon;
		    $r[7] = $request->mcu_client;
		    $r[11] = $request->mcu_vendor_customer_id;
			//$r[229]   = $request->mcu_saran; ga masuk rumus
			//$r[230]   = $request->mcu_catatan; ga masuk rumus

		    Mcu::updateOrCreate(
                [
                    'id'    => $mcuId
                ],
                [
                    'no_nip'        => $r[1],
                    'no_paper'      => $r[2],
                    //'tgl_input'     => $this->setAsDate($r[13]),
                    'tgl_input'     => $r[13],
                    'nama_pasien'   => $r[3],
                    'tgl_lahir'     => $r[4],
                    'jenis_kelamin' => $r[5],
                    'bagian'        => $r[6],
                    'paket_mcu'     => $r[12],
                    'tgl_kerja'     => $r[8],
                    'email'         => $r[9],
                    'telepon'       => $r[10],
                    'client'        => $r[7],
                    'vendor_customer_id'   => $r[11],
                    'saran'     => $request->mcu_saran,
                    'catatan'     => $request->mcu_catatan,
                    'published'     => $request->mcu_published
                ]
            );

			//Riwayat
			$r[14] =   $request->riwayat_keluhan_utama;
		    $r[15] =   $request->riwayat_riwayat_alergi;
		    //$r[13] =
		    $r[16] = $request->riwayat_riwayat_penyakit_sekarang;
		    $r[17] = $request->riwayat_riwayat_kesehatan_dahulu;
		    $r[18] = $request->riwayat_riwayat_kesehatan_keluarga;
		    $r[19] = $request->riwayat_riwayat_kesehatan_pribadi;
		    $r[20] = $request->riwayat_olahraga;//$this->setYN($request->riwayat_olahraga);
		    $r[21] = $this->setInteger($request->riwayat_frekuensi_per_minggu);
		    $r[22] = $request->riwayat_merokok;//$this->setYN($request->riwayat_merokok);
		    $r[23] = $this->setInteger($request->riwayat_rokok_bungkus_per_hari);
		    $r[24] = $request->riwayat_kopi;//$this->setYN($request->riwayat_kopi);
		    $r[25] = $this->setInteger($request->riwayat_kopi_gelas_per_hari);
		    $r[26] = $request->riwayat_alkohol;//$this->setYN($request->riwayat_alkohol);
		    $r[27] = $request->riwayat_alkohol_sebanyak;
		    $r[28] = $this->setInteger($request->riwayat_lama_tidur_per_hari);
		    $r[29] = $request->riwayat_pernah_kecelakaan_kerja;//$this->setYN($request->riwayat_pernah_kecelakaan_kerja);
		    $r[30] = $request->riwayat_tahun_kecelakaan_kerja;
		    $r[31] = $request->riwayat_tempat_kerja_berbahaya;//$this->setYN($request->riwayat_tempat_kerja_berbahaya);
		    $r[32] = $request->riwayat_pernah_rawat_inap;//$this->setYN($request->riwayat_pernah_rawat_inap);
		    $r[33] = $this->setInteger($request->riwayat_hari_lama_rawat_inap);
		    $r[34] = $request->riwayat_rawat_inap_penyakit;

            Riwayat::updateOrCreate(
                [
                    'mcu_id'        => $mcuId
                ],
                [
                    'keluhan_utama'                 => $r[14],
                    'riwayat_alergi'                => $r[15],
                    'riwayat_penyakit_sekarang'     => $r[16],
                    'riwayat_kesehatan_dahulu'      => $r[17],
                    'riwayat_kesehatan_keluarga'    => $r[18],
                    'riwayat_kesehatan_pribadi'     => $r[19],
                    'olahraga'                      => $r[20],
                    'frekuensi_per_minggu'          => $r[21],
                    'merokok'                       => $r[22],
                    'rokok_bungkus_per_hari'        => $r[23],
                    'kopi'                          => $r[24],
                    'kopi_gelas_per_hari'           => $r[25],
                    'alkohol'                       => $r[26],
                    'alkohol_sebanyak'              => $r[27],
                    'lama_tidur_per_hari'           => $r[28],
                    'pernah_kecelakaan_kerja'       => $r[29],
                    'tahun_kecelakaan_kerja'        => $r[30],
                    'tempat_kerja_berbahaya'        => $r[31],
                    'pernah_rawat_inap'             => $r[32],
                    'hari_lama_rawat_inap'          => $r[33],
                    'rawat_inap_penyakit'           => $r[34]
                ]
            );

			// Umum
			$r[35] = $this->setInteger($request->umum_nadi);
			$r[36] = $this->setInteger($request->umum_sistolik);
			$r[37] = $this->setInteger($request->umum_diastolik);
			$r[38] = $this->setInteger($request->umum_respirasi);
			$r[39] = $this->setInteger($request->umum_suhu);

            Umum::updateOrCreate(
                [
                    'mcu_id'        => $mcuId
                ],
                [
                    'nadi'          => $r[35],
                    'sistolik'      => $r[36],
                    'diastolik'     => $r[37],
                    'respirasi'     => $r[38],
                    'suhu'          => $r[39]
                ]
            );


			// Antrovisus
			$r[41] = $this->setInteger($request->antrovisus_berat_badan);
			$r[40] = $this->setInteger($request->antrovisus_tinggi_badan);
			$r[42] = $this->setDouble($request->antrovisus_bmi);
			$r[43] = $request->antrovisus_visus_kanan;
			$r[44] = $request->antrovisus_visus_kiri;
			$r[45] = $request->antrovisus_rekomendasi_kacamatan; //$this->setYN($request->antrovisus_rekomendasi_kacamatan);
			$r[46] = $request->antrovisus_spheris_kanan;
			$r[47] = $request->antrovisus_cylinder_kanan;
			$r[48] = $request->antrovisus_axis_kanan;
			$r[49] = $request->antrovisus_addition_kanan;
			$r[50] = $request->antrovisus_spheris_kiri;
			$r[51] = $request->antrovisus_cylinder_kiri;
			$r[52] = $request->antrovisus_axis_kiri;
			$r[53] = $request->antrovisus_addition_kiri;
			$r[54] = $request->antrovisus_pupil_distance;
            Antrovisus::updateOrCreate(
                [
                    'mcu_id'        => $mcuId
                ],
                [
                    'berat_badan'   => $r[41],
                    'tinggi_badan'  => $r[40],
                    'bmi'           => $r[42],
                    'visus_kanan'   => $r[43],
                    'visus_kiri'    => $r[44],
                    'rekomendasi_kacamatan' => $r[45],
                    'spheris_kanan' => $r[46],
                    'cylinder_kanan'=> $r[47],
                    'axis_kanan'    => $r[48],
                    'addition_kanan'=> $r[49],
                    'spheris_kiri'  => $r[50],
                    'cylinder_kiri' => $r[51],
                    'axis_kiri'     => $r[52],
                    'addition_kiri' => $r[53],
                    'pupil_distance'=> $r[54]
                ]
            );

			//$periksa = array();
            //$cek_periksa = array();
			// Fisik
			$r[56] = $request->fisik_kepala;
			$r[57] = $request->fisik_mata;
			$r[58] = $request->fisik_telinga;
			$r[59] = $request->fisik_hidung;
			$r[60] = $request->fisik_tenggorokan;
			$r[61] = $request->fisik_leher;
			$r[62] = $request->fisik_mulut;
			$r[63] = $request->fisik_gigi;
			$r[64] = $request->fisik_dada;
			$r[65] = $request->fisik_abdomen;
			$r[66] = $request->fisik_extremitas;
			$r[67] = $request->fisik_anogenital;

			//array_push($periksa,range(56,67));

			if($request->fisik_diperiksa == 'DIPERIKSA') //ar 55
			{


                Fisik::updateOrCreate(
                    [
                        'mcu_id'        => $mcuId
                    ],
                    [
                        'kepala'        => $r[56],
                        'mata'          => $r[57],
                        'telinga'       => $r[58],
                        'hidung'        => $r[59],
                        'tenggorokan'   => $r[60],
                        'leher'         => $r[61],
                        'gigi'          => $r[62],
						'mulut'         => $r[63],
                        'dada'          => $r[64],
                        'abdomen'       => $r[65],
                        'extremitas'    => $r[66],
                        'anogenital'    => $r[67]
                    ]
                );

				//array_push($cek_periksa,range(56,67));
            }
			else
			{
				for($i=56; $i<=67; $i++)
				{
					unset($r[$i]);
				}
			}

			 // Hematologi

			$r[69] = $request->hematologi_hemoglobin;
			$r[70] = $request->hematologi_hematokrit;
			$r[71] = $request->hematologi_eritrosit;
			$r[72] = $request->hematologi_leukosit;
			$r[73] = $request->hematologi_trombosit;
			$r[74] = $request->hematologi_basofil;
			$r[75] = $request->hematologi_eosinofil;
			$r[76] = $request->hematologi_neutrofil_batang;
			$r[77] = $request->hematologi_neutrofil_segment;
			$r[78] = $request->hematologi_limfosit;
			$r[79] = $request->hematologi_monosit;
			$r[80] = $request->hematologi_laju_endap_darah;
			$r[81] = $request->hematologi_mcv;
			$r[82] = $request->hematologi_mch;
			$r[83] = $request->hematologi_mchc;
			$r[84] = $request->hematologi_golongan_darah_abo;
			$r[85] = $request->hematologi_golongan_darah_rh;

 			//array_push($periksa,range(69,85));
            if($request->hematologi_diperiksa  == 'DIPERIKSA') {
                Hematologi::updateOrCreate(
                    [
                        'mcu_id'            => $mcuId
                    ],
                    [
                        'hemoglobin'        => $this->setDouble($r[69]),
                        'hematokrit'        => $this->setDouble($r[70]),
                        'eritrosit'         => $this->setDouble($r[71]),
                        'leukosit'          => $this->setInteger($r[72]),
                        'trombosit'         => $this->setInteger($r[73]),
                        'basofil'           => $this->setInteger($r[74]),
                        'eosinofil'         => $this->setInteger($r[75]),
                        'neutrofil_batang'  => $this->setInteger($r[76]),
                        'neutrofil_segment' => $this->setInteger($r[77]),
                        'limfosit'          => $this->setInteger($r[78]),
                        'monosit'           => $this->setInteger($r[79]),
                        'laju_endap_darah'  => $this->setInteger($r[80]),
                        'mcv'               => $this->setDouble($r[81]),
                        'mch'               => $this->setDouble($r[82]),
                        'mchc'              => $this->setDouble($r[83]),
                        'golongan_darah_abo' => $r[84],
                        'golongan_darah_rh'  => $r[85]
                        ]
                );
				//array_push($cek_periksa,range(69,85));
            }
			else
			{
				for($i=69; $i<=85; $i++)
				{
					unset($r[$i]);
				}
			}

			// Kimia
			$r[86] = $request->kimia_gds; 
			$r[87] = $request->kimia_gdp;
			$r[88] = $request->kimia_2_jam_pp;
			$r[89] = $request->kimia_hba1c;
			$r[90] = $request->kimia_ureum;
			$r[91] = $request->kimia_kreatinin;
			$r[92] = $request->kimia_gfr;
			
			$r[93] = $request->kimia_asam_urat;
			$r[94] = $request->kimia_bilirubin_total;
			$r[95] = $request->kimia_bilirubin_direk;
			$r[96] = $request->kimia_bilirubin_indirek;
			$r[97] = $request->kimia_sgot;
			$r[98] = $request->kimia_sgpt;
			$r[99] = $request->kimia_protein;
			$r[100] = $request->kimia_albumin;
			$r[101] = $request->kimia_alkaline_fosfatase;
			$r[102] = $request->kimia_choline_esterase;
			$r[103] = $request->kimia_gamma_gt;
			$r[104] = $request->kimia_trigliserida;
			$r[105] = $request->kimia_kolesterol_total;
			$r[106] = $request->kimia_hdl;
			$r[107] = $request->kimia_ldl_direk;
			$r[108] = $request->kimia_ldl_indirek;
			$r[109] = $request->kimia_ck;
			$r[110] = $request->kimia_ckmb;
			$r[111] = $request->kimia_spuktum_bta1;
			$r[112] = $request->kimia_spuktum_bta2;
			$r[113] = $request->kimia_spuktum_bta3;


			//array_push($periksa,range(86,112));
            if($request->kimia_diperiksa == 'DIPERIKSA') {
                Kimia::updateOrCreate(
                    [
                        'mcu_id'            => $mcuId
                    ],
                    [
                        'gds'               => $this->setDouble($r[86]),
                        'gdp'               => $this->setDouble($r[87]),
                        'dua_jam_pp'        => $r[88],
                        'hba1c'             => $r[89],
                        'ureum'             => $this->setInteger($r[90]),
                        'kreatinin'         => $this->setDouble($r[91]),
						'gfr'         		=> $r[92],
                        'asam_urat'         => $r[93],
                        'bilirubin_total'   => $r[94],
                        'bilirubin_direk'   => $r[95],
                        'bilirubin_indirek' => $r[96],
                        'sgot'              => $this->setInteger($r[97]),
                        'sgpt'              => $this->setInteger($r[98]),
                        'protein'           => $r[99],
                        'albumin'           => $r[100],
                        'alkaline_fosfatase'=> $r[101],
                        'choline_esterase'  => $r[102],
                        'gamma_gt'          => $r[103],
                        'trigliserida'      => $r[104],
                        'kolesterol_total'  => $r[105],
                        'hdl'               => $r[106],
                        'ldl_direk'         => $r[107],
                        'ldl_indirek'       => $r[108],
                        'ck'                => $r[119],
                        'ckmb'              => $r[110],
                        'spuktum_bta1'      => $r[111],
                        'spuktum_bta2'      => $r[112],
                        'spuktum_bta3'      => $r[113]
                    ]
                );

				//array_push($cek_periksa,range(86,112));
            }
			else
			{
				for($i=86; $i<=113; $i++)
				{
					unset($r[$i]);
				}
			}


			// Serologi
			$r[114] = $request->serologi_hbsag;
			$r[115] = $request->serologi_anti_hbs;
			$r[116] =  $request->serologi_tuberculosis;
			$r[117] = $request->serologi_igm_salmonella;
			$r[118] = $request->serologi_igg_salmonella;
			$r[119] = $request->serologi_salmonela_typhi_o;
			$r[120] = $request->serologi_salmonela_typhi_h;
			$r[121] = $request->serologi_salmonela_parathypi_a_o;
			$r[122] = $request->serologi_salmonela_parathypi_a_h;
			$r[123] = $request->serologi_salmonela_parathypi_b_o;
			$r[124] = $request->serologi_salmonela_parathypi_b_h;
			$r[125] = $request->serologi_salmonela_parathypi_c_o;
			$r[126] = $request->serologi_salmonela_parathypi_c_h;
			$r[127] = $request->serologi_hcg;
			$r[128] = $request->serologi_psa;
			$r[129] = $request->serologi_afp;
			$r[130] = $request->serologi_cea;
			$r[131] = $request->serologi_igm_toxo;
			$r[132] = $request->serologi_igg_toxo;
			$r[133] = $request->serologi_ckmb;
			$r[134] = $request->serologi_myoglobin;
			$r[135] = $request->serologi_troponin_i;

            Serologi::updateOrCreate(
                [
                    'mcu_id'                    => $mcuId
                ],
                [
                    'hbsag'                     => $r[114],
                    'anti_hbs'                  => $r[115],
                    'tuberculosis'              => $r[116],
                    'igm_salmonella'            => $r[117],
                    'igg_salmonella'            => $r[118],
                    'salmonela_typhi_o'         => $r[119],
                    'salmonela_typhi_h'         => $r[120],
                    'salmonela_parathypi_a_o'   => $r[121],
                    'salmonela_parathypi_a_h'   => $r[122],
                    'salmonela_parathypi_b_o'   => $r[123],
                    'salmonela_parathypi_b_h'   => $r[124],
                    'salmonela_parathypi_c_o'   => $r[125],
                    'salmonela_parathypi_c_h'   => $r[126],
                    'hcg'                       => $r[127],
                    'psa'                       => $r[128],
                    'afp'                       => $r[129],
                    'cea'                       => $r[130],
                    'igm_toxo'                  => $r[131],
                    'igg_toxo'                  => $r[132],
                    'ckmb_serologi'             => $r[133],
                    'myoglobin'                 => $r[134],
                    'troponin_i'                => $r[135]
                ]
            );

			// Urin
			$r[137] = $request->urin_warna;
			$r[138] = $request->urin_kejernihan;
			$r[139] = $request->urin_berat_jenis;
			$r[140] = $request->urin_ph;
			$r[141] = $request->urin_protein_urin;
			$r[142] = $request->urin_reduksi;
			$r[143] = $request->urin_keton;
			$r[144] = $request->urin_bilirubin;
			$r[145] = $request->urin_urobilinogen;
			$r[146] = $request->urin_leukosit_esterase;
			$r[147] = $request->urin_darah;
			$r[148] = $request->urin_nitrit;
			$r[149] = $request->urin_sedimen_eritrosit;
			$r[150] = $request->urin_sedimen_leukosit;
			$r[151] = $request->urin_epitel;
			$r[152] = $request->urin_silinder;
			$r[153] = $request->urin_kristal;
			$r[154] = $request->urin_bakteri;
			$r[155] = $request->urin_jamur;
			$r[156] = $request->urin_hcg;

			//array_push($periksa,range(136,155));

            if($request->urin_diperiksa == 'DIPERIKSA') {
                Urin::updateOrCreate(
                    [
                        'mcu_id'            => $mcuId
                    ],
                    [
                        'warna_urin'        => $r[137],
                        'kejernihan'        => $r[138],
                        'berat_jenis'       => $r[139], //$this->setDouble($r[138]),
                        'ph'                => $r[140], //$this->setDouble($r[139]),
                        'protein_urin'      => $r[141],
                        'reduksi'           => $r[142],
                        'keton'             => $r[143],
                        'bilirubin'         => $r[144],
                        'urobilinogen'      => $r[145], //$this->setDouble($r[144]),
                        'leukosit_esterase' => $r[146],
                        'darah_urin'        => $r[147],
                        'nitrit'            => $r[148],
                        'sedimen_eritrosit' => $r[149],
                        'sedimen_leukosit' => $r[150],
                        'epitel'            => $r[151],
                        'silinder'          => $r[152],
                        'kristal'           => $r[153],
                        'bakteri'           => $r[154],
                        'jamur'             => $r[155],
                        'hcg_urin'          => $r[156],
                        ]
                );
				//array_push($cek_periksa,range(136,155));
            }
			else
			{
				for($i=137; $i<=156; $i++)
				{
					unset($r[$i]);
				}
			}

			// Drug Screening
			//$drug_screening->tgl_pemeriksaan = $request->drug_screening_tgl_pemeriksaan;
			//$drug_screening->status_pemeriksaan = $request->drug_screening_status_pemeriksaan;
            //$drug_screening->parameter_drug_screening = $request->drug_screening_parameter;
            //$drug_screening->hasil = $request->drug_screening_hasil;

			 $r[158] = $request->drug_screening_kesimpulan;
			 //array_push($periksa,array(157));

             if($request->drug_screening_diperiksa == 'DIPERIKSA') {
                DrugScreening::updateOrCreate(
                    [
                        'mcu_id'                    => $mcuId
                    ],
                    [
                        'kesimpulan_drug_screening' => $r[158]
                    ]
                 );

				 //array_push($cek_periksa,array(157));
            }
			else
			{
				
					unset($r[158]);
				
			}
			
			// Feses Lengkap

			$r[160] = $request->feses_warna;
			$r[161] = $request->feses_konsistensi;
			$r[162] = $request->feses_darah;
			$r[163] = $request->feses_lendir;
			$r[164] = $request->feses_eritrosit;
			$r[165] = $request->feses_leukosit;
			$r[166] = $request->feses_amoeba;
			$r[167] = $request->feses_e_hystolitica;
			$r[168] = $request->feses_e_coli;
			$r[169] = $request->feses_kista;
			$r[170] = $request->feses_ascaris;
			$r[171] = $request->feses_oxyuris;
			$r[172] = $request->feses_serat;
			$r[173] = $request->feses_lemak;
			$r[174] = $request->feses_karbohidrat;
			$r[175] = $request->feses_benzidine;
			$r[176] = $request->feses_lain_lain;


			

            if( $request->feses_diperiksa == 'DIPERIKSA') {
                Feses::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        'warna_feses'           => $r[160],
                        'konsistensi'           => $r[161],
                        'darah_feses'           => $r[162],
                        'lendir'                => $r[163],
                        'eritrosit_feses'       => $r[164],
                        'leukosit_feses'        => $r[165],
                        'amoeba'                => $r[166],
                        'e_hystolitica'         => $r[167],
                        'e_coli_feses'          => $r[168],
                        'kista'                 => $r[169],
                        'ascaris'               => $r[170],
                        'oxyuris'               => $r[171],
                        'serat'                 => $r[172],
                        'lemak'                 => $r[173],
                        'karbohidrat'           => $r[174],
                        'benzidine'             => $r[175],
                        'lain_lain'             => $r[176]
                    ]
                );
				
            }
			else
			{
				
				for($i=160; $i<=176; $i++)
				{
					unset($r[$i]);
				}
				
			}
			
			
			

			/* if($request->drug_screening_diperiksa == 'DIPERIKSA') {
			           foreach($request->drug_screening_status_pemeriksaan as $i => $status) {
			               $drug_screeningd = DrugScreeningDetail::updateOrCreate([
			                   'mcu_id' => $mcuId,
			                   //'parameter' => $request->drug_screening_parameter[$i]
			               ],[
			                    'hasil_drug_screening' => $request->drug_screening_hasil[$i],
			                    'parameter_drug_screening' => $request->drug_screening_parameter[$i],
			                    'tgl_pemeriksaan' => $request->drug_screening_tgl_pemeriksaan[$i],
			                    'status_pemeriksaan' => $status
			                ]);
			                $drug_screeningd->save();
			            }
			} */

			// Rectal Swab
			$r[178] = $request->rectalswab_typoid;
			$r[179] = $request->rectalswab_diare;
			$r[180] = $request->rectalswab_disentri;
			$r[181] = $request->rectalswab_kolera;
			$r[182] = $request->rectalswab_salmonella;
			$r[183] = $request->rectalswab_shigella;
			$r[184] = $request->rectalswab_e_coli;
			$r[185] = $request->rectalswab_vibrio_cholera;
			$r[186] = $request->rectalswab_kesimpulan;

			//array_push($periksa,range(177,185));

            if($request->rectal_swab_diperiksa  == 'DIPERIKSA') {
                RectalSwab::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        'typoid'                => $r[178],
                        'diare'                 => $r[179],
                        'disentri'              => $r[180],
                        'kolera'                => $r[181],
                        'salmonella'            => $r[182],
                        'shigella'              => $r[183],
                        'e_coli'                => $r[184],
                        'vibrio_cholera'        => $r[185],
                        'kesimpulan_rectal_swab'=> $r[186]
                    ]
                );
				//array_push($cek_periksa,range(177,185));
            }
			else
			{
				
				for($i=178; $i<=186; $i++)
				{
					unset($r[$i]);
				}
				
			}

			

			// Rontgen;
			$r[189] = $request->kesan_rontgen;
			//array_push($periksa,array(188));
            if($request->rontgen_diperiksa == 'DIPERIKSA') {
                Rontgen::updateOrCreate(
                    [
                        'mcu_id'        => $mcuId
                    ],
                    [
                        'kesan_rontgen' => $r[189]
                    ]
                );
				//array_push($cek_periksa,array(188));


				// if($request->rontgen_jenis_foto)
				// {
					// foreach($request->rontgen_jenis_foto as $i => $jenis_foto) {
						// $rontgen = RontgenDetail::updateOrCreate(
							// [
								// 'mcu_id' => $mcuId,
								// 'parameter' => $request->rontgen_parameter[$i]
							// ],
							// [
								// 'jenis_foto' => $jenis_foto,
								// 'temuan' => $request->rontgen_temuan[$i]
							// ]
						// );
						// $rontgen->save();
					// }
				// }


            }
			else
			{
				unset($r[189]);
				
			}
			

			// Ekg
			$r[191] = $request->ekg_hasil;
			$r[192] = $request->ekg_kesimpulan;
			//array_push($periksa,range(190,191));
            if( $request->ekg_diperiksa == 'DIPERIKSA') {

                Ekg::updateOrCreate(
                    [
                        'mcu_id'        => $mcuId
                    ],
                    [
                        'hasil_ekg'     => $r[191],
                        'kesimpulan_ekg'=> $r[192]
                    ]
                );
				//array_push($cek_periksa,range(190,191));
            }
			else
			{
				unset($r[191]);
				unset($r[192]);
				
			}


			//Trreadmill
			$r[194] = $request->treadmill_resting_ekg;
			$r[195] = $request->treadmill_bruce_heart_beat;
			$r[196] = $request->treadmill_capaian_heart_beat;
			$r[197] = $request->treadmill_capaian_menit;
			$r[198] = $request->treadmill_respon_heart_beat;
			$r[199] = $request->treadmill_respon_sistol;
			$r[200] = $request->treadmill_respon_diastol;
			$r[201] = $request->treadmill_aritmia;
			$r[202] = $request->treadmill_nyeri_dada;
			$r[203] = $request->treadmill_gejala_lain;
			$r[204] = $request->treadmill_perubahan_segmen_st;
			$r[205] = $request->treadmill_lead;
			$r[206] = $request->treadmill_lead_pada_menit_ke;
			$r[207] = $request->treadmill_normalisasi_setelah;
			$r[208] = $request->treadmill_functional_class;
			$r[209] = $request->treadmill_kapasitas_aerobik;
			$r[210] = $request->treadmill_tingkat_kesegaran;
			$r[211] = $request->treadmill_grafik;
			$r[212] = $request->treadmill_kesimpulan;

			//array_push($periksa,range(193,211));
            if( $request->treadmill_diperiksa == 'DIPERIKSA') {
                Treadmill::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        'resting_ekg'           => $r[194],
                        'bruce_heart_beat'      => $r[195],
                        'capaian_heart_beat'    => $r[196],
                        'capaian_menit'         => $r[197],
                        'respon_heart_beat'     => $r[198],
                        'respon_sistol'         => $r[199],
                        'respon_diastol'        => $r[200],
                        'aritmia'               => $r[201],
                        'nyeri_dada'            => $r[202],
                        'gejala_lain'           => $r[203],
                        'perubahan_segmen_st'   => $r[204],
                        'lead'                  => $r[205],
                        'lead_pada_menit_ke'    => $r[206],
                        'normalisasi_setelah'   => $r[207],
                        'functional_class'      => $r[208],
                        'kapasitas_aerobik'     => $r[209],
                        'tingkat_kesegaran'     => $r[210],
                        'grafik'                => $r[211],
                        'kesimpulan_treadmill'  => $r[212]
                    ]
                );

				//array_push($cek_periksa,range(193,211));
            }
			else
			{
				
				for($i=194; $i<=212; $i++)
				{
					unset($r[$i]);
				}
				
			}

			 //Audiometri
			 $r[214] = $request->audiometri_hasil;
			 $r[215] = $request->audiometri_kesimpulan;
			 //$r[216] =  $request->oae_kesimpulan;
			
			 
			//array_push($periksa,range(214,216));
            if( $request->audiometri_diperiksa == 'DIPERIKSA') {
				Audiometri::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        
                        'hasil_audiometri'       	   => $r[214],
						'kesimpulan_audiometri'        => $r[215]
                    ]
                );
		    }
			else
			{
				for($i=214; $i<=215; $i++)
				{
					unset($r[$i]);
				}
				
			}
		

			// if($request->audiometri_diperiksa == 'DIPERIKSA') {
				// foreach($request->audiometri_frekuensi as $i => $frekuensi) {
					// $audiometri = AudiometriDetail::updateOrCreate(
						// [
							// 'id' => $request->audiometri_id_detail[$i],

						// ],
						// [
							// 'frekuensi' => $frekuensi,
							// 'kiri' => $request->audiometri_kiri[$i],
							// 'kanan' => $request->audiometri_kiri[$i]
						// ]
					// );

					// $audiometri = Audiometri::where('mcu_id', $request->mcu_id)->first();
					// if($audiometri) {

						// $audiometri->frekuensi = $request->audiometri_frekuensi;
						// $audiometri->kiri = $request->audiometri_kiri;
						// $audiometri->kanan = $request->audiometri_kanan;

					// }

				// }
			// }


            //Spirometri
			$r[219] = $request->spirometri_fev;
			$r[220] = $request->spirometri_fvc;
			$r[221] = $request->spirometri_pef;
			$r[222] = $request->spirometri_kesimpulan;

			//array_push($periksa,range(218,221));
            if( $request->spirometri_diperiksa  == 'DIPERIKSA') {
                Spirometri::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        'fev'                   => $r[219],
                        'fvc'                   => $r[220],
                        'pef'                   => $r[221],
                        'kesimpulan_spirometri' => $r[222]

                    ]
                );
				//array_push($cek_periksa,range(218,221));

				if ($request->hasFile('file')) {


					$d = Spirometri::where('mcu_id',$mcuId)->first();

					if($d)
					{
						$img = $d->chart;
						if($img != "")
						{

							$image_path = "chart_spirometri/".$img;

							if (file_exists($image_path)) {

								@unlink($image_path);

							}

						}
					}


					$file = $request->file('file');

					$dt = new DateTime();
					$dt =  $dt->format('YmdHis');
					//$dt = Carbon::now()->toDateTimeString();
					$name = $mcuId."_".$dt;
					$name = $name.".".$file->getClientOriginalExtension();
					$file->move('chart_spirometri',$name);
					//$spirometri->chart = $name;
					Spirometri::updateOrCreate(
						[
							'mcu_id'                => $mcuId
						],
						[
							'chart' => $name

						]
					);

				}


            }
			else
			{
				
				for($i=219; $i<=222; $i++)
				{
					unset($r[$i]);
				}
				
			}

            // Pap Smear
			$r[223] =  $request->pap_smear_tgl_terima;
			$r[224] =  $request->pap_smear_tgl_selesai;
			$r[225] =  $request->pap_smear_bahan_pemeriksaan;
			$r[226] =  $request->pap_smear_makroskopik;
			$r[227] =  $request->pap_smear_mikroskopik;
			$r[228] =  $request->pap_smear_kesimpulan;
            PapSmear::updateOrCreate(
                [
                    'mcu_id'                    => $mcuId
                ],
                [
                    'tgl_terima'                => $this->setAsDate($r[223]), 
                    'tgl_selesai'               => $this->setAsDate($r[224]),
                    'bahan_pemeriksaan'         => $r[225],
                    'makroskopik'               => $r[226],
                    'mikroskopik'               => $r[227],
                    'kesimpulan_pap_smear'      => $r[228]
                ]
            );

			//ImportMcu::rumus($r,$periksa,$cek_periksa,$mcuId);
			
			// When mcu Id has diagnosis, delete first
            Mcu::find($mcuId)->diagnosis()->delete();
			

            // Set diagnosis for all field
			ImportMcu::rumus($r,$mcuId,0);


	}
    public function update(Request $request)
    {
		$id_mcu = $request->mcu_id;

		DB::table('diagnoses')->where('mcu_id', $request->mcu_id)->delete();

		$this->konvert_post_toData_array($id_mcu, $request);

        return back()->with('success', 'Data has been update successfully');
	}
	public function update_(Request $request)
    {
        $id = $request->mcu_id;
		$mcu = Mcu::where('id', $id)->first();
        // $mcu->id = $mcu_id;
        $mcu->no_nip = $request->mcu_no_nip;
        $mcu->no_paper = $request->mcu_no_paper;
        // $mcu->tgl_input = today();
        $mcu->nama_pasien = $request->mcu_nama_pasien;
        $mcu->tgl_lahir = $request->mcu_tgl_lahir;
        $mcu->jenis_kelamin = $request->mcu_jenis_kelamin;
        $mcu->bagian = $request->mcu_bagian;
        $mcu->paket_mcu = $request->mcu_paket_mcu;
        $mcu->tgl_kerja = $request->mcu_tgl_kerja;
        $mcu->email = $request->mcu_email;
        $mcu->telepon = $request->mcu_telepon;
        $mcu->client = $request->mcu_client;
        $mcu->vendor_customer_id = $request->mcu_customer_id;

        $umum = Umum::where('mcu_id', $request->mcu_id)->first();
        $umum->nadi = $request->umum_nadi;
        $umum->sistolik = $request->umum_sistolik;
        $umum->diastolik = $request->umum_diastolik;
        $umum->respirasi = $request->umum_respirasi;
        $umum->suhu = $request->umum_suhu;
        // $umum->mcu_id = $mcu_id;

        $riwayat = Riwayat::where('mcu_id', $request->mcu_id)->first();
		if($riwayat) {
        $riwayat->keluhan_utama = $request->riwayat_keluhan_utama;
        $riwayat->riwayat_alergi = $request->riwayat_riwayat_alergi;
        $riwayat->riwayat_penyakit_sekarang = $request->riwayat_riwayat_penyakit_sekarang;
        $riwayat->riwayat_kesehatan_dahulu = $request->riwayat_riwayat_kesehatan_dahulu;
        $riwayat->riwayat_kesehatan_keluarga = $request->riwayat_riwayat_kesehatan_keluarga;
        $riwayat->riwayat_kesehatan_pribadi = $request->riwayat_riwayat_kesehatan_pribadi;
        $riwayat->olahraga = $request->riwayat_olahraga;


        /**** di bawah ini sementara dikasih kondisi,
        **** soalnya kayaknya field ini boleh kosong,
        *** tapi di database, dia harus diisi
        */

        $riwayat->frekuensi_per_minggu = $request->riwayat_frekuensi_per_minggu != ""
                ? $request->riwayat_frekuensi_per_minggu
                : 0;
        $riwayat->merokok = $request->riwayat_merokok;
        $riwayat->rokok_bungkus_per_hari = $request->riwayat_rokok_bungkus_per_hari != ""
                ? $request->riwayat_rokok_bungkus_per_hari
                : 0;
        $riwayat->kopi = $request->riwayat_kopi;
        $riwayat->kopi_gelas_per_hari = $request->riwayat_kopi_gelas_per_hari != ""
                ? $request->riwayat_kopi_gelas_per_hari
                : 0;
        $riwayat->alkohol = $request->riwayat_alkohol;
        $riwayat->alkohol_sebanyak = $request->riwayat_alkohol_sebanyak != ""
                ? $request->riwayat_alkohol_sebanyak
                : 0;
        $riwayat->lama_tidur_per_hari = $request->riwayat_lama_tidur_per_hari;
        $riwayat->pernah_kecelakaan_kerja = $request->riwayat_pernah_kecelakaan_kerja;
        $riwayat->tahun_kecelakaan_kerja = $request->riwayat_tahun_kecelakaan_kerja != ""
                ? $request->riwayat_tahun_kecelakaan_kerja
                : 0;
        $riwayat->tempat_kerja_berbahaya = $request->riwayat_tempat_kerja_berbahaya;
        $riwayat->pernah_rawat_inap = $request->riwayat_pernah_rawat_inap;
        $riwayat->hari_lama_rawat_inap = $request->riwayat_hari_lama_rawat_inap != ""
                ? $request->riwayat_hari_lama_rawat_inap
                : 0;
        $riwayat->rawat_inap_penyakit = $request->riwayat_rawat_inap_penyakit != ""
                ? $request->riwayat_rawat_inap_penyakit
                : 0;
        // $riwayat->mcu_id = $mcu_id;
        }
        $antrovisus = Antrovisus::where('mcu_id', $request->mcu_id)->first();
		if($antrovisus) {
        $antrovisus->berat_badan = $request->antrovisus_berat_badan;
        $antrovisus->tinggi_badan = $request->antrovisus_tinggi_badan;
        $antrovisus->bmi = $request->antrovisus_bmi;
        $antrovisus->visus_kanan = $request->antrovisus_visus_kanan;
        $antrovisus->visus_kiri = $request->antrovisus_visus_kiri;
        $antrovisus->rekomendasi_kacamatan = $request->antrovisus_rekomendasi_kacamatan;
        $antrovisus->spheris_kanan = $request->antrovisus_spheris_kanan;
        $antrovisus->cylinder_kanan = $request->antrovisus_cylinder_kanan;
        $antrovisus->axis_kanan = $request->antrovisus_axis_kanan;
        $antrovisus->addition_kanan = $request->antrovisus_addition_kanan;
        $antrovisus->spheris_kiri = $request->antrovisus_spheris_kiri;
        $antrovisus->cylinder_kiri = $request->antrovisus_cylinder_kiri;
        $antrovisus->axis_kiri = $request->antrovisus_axis_kiri;
        $antrovisus->addition_kiri = $request->antrovisus_addition_kiri;
        $antrovisus->pupil_distance = $request->antrovisus_pupil_distance;
        // $antrovisus->mcu_id = $mcu_id;
		}
        $fisik = Fisik::where('mcu_id', $request->mcu_id)->first();
		if($fisik) {
        $fisik->kepala = $request->fisik_kepala;
        $fisik->mata = $request->fisik_mata;
        $fisik->telinga = $request->fisik_telinga;
        $fisik->hidung = $request->fisik_hidung;
        $fisik->tenggorokan = $request->fisik_tenggorokan;
        $fisik->leher = $request->fisik_leher;
        $fisik->mulut = $request->fisik_mulut;
        $fisik->gigi = $request->fisik_gigi;
        $fisik->dada = $request->fisik_dada;
        $fisik->abdomen = $request->fisik_abdomen;
        $fisik->extremitas = $request->fisik_extremitas;
        $fisik->anogenital = $request->fisik_anogenital;
        $fisik->anogenital = $request->fisik_anogenital;
        // $fisik->mcu_id = $mcu_id;
		}
        $hematologi = Hematologi::where('mcu_id', $request->mcu_id)->first();
		 if($hematologi) {
        $hematologi->hemoglobin = $request->hematologi_hemoglobin;
        $hematologi->hematokrit = $request->hematologi_hematokrit;
        $hematologi->eritrosit = $request->hematologi_eritrosit;
        $hematologi->leukosit = $request->hematologi_leukosit;
        $hematologi->trombosit = $request->hematologi_trombosit;
        $hematologi->basofil = $request->hematologi_basofil;
        $hematologi->eosinofil = $request->hematologi_eosinofil;
        $hematologi->neutrofil_batang = $request->hematologi_neutrofil_batang;
        $hematologi->neutrofil_segment = $request->hematologi_neutrofil_segment;
        $hematologi->limfosit = $request->hematologi_limfosit;
        $hematologi->monosit = $request->hematologi_monosit;
        $hematologi->laju_endap_darah = $request->hematologi_laju_endap_darah;
        $hematologi->mcv = $request->hematologi_mcv;
        $hematologi->mch = $request->hematologi_mch;
        $hematologi->mchc = $request->hematologi_mchc;
        $hematologi->golongan_darah_abo = $request->hematologi_golongan_darah_abo;
        $hematologi->golongan_darah_rh = $request->hematologi_golongan_darah_rh;
        $hematologi->golongan_darah_rh = $request->hematologi_golongan_darah_rh;
        // $hematologi->mcu_id = $mcu_id;
		 }
        $kimia = Kimia::where('mcu_id', $request->mcu_id)->first();
        if($kimia) {
		$kimia->gds = $request->kimia_gds;
        $kimia->gdp = $request->kimia_gdp;
        $kimia->dua_jam_pp = $request->kimia_2_jam_pp; //need help for field name
        $kimia->hba1c = $request->kimia_hba1c;
        $kimia->ureum = $request->kimia_ureum;
        $kimia->kreatinin = $request->kimia_kreatinin;
        $kimia->asam_urat = $request->kimia_asam_urat;
        $kimia->bilirubin_total = $request->kimia_bilirubin_total;
        $kimia->bilirubin_direk = $request->kimia_bilirubin_direk;
        $kimia->bilirubin_indirek = $request->kimia_bilirubin_indirek;
        $kimia->sgot = $request->kimia_sgot;
        $kimia->sgpt = $request->kimia_sgpt;
        $kimia->protein = $request->kimia_protein;
        $kimia->albumin = $request->kimia_albumin;
        $kimia->alkaline_fosfatase = $request->kimia_alkaline_fosfatase;
        $kimia->choline_esterase = $request->kimia_choline_esterase;
        $kimia->gamma_gt = $request->kimia_gamma_gt;
        $kimia->trigliserida = $request->kimia_trigliserida;
        $kimia->kolesterol_total = $request->kimia_kolesterol_total;
        $kimia->hdl = $request->kimia_hdl;
        $kimia->ldl_direk = $request->kimia_ldl_direk;
        $kimia->ldl_indirek = $request->kimia_ldl_indirek;
        $kimia->ck = $request->kimia_ck;
        $kimia->ckmb = $request->kimia_ckmb;
        $kimia->spuktum_bta1 = $request->kimia_spuktum_bta1;
        $kimia->spuktum_bta2 = $request->kimia_spuktum_bta2;
        $kimia->spuktum_bta3 = $request->kimia_spuktum_bta3;
        // $kimia->mcu_id = $mcu_id;
	    }
        $oae = Oae::where('mcu_id', $request->mcu_id)->first();
		if($oae) {
			$oae->hasil_oae_ka = $request->oae_hasil_oae_ka;
			$oae->hasil_oae_ki = $request->oae_hasil_oae_ki;
			$oae->kesimpulan = $request->oae_kesimpulan;
			// $oae->mcu_id = $mcu_id;
		}

        $rontgen = Rontgen::where('mcu_id', $request->mcu_id)->first();
		if($rontgen) {
			$rontgen->kesan_rontgen = $request->kesan_rontgen;
			//$rontgen->jenis_foto = $request->rontgen_jenis_foto;
			//$rontgen->parameter = $request->rontgen_parameter;
			//$rontgen->temuan = $request->rontgen_temuan;
        }

		foreach($request->rontgen_jenis_foto as $i => $jenis_foto) {
                $rontgende = RontgenDetail::updateOrCreate(
                    [
                        'mcu_id' => $request->mcu_id,
                        'parameter' => $request->rontgen_parameter[$i]
                    ],
                    [
                        'jenis_foto' => $jenis_foto,
                        'temuan' => $request->rontgen_temuan[$i]
                    ]
                );
                $rontgende->save();
        }


        $serologi = Serologi::where('mcu_id', $request->mcu_id)->first();
		if($serologi) {
        $serologi->hbsag = $request->serologi_hbsag;
        $serologi->anti_hbs = $request->serologi_anti_hbs;
        $serologi->tuberculosis = $request->serologi_tuberculosis;
        $serologi->igm_salmonella = $request->serologi_igm_salmonella;
        $serologi->igg_salmonella = $request->serologi_igg_salmonella;
        $serologi->salmonela_typhi_o = $request->serologi_salmonela_typhi_o;
        $serologi->salmonela_typhi_h = $request->serologi_salmonela_typhi_h;
        $serologi->salmonela_parathypi_a_o = $request->serologi_salmonela_parathypi_a_o;
        $serologi->salmonela_parathypi_a_h = $request->serologi_salmonela_parathypi_a_h;
        $serologi->salmonela_parathypi_b_o = $request->serologi_salmonela_parathypi_b_o;
        $serologi->salmonela_parathypi_b_h = $request->serologi_salmonela_parathypi_b_h;
        $serologi->salmonela_parathypi_c_o = $request->serologi_salmonela_parathypi_c_o;
        $serologi->salmonela_parathypi_c_h = $request->serologi_salmonela_parathypi_c_h;
        $serologi->hcg = $request->serologi_hcg;
        $serologi->psa = $request->serologi_psa;
        $serologi->afp = $request->serologi_afp;
        $serologi->cea = $request->serologi_cea;
        $serologi->igm_toxo = $request->serologi_igm_toxo;
        $serologi->igg_toxo = $request->serologi_igg_toxo;
        $serologi->ckmb_serologi = $request->serologi_ckmb;
        $serologi->myoglobin = $request->serologi_myoglobin;
        $serologi->troponin_i = $request->serologi_troponin_i;
		}
        // $serologi->mcu_id = $mcu_id;

        $spirometri = Spirometri::where('mcu_id', $request->mcu_id)->first();
		if($spirometri) {
			$spirometri->fev = $request->spirometri_fev;
			$spirometri->fvc = $request->spirometri_fvc;
			$spirometri->pef = $request->spirometri_pef;
			$spirometri->kesimpulan_spirometri = $request->spirometri_kesimpulan;

			if ($request->hasFile('file')) {

				$file = $request->file('file');

				$dt = new DateTime();
				$dt =  $dt->format('YmdHis');
				//$dt = Carbon::now()->toDateTimeString();
				$name = $request->mcu_id."_".$dt;
				$name = $name.".".$file->getClientOriginalExtension();
				$file->move('chart_spirometri',$name);
				$spirometri->chart = $name;

			}

		}
        // $spirometri->mcu_id = $mcu_id;

        $treadmill = Treadmill::where('mcu_id', $request->mcu_id)->first();
		if($treadmill) {
			$treadmill->resting_ekg = $request->treadmill_resting_ekg;
			$treadmill->bruce_heart_beat = $request->treadmill_bruce_heart_beat;
			$treadmill->capaian_heart_beat = $request->treadmill_capaian_heart_beat;
			$treadmill->capaian_menit = $request->treadmill_capaian_menit;
			$treadmill->respon_heart_beat = $request->treadmill_respon_heart_beat;
			$treadmill->respon_sistol = $request->treadmill_respon_sistol;
			$treadmill->respon_diastol = $request->treadmill_respon_diastol;
			$treadmill->aritmia = $request->treadmill_aritmia;
			$treadmill->nyeri_dada = $request->treadmill_nyeri_dada;
			$treadmill->gejala_lain = $request->treadmill_gejala_lain;
			$treadmill->perubahan_segmen_st = $request->treadmill_perubahan_segmen_st;
			$treadmill->lead = $request->treadmill_lead;
			$treadmill->lead_pada_menit_ke = $request->treadmill_lead_pada_menit_ke;
			$treadmill->normalisasi_setelah = $request->treadmill_normalisasi_setelah;
			$treadmill->functional_class = $request->treadmill_functional_class;
			$treadmill->kapasitas_aerobik = $request->treadmill_kapasitas_aerobik;
			$treadmill->tingkat_kesegaran = $request->treadmill_tingkat_kesegaran;
			$treadmill->grafik = $request->treadmill_grafik;
			$treadmill->kesimpulan = $request->treadmill_kesimpulan;
			// $treadmill->mcu_id = $mcu_id;
        }
        $audiometri = Audiometri::where('mcu_id', $request->mcu_id)->first();
		if($audiometri) {
        $audiometri->frekuensi = $request->audiometri_frekuensi;
        $audiometri->kiri = $request->audiometri_kiri;
        $audiometri->kanan = $request->audiometri_kanan;
        // $audiometri->mcu_id = $mcu_id;
        }
        $feses = Feses::where('mcu_id', $request->mcu_id)->first();
		if($feses) {
			$feses->warna_feses = $request->feses_warna;
			$feses->konsistensi = $request->feses_konsistensi;
			$feses->darah_feses = $request->feses_darah;
			$feses->lendir = $request->feses_lendir;
			$feses->eritrosit_feses = $request->feses_eritrosit;
			$feses->leukosit_feses = $request->feses_leukosit;
			$feses->amoeba = $request->feses_amoeba;
			$feses->e_hystolitica = $request->feses_e_hystolitica;
			$feses->e_coli_feses = $request->feses_e_coli;
			$feses->kista = $request->feses_kista;
			$feses->ascaris = $request->feses_ascaris;
			$feses->oxyuris = $request->feses_oxyuris;
			$feses->serat = $request->feses_serat;
			$feses->lemak = $request->feses_lemak;
			$feses->karbohidrat = $request->feses_karbohidrat;
			$feses->benzidine = $request->feses_benzidine;
			$feses->lain_lain = $request->feses_lain_lain;
		}
        // $feses->mcu_id = $mcu_id;

        $urin = Urin::where('mcu_id', $request->mcu_id)->first();
		if($urin) {
			$urin->warna_urin = $request->urin_warna;
			$urin->kejernihan = $request->urin_kejernihan;
			// $urin->berat_jenis = $request->urin_berat_jenis; //Belum masuk ke migrate
			$urin->ph = $request->urin_ph;
			$urin->protein_urin = $request->urin_protein_urin;
			$urin->reduksi = $request->urin_reduksi;
			$urin->keton = $request->urin_keton;
			$urin->bilirubin = $request->urin_bilirubin;
			$urin->urobilinogen = $request->urin_urobilinogen;
			$urin->leukosit_esterase = $request->urin_leukosit_esterase;
			$urin->darah_urin = $request->urin_darah;
			$urin->nitrit = $request->urin_nitrit;
			$urin->sedimen_eritrosit = $request->urin_sedimen_eritrosit;
			// $urin->sedimen_leukosit = $request->urin_sedimen_leukosit; //Belum masuk ke migrate
			$urin->epitel = $request->urin_epitel;
			$urin->silinder = $request->urin_silinder;
			$urin->kristal = $request->urin_kristal;
			$urin->bakteri = $request->urin_bakteri;
			$urin->jamur = $request->urin_jamur;
			$urin->hcg_urin = $request->urin_hcg;
			// $urin->mcu_id = $mcu_id;
        }

        $pap_smear = PapSmear::where('mcu_id', $request->mcu_id)->first();
		if($pap_smear) {
			$pap_smear->tgl_terima = $request->pap_smear_tgl_terima;
			$pap_smear->tgl_selesai = $request->pap_smear_tgl_selesai;
			$pap_smear->bahan_pemeriksaan = $request->pap_smear_bahan_pemeriksaan;
			$pap_smear->makroskopik = $request->pap_smear_makroskopik;
			$pap_smear->mikroskopik = $request->pap_smear_mikroskopik;
			$pap_smear->kesimpulan_pap_smear = $request->pap_smear_kesimpulan;
			// $pap_smear->mcu_id = $mcu_id;
		}
        $rectalswab = Rectalswab::where('mcu_id', $request->mcu_id)->first();
		if($rectalswab) {
			$rectalswab->typoid = $request->rectalswab_typoid;
			$rectalswab->diare = $request->rectalswab_diare;
			$rectalswab->disentri = $request->rectalswab_disentri;
			$rectalswab->kolera = $request->rectalswab_kolera;
			$rectalswab->salmonella = $request->rectalswab_salmonella;
			$rectalswab->shigella = $request->rectalswab_shigella;
			$rectalswab->e_coli = $request->rectalswab_e_coli;
			$rectalswab->vibrio_cholera = $request->rectalswab_vibrio_cholera;
			$rectalswab->kesimpulan = $request->rectalswab_kesimpulan;
			// $rectalswab->mcu_id = $mcu_id;
		}
        $drug_screening = DrugScreening::where('mcu_id', $request->mcu_id)->first();
		if($drug_screening) {
        $drug_screening->tgl_pemeriksaan = $request->drug_screening_tgl_pemeriksaan;
        $drug_screening->status_pemeriksaan = $request->drug_screening_status_pemeriksaan;
        $drug_screening->parameter_drug_screening = $request->drug_screening_parameter;
        $drug_screening->hasil = $request->drug_screening_hasil;
        // $drug_screening->mcu_id = $mcu_id;
        }


		//delete diagnosis
		/* DB::table('diagnoses')->where('mcu_id', $request->mcu_id)->delete();
		$d = Mcu::find($request->mcu_id);

		try {

			$d->delete();
			$d->antrovisus()->delete();
			$d->audiometri()->delete();
			$d->drugScreening()->delete();
			$d->ekg()->delete();
			$d->feses()->delete();
			$d->fisik()->delete();
			$d->hematologi()->delete();
			$d->kimia()->delete();
			$d->oae()->delete();
			$d->papSmear()->delete();
			$d->rectalSwab()->delete();
			$d->riwayat()->delete();
			$d->rontgen()->delete();
			$d->serologi()->delete();
			$d->spirometri()->delete();
			$d->treadmill()->delete();
			$d->umum()->delete();
			$d->urin()->delete();

		} catch (Exception $ex) {

			//return response()->json(['responseCode' => 500, 'responseMessage' => $ex->getMessage()]);
			return back()->with('Failed',  $ex->getMessage());

		}

		return back()->with('success', 'Data has been update successfully'); */




        /* $mcu->save();
        if($umum) {
			$umum->save();
		}
		if($riwayat) {
			$riwayat->save();
		}
		if($antrovisus) {
			  $antrovisus->save();
		}
		if($fisik) {
			  $fisik->save();
		}
        if($hematologi) {
			  $hematologi->save();
		}
        if($kimia) {
			 $kimia->save();
		}
        if($oae) {
			 $oae->save();
		}
        if($rontgen) {
			 $rontgen->save();
		}
        if($serologi) {
			 $serologi->save();
		}
        if($spirometri) {
			 $spirometri->save();
		}
        if($treadmill) {
			  $treadmill->save();
		}
        if($audiometri) {
			  $audiometri->save();
		}
		 if($feses) {
			  $feses->save();
		}
		if($urin) {
			  $urin->save();
		}
        if($pap_smear) {
			  $pap_smear->save();
		}
        if($rectalswab) {
			  $rectalswab->save();
		}
        if($drug_screening) {
			  $drug_screening->save();
		}

		DB::table('diagnoses')->where('mcu_id', $request->mcu_id)->delete();
		//update diagnosis panggil fungsi

        return back()->with('success', 'Data has been update successfully'); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mcu  $mcu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mcu $mcu, $id)
    {
        $d = $mcu::find($id);

        try {
            $d->delete();
            $d->antrovisus()->delete();
            $d->audiometri()->delete();
            $d->drugScreening()->delete();
            $d->ekg()->delete();
            $d->feses()->delete();
            $d->fisik()->delete();
            $d->hematologi()->delete();
            $d->kimia()->delete();
            $d->oae()->delete();
            $d->papSmear()->delete();
            $d->rectalSwab()->delete();
            $d->riwayat()->delete();
            $d->rontgen()->delete();
            $d->serologi()->delete();
            $d->spirometri()->delete();
            $d->treadmill()->delete();
            $d->umum()->delete();
            $d->urin()->delete();

        } catch (\Exception $ex) {
            return response()->json(['responseCode' => 500, 'responseMessage' => $ex->getMessage()]);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'MCU has been deleted successfully']);
    }

    /**
     * Bulk Delete
     *
     * @param Rontgen $rontgen
     * @param Request $request
     * @return type
     */
	function bulkDeletex(Mcu $mcu, Request $request)
    {
		
		$r = $mcu::where('id', '!=' , null);
        $antrovisus = Antrovisus::where('mcu_id', '!=', null);
        $audiometri = Audiometri::where('mcu_id', '!=', null);
        $drugScreening = DrugScreening::where('mcu_id', '!=', null);
        $ekg = Ekg::where('mcu_id', '!=', null);
        $feses = Feses::where('mcu_id', '!=', null);
        $fisik = Fisik::where('mcu_id', '!=', null);
        $hematologi = Hematologi::where('mcu_id', '!=', null);
        $kimia = Kimia::where('mcu_id', '!=', null);
        $oae=Oae::where('mcu_id', '!=', null);
        $papSmear= PapSmear::where('mcu_id', '!=', null);
        $rectalSwab= RectalSwab::where('mcu_id', '!=', null);
        $riwayat= Riwayat::where('mcu_id', '!=', null);
        $rontgen= Rontgen::where('mcu_id', '!=', null);
        $serologi= Serologi::where('mcu_id', '!=', null);
        $spirometri= Spirometri::where('mcu_id', '!=', null);
        $treadmill= Treadmill::where('mcu_id', '!=', null);
        $umum= Umum::where('mcu_id', '!=', null);
        $urin= Urin::where('mcu_id', '!=', null);
		
		// Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $antrovisus->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $audiometri->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $drugScreening->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $ekg->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $feses->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $fisik->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $hematologi->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $kimia->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $oae->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $papSmear->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $rectalSwab->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $riwayat->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $rontgen->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $serologi->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $spirometri->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $treadmill->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $umum->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $urin->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

	

	}		
	 
    function bulkDelete(Mcu $mcu, Request $request)
    {
        //20210 80200 28000 02600	
		//echo $request->idPasien; echo "</br>"; //alay
		//echo $request->idPerusahaan;echo "</br>";
		//echo $request->startDate;echo "</br>";
		//echo $request->endDate;echo "</br>";
		//return false;
		$r = $mcu::where('id', '!=' , null);
        $antrovisus = Antrovisus::where('mcu_id', '!=', null);
        $audiometri = Audiometri::where('mcu_id', '!=', null);
        $drugScreening = DrugScreening::where('mcu_id', '!=', null);
        $ekg = Ekg::where('mcu_id', '!=', null);
        $feses = Feses::where('mcu_id', '!=', null);
        $fisik = Fisik::where('mcu_id', '!=', null);
        $hematologi = Hematologi::where('mcu_id', '!=', null);
        $kimia = Kimia::where('mcu_id', '!=', null);
        $oae=Oae::where('mcu_id', '!=', null);
        $papSmear= PapSmear::where('mcu_id', '!=', null);
        $rectalSwab= RectalSwab::where('mcu_id', '!=', null);
        $riwayat= Riwayat::where('mcu_id', '!=', null);
        $rontgen= Rontgen::where('mcu_id', '!=', null);
        $serologi= Serologi::where('mcu_id', '!=', null);
        $spirometri= Spirometri::where('mcu_id', '!=', null);
        $treadmill= Treadmill::where('mcu_id', '!=', null);
        $umum= Umum::where('mcu_id', '!=', null);
        $urin= Urin::where('mcu_id', '!=', null);

        // Filter Id pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $r->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $antrovisus->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $audiometri->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $drugScreening->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $ekg->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $feses->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $fisik->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $hematologi->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $kimia->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $oae->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $papSmear->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $rectalSwab->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $riwayat->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $rontgen->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $serologi->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $spirometri->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $treadmill->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $umum->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $urin->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }
        // Filter Id Perusahaan
		//if($request->idPerusahaan != '') {
			 //$r->whereRaw('client'.$idPerusahaan);
			 //$antrovisus->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
    	//}
		if($request->idPerusahaan != '') {
            
			//DB:select('vendor_customer')->where('');
			
			$idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
		
            $r->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
			$antrovisus->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $audiometri->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $drugScreening->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $ekg->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $feses->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $fisik->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $hematologi->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $kimia->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $oae->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $papSmear->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $rectalSwab->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $riwayat->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $rontgen->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $serologi->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $spirometri->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $treadmill->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $umum->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
            $urin->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $r->whereRaw('substring(id, 1, 8) >= '.$startDate);
			$antrovisus->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $audiometri->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $drugScreening->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $ekg->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $feses->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $fisik->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $hematologi->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $kimia->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $oae->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $papSmear->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $rectalSwab->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $riwayat->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $rontgen->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $serologi->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $spirometri->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $treadmill->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $umum->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
            $urin->whereRaw('substring(mcu_id, 1, 8) = '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $r->whereRaw('substring(id, 1, 8) <= '.$endDate);
            $audiometri->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $drugScreening->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $ekg->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $feses->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $fisik->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $hematologi->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $kimia->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $oae->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $papSmear->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $rectalSwab->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $riwayat->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $rontgen->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $serologi->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $spirometri->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $treadmill->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $umum->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
            $urin->whereRaw('substring(mcu_id, 1, 8) = '.$endDate);
        }

        if($request->idPasien != '' || $request->idPerusahaan != '' || $request->startDate != '' || $request->endDate != '') {

            try {
                $r->delete();
                $antrovisus->delete();
                $audiometri->delete();
                $drugScreening->delete();
                $ekg->delete();
                $feses->delete();
                $fisik->delete();
                $hematologi->delete();
                $kimia->delete();
                $oae->delete();
                $papSmear->delete();
                $rectalSwab->delete();
                $riwayat->delete();
                $rontgen->delete();
                $serologi->delete();
                $spirometri->delete();
                $treadmill->delete();
                $umum->delete();
                $urin->delete();

            } catch (\Exception $ex) {
                return response()->json(['responseCode' => 500, 'responseMessage' => $ex->getMessage()]);
            }

            return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Bulk delete has been finished']);
        }
    }

    /*
    function publish(Mcu $mcu, Request $request)
    {
        //$m = $mcu::where('published', 'N');
        $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa'])->where('published', 'N');

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id bagian
          if($request->client != '') {
   
            $client = $request->client;
            $m->whereHas('vendorCustomer.customer', function($q) use($client) {
               $q->where('id',$client);
            });
            
        }


        // Filter Id Perusahaan vendor
        // if($request->idPerusahaan != '') {
        //    $v = $request->idPerusahaan;
        //    $m->whereHas('vendor', function($q) use ($v) {
        //        $q->where('id', $v);
        //    });
        // }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		// Filter mucid
        if($request->fromId != '' and $request->toId != '') {
            $fromId = $request->fromId;
            $toId = $request->toId;
            $m->whereBetween('id',[$fromId,$toId]);
			
        }
        

        // Get filtered mcu ids
        $ids = collect($m->get())->pluck('id')->toArray();
        //print_r($ids);
        if(!$m->update(['published' => 'Y', 'published_at' => date('Y-m-d H:i:s')])) {
          return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to publish (send wa) data. Please try again']);
        }

        // Dispatch job wayah 
       
        SendReportWhatsApp::dispatch($ids, session()->get('user.name'))->onQueue('wa');
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Data has been published (sent WA) successfully']);
    }

    if($file->isValid()) {
                $nameStripped = str_replace(" ", "-", $file->getClientOriginalName());
                $f = $file->storeAs('upload', $nameStripped,'public'); // linux
                
                $process = new Process();
                $process->fill([
                    'upload'    => 'mcu',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();

                $processId = $process->id;

                ImportMcu::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->delay(now()->addSeconds(3));
             }

             return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]); 


    */

    function publish(Mcu $mcu, Request $request)
    {
        //$m = $mcu::where('published', 'N');
        $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa']); //->where('published', 'N');

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id bagian
          if($request->client != '') {
   
            $client = $request->client;
            $m->whereHas('vendorCustomer.customer', function($q) use($client) {
               $q->where('id',$client);
            });
            
        }


     
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
        
        // Filter mucid
        if($request->fromId != '' and $request->toId != '') {
            $fromId = $request->fromId;
            $toId = $request->toId;
            $m->whereBetween('id',[$fromId,$toId]);
            
        }
        

        // Get filtered mcu ids
        $ids = collect($m->get())->pluck('id')->toArray();
        //$ids = collect($m->get())->pluck('id')->toArray();
        //print_r($ids);
        /*if(!$m->update(['published' => 'Y', 'published_at' => date('Y-m-d H:i:s')])) {
          return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to publish (send wa) data. Please try again']);
        }

        // Dispatch job wayah  
       
        SendReportWhatsApp::dispatch($ids, session()->get('user.name'))->onQueue('wa');
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Data has been published (sent WA) successfully']);
        */

        $process = new Process();
        $process->fill([
            'upload'    => 'sendwa',
            'processed' => 0,
            'success'   => 0,
            'failed'    => 0,
            'total'     => count($ids),
            'status'    => 'ON PROGRESS'
        ]);
        $process->save();

        $processId = $process->id;

        SendReportWhatsApp::dispatch($ids, session()->get('user.name'), $processId)->onQueue('wa')->delay(now()->addSeconds(2));

        return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Data has been published (sent WA) successfully',
                'processId' => $processId
        ]); 


    }

    /**
     * Export rontgen
     *
     * @return type file .xlsx
     */
     function export(Request $request)
    {
        $starDate = $request->startDate;
        $endDate = $request->endDate;
        $idPerusahaan = $request->idPerusahaan;
        return Excel::download(new McuExport($starDate, $endDate, $idPerusahaan), 'database-mcu.xlsx');
    }

	function export2(Request $request)
    {

		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        $code = $request->code;

        return Excel::download(new McuReportExport($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate,
												   $code
												   ), 'report-mcu.xlsx');
    }
	
	function exportKeskerja(Request $request)
	{
		/* diagnosis kesehatan kerja */
		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        $diagnosis = $request->diagnosis;

        return Excel::download(new McuReportDiagnosisExport($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate,
												   $diagnosis,
												   "dk"
												   ), 'report-diagonis-kerja-mcu.xlsx');
		
	}
	function export3(Request $request)
    {
		/* diagnosis kesehatan kerja */
		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        $diagnosis = $request->diagnosis;

        return Excel::download(new McuReportDiagnosisExport($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate,
												   $diagnosis,
												   "dkk"
												   ), 'report-diagonis-kesehatan-kerja-mcu.xlsx'); //dkk diagnosa-kesehatan-kerja
    }

	function export4(Request $request)
    {
		
		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        //$diagnosis = $request->diagnosis;

        return Excel::download(new McuReportMostSufferedExport($idPasien,
												   $nama,
												   $nip,
												   $tglLahir,
												   $lp,
												   $bagian,
												   $idPerusahaan,
												   $idVendor,
												   $client,
												   $startDate,
												   $endDate
												   ), 'report-most-suffered-mcu.xlsx');
    }

	
	function export5(Request $request) 
    {
		/* diagnosis ekg */
		$idPasien = $request->idPasien;
		$nama = $request->nama;
		$nip = $request->nip;
		$tglLahir = $request->tglLahir;
		$lp = $request->lp;
		$bagian = $request->bagian;
		$idPerusahaan = $request->idPerusahaan;
		$idVendor = $request->idVendor;
		$ekg = $request->ekg;
		$client = $request->client;
		$startDate = $request->startDate;
        $endDate = $request->endDate;
        
		
		
        return Excel::download(new McuReportEkgExport($idPasien, 
												   $nama, 
												   $nip, 
												   $tglLahir, 
												   $lp, 
												   $bagian, 
												   $idPerusahaan, 
												   $idVendor, 
												   $ekg, 
												   $client, 
												   $startDate, 
												   $endDate
												   ), 'report-ekg-mcu.xlsx');
    }
	
	function cancelImportMcu(Request $request)
	{
		try { 
			$process = Process::where('id',$request->process_id)->delete();
			$antrovisus = Antrovisus::where('process_id',$request->process_id)->delete();
			$mcu = Mcu::where('process_id',$request->process_id)->delete();
			$fisik = Fisik::where('process_id',$request->process_id)->delete();
			$audiometri = Audiometri::where('process_id',$request->process_id)->delete();
			$diagnoses = Diagnosis::where('process_id',$request->process_id)->delete();
			$umum = Umum::where('process_id',$request->process_id)->delete();
			$riwayat = Riwayat::where('process_id',$request->process_id)->delete();
			$hematologi = Hematologi::where('process_id',$request->process_id)->delete();
			$kimia = Kimia::where('process_id',$request->process_id)->delete();
			$aae = Oae::where('process_id',$request->process_id)->delete();
			$rontgen = Rontgen::where('process_id',$request->process_id)->delete();
			$serologi = Serologi::where('process_id',$request->process_id)->delete();
			$spirometri = Spirometri::where('process_id',$request->process_id)->delete();
			$treadmill = Treadmill::where('process_id',$request->process_id)->delete();
			$feses = Feses::where('process_id',$request->process_id)->delete();
			$urin = Urin::where('process_id',$request->process_id)->delete();
			$PapSmear = PapSmear::where('process_id',$request->process_id)->delete();
			$ekg = Ekg::where('process_id',$request->process_id)->delete();
			$rectalSwab = RectalSwab::where('process_id',$request->process_id)->delete();
			$DrugScreening = DrugScreening::where('process_id',$request->process_id)->delete();
			$AudiometriDetail = AudiometriDetail::where('process_id',$request->process_id)->delete();
			$RontgenDetail = RontgenDetail::where('process_id',$request->process_id)->delete();
			$wa = Reportsendwa::where('process_id',$request->process_id)->delete();
			
			 return response()->json([
                'success' => 1,
                'responseCode' => 200,
                'responseMessage' => 'Process Upload has been Terminatd Success',
                'processId' => $request->process_id
            ]); 
			
		} catch (\Exception $ex) {
                return response()->json(['success' => 0,'responseCode' => 500, 'responseMessage' => "Failed"]);
        }
			
	}
	function import(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $processId = null;

            if($file->isValid()) {
                $nameStripped = str_replace(" ", "-", $file->getClientOriginalName());
                $f = $file->storeAs('upload', $nameStripped,'public'); // linux
				
                $process = new Process();
                $process->fill([
                    'upload'    => 'mcu',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();

                $processId = $process->id;

                ImportMcu::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->onQueue('mcu')->delay(now()->addSeconds(3));
             }

             return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]); 
        }
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
        /*
        $audiometriChart  = url("https://image-charts.com/chart.js/2.8.0?bkg=white&c={
                                      type: 'scatter', 
                                      data: {
                                        labels: [".$labels."],
                                        datasets: [
                                          {
                                            label: 'Kiri', 
                                            backgroundColor: 'rgb(255, 99, 132)',
                                            borderColor: 'rgb(255, 99, 132)',
                                            data: [$kiri],
                                            fill: false,
                                          },
                                          {
                                            label: 'Kanan',
                                            fill: false,
                                            backgroundColor: 'rgb(54, 162, 235)',
                                            borderColor: 'rgb(54, 162, 235)',
                                            data: [$kanan],
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
                                                display: false,
                                                labelString: 'FREQUENCY(Hz)',
                                              },
                                              
                                            },
                                            
                                          ],
                                          yAxes: [
                                            {
                                              display: true,
                                              scaleLabel: {
                                                display: false,
                                                labelString: 'HEARING LEVEL (dB)',
                                              },
                                              
                                            },
                                           
                                          ],
                                        },
                                      },
                                    }");
        */
		
	}

    // Reports
	public function publishMedicalCheckUpDetail($id) //harus diganti kodingan
	{

		$decryptedId = decrypt($id);
        $mcu = Mcu::find($decryptedId);

        // Check if has audiometri and chart not exits
        /*$audiometriChart = public_path('storage/audiometri/'.$decryptedId.'.jpg');
        if($mcu->audiometriDetail->count() > 0 && !file_exists($audiometriChart)) {
            // Capture audiometri chart
            $this->capture($decryptedId);
        }*/

        // Check if has spirometri
        $spiro = null;
        //if($mcu->spirometri) {
          //  if($mcu->spirometri->chart) {
            //    $spiro = $mcu->spirometri->chart;
            //}
        //}

        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report', [
            'data' => $mcu,
			'audiometriChart' => $this->getChartFromImagechart($decryptedId),
            'spiro' => $spiro,
           
		]);

        $output =  $pdf->stream();
		 
        return $output;
		
	}
	
	public function publishMedicalCheckUpDetailForWA($id) 
	{

		//$decryptedId = decrypt($id);
        //$mcu = Mcu::find($decryptedId);
        $mcu = Mcu::where('mcu_id_encript',$id)->first();

        // Check if has audiometri and chart not exits
        /*$audiometriChart = public_path('storage/audiometri/'.$decryptedId.'.jpg');
        if($mcu->audiometriDetail->count() > 0 && !file_exists($audiometriChart)) {
            // Capture audiometri chart
            $this->capture($decryptedId);
        }*/

        // Check if has spirometri
        $spiro = null;
        //if($mcu->spirometri) {
          //  if($mcu->spirometri->chart) {
            //    $spiro = $mcu->spirometri->chart;
            //}
        //} 

        
		$kl = $this->dataTtd($mcu);
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report', [
            'data' => $mcu,
			'audiometriChart' => $this->getChartFromImagechart($mcu->id),
            'spiro' => $spiro
		]+$kl);

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

	public function printMedicalCheckUpDetail($id) 
    {
        
		$mcu = Mcu::find($id);
       
        // Check if has audiometri and chart not exits
        /*$audiometriChart = public_path('storage/audiometri/'.$id.'.jpg');
        if($mcu->audiometriDetail->count() > 0 && !file_exists($audiometriChart)) {
            // Capture audiometri chart
            $this->capture($id);
        }*/
		
       

		$c = $this->chart($id);
		$labels =  implode(", ", $c[0]); 
		$kiri = implode(", ", $c[1]);
		$kanan = implode(", ", $c[2]);

         
		
		$pdf =  PDF::loadview('reports.patient.pdf.emcu_report', [
            'data' => $mcu,
			'audiometriChart' => $this->getChartFromImagechart($id)
            
		]+$this->dataTtd($mcu));
		$file = str_replace(" ","-",$mcu->nama_pasien).'-'.$id.'.pdf';
		
		return $pdf->stream();
        //return $pdf->download();
		//$pdf = PDF::loadView('pdf.invoice', $data);
		//Storage::put($file, $pdf->output());
		//Storage::disk('local')->put($newFilename, file_get_contents($file));
    }

    public function printMedicalCheckUpDetail2($id) 
    {
        
        $mcu = Mcu::find($id);
       
        // Check if has audiometri and chart not exits
        /*$audiometriChart = public_path('storage/audiometri/'.$id.'.jpg');
        if($mcu->audiometriDetail->count() > 0 && !file_exists($audiometriChart)) {
            // Capture audiometri chart
            $this->capture($id);
        }*/
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);

        $ttd_a = $mcu->audiometri?$mcu->audiometri->ttd: null;   
        $ttd_r = $mcu->rontgen?$mcu->rontgen->ttd: null;   
        $ttd_e = $mcu->ekg?$mcu->ekg->ttd: null;   
        
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report2', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
            
        ]+$this->dataTtd($mcu));
        $file = str_replace(" ","-",$mcu->nama_pasien).'-'.$id.'.pdf';
        
        return $pdf->stream();
        //return $pdf->download();
        //$pdf = PDF::loadView('pdf.invoice', $data);
        //Storage::put($file, $pdf->output());
        //Storage::disk('local')->put($newFilename, file_get_contents($file));
    } //printMedicalCheckUpDetailDownload

    public function printMedicalCheckUpDetail3($id) 
    {
        
        $mcu = Mcu::find($id);
       
        // Check if has audiometri and chart not exits
        /*$audiometriChart = public_path('storage/audiometri/'.$id.'.jpg');
        if($mcu->audiometriDetail->count() > 0 && !file_exists($audiometriChart)) {
            // Capture audiometri chart
            $this->capture($id);
        }*/
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);
        
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report3', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
        ]+$this->dataTtd($mcu));
        $file = str_replace(" ","-",$mcu->nama_pasien).'-'.$id.'.pdf';
        
        return $pdf->stream();
       
    }

    public function printMedicalCheckUpDetailDownload($id) 
    {
        
        $mcu = Mcu::find($id);
       
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);
        
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
        ]+$this->dataTtd($mcu));
        $file = str_replace(" ","-",$id).'-'.$mcu->nama_pasien.'.pdf';
        return $pdf->download($file);
       
    }

    public function printMedicalCheckUpDetailDownload2($id) 
    {
        
        $mcu = Mcu::find($id);
       
        
        $c = $this->chart($id);
        $labels =  implode(", ", $c[0]); 
        $kiri = implode(", ", $c[1]);
        $kanan = implode(", ", $c[2]);
        
        $pdf =  PDF::loadview('reports.patient.pdf.emcu_report2', [
            'data' => $mcu,
            'audiometriChart' => $this->getChartFromImagechart($id)
        ]+$this->dataTtd($mcu));
        $file = str_replace(" ","-",$id).'-'.$mcu->nama_pasien.'.pdf';
        return $pdf->download($file);
       
    }


    /*private function capture($id)
    {
        $url = url('/database/audiometri-chart/'.$id);
        $screenCapture = new Capture();
        $screenCapture->setUrl($url);
        $screenCapture->setClipWidth(820);
        $screenCapture->setClipHeight(480);
        $screenCapture->setBackgroundColor('#FFFFFF');
        $fileLocation = storage_path('app/public/audiometri/'.$id);
        $screenCapture->save($fileLocation);
    }*/

	public function data_audiometri_charts(Request $rex)
    {
		$id   = $rex->id;
		$side = $rex->side;


		  $audioMetri = AudiometriDetail::where('mcu_id', $id)->get();

		  if($audioMetri->count() > 0)
		  {
			 return response()->json(['responseCode' => 200,
									  'responseMessage' => $audioMetri]);
		  }
		  else
		  {
			  return response()->json(['responseCode' => 500,
									  'responseMessage' => '']);
		  }


	}

    public function data_spirometri_charts(Request $rex)
    {

	}

	public function report()
	{
		 return view('reports.patient.pdf.chart');
	}

    // Reports
    public function exportReportPersonalMedicalCheckUp($id)
    {
        //Data MCU
        $data_mcu = Mcu::find($id);
        return response()->download(storage_path('Report_Patient_MCU.docx'));
    }

    public function reportMedicalCheckUp()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vendor_id = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendor_id))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
		}
		else {
            //$departments = null;
            //$clients = null;
			 $departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			 $clients = Mcu::selectRaw('distinct(client) as client')->get();
        }
        return $this->view('reports.patient.mcu', 'Report Pasien','Medical Check Up', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportMedicalCheckUpDetail($id)
    {
        $mcu = Mcu::find($id);
        return $this->view('reports.patient.mcu-detail','Report','Medical Check-Up Detail', [
            'mcu' => $mcu,
			//'audiometriChart' => 'https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/audiometri/'.$id.'.jpg',
            'audiometriChart' => $this->getChartFromImagechart($id)
            
	
        ]);
    }
	
	public function showdiagnostic($id){
		$mcu = Mcu::find($id);
        return $this->view('pages.mcu.mcu-diagnostic','Detail Diagnostic','Detail Diagnostic',['mcu' => $mcu, 'id' => $id]);
	}
	
	public function diagnostic(Request $rex)
    {
		$id   = $rex->mcu_id;
		$wh_id = $rex->wh_id;
		$cd_id = $rex->cd_id;
		$rekom = $rex->rekom;
		$rekom_id = $rex->rekom_id;
		$id_diagnosis = $rex->id_diagnosis;
	    DB::beginTransaction();
		// update tabel recommendations deleted = 1
		$ds  = Recommendation::find($rekom_id);
		$ds->deleted = 1;
		$detail_formula_id = $ds->formula_detail_id;
		$ds->save(); 
		//{
		//insert baru ke  Recommendation
		$d  = new Recommendation();
		$d->formula_detail_id = $detail_formula_id;
		$d->icd10_id = $cd_id;
		$d->work_health_id	 = $wh_id;
		$d->recommendation	 = $rekom;
		$d->active = 1;
		$d->save();
		$idr = $d->id;
			
		
		$dd  = Diagnosis::find($id_diagnosis);
		$dd->deleted = 1;
		$dd->save();
		
		$di  = new Diagnosis();
		$di->recommendation_id = $idr;
		$di->mcu_id = $id;
		$di->deleted	 = 0;
		$di->save();
		
		if($di->save()) {
			 DB::commit();
			 return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);
		}
		else
		{
			 DB::rollback();
			 return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
		}	
	   
			
	   
		
		
	}
    
	public function reportWorkHealthDiagnosis()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendorId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
		}
		else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.work-health-diagnosis','Report Pasien','Medical Check Up WH Diagnosis', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }
	
	public function reportWorkDiagnosis()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendorId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
		}	
		else {
            $departments = null;
            $clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.work-diagnosis','Report Pasien','Medical Check Up Work Diagnosis', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }
	
	

    public function reportMostSuffered()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vendorId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        } 
		else if(!empty($vendorId))
		{
			 $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendorId) {
                    $q->where('id', $vendorId);
                })
                ->get();
		}
		else {
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
			
            //$departments = null;
            //$clients = null;
        }

        return $this->view('reports.patient.most-suffered','Report Pasien','Diagosa Terbanyak', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportRadiology()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        } else if(!empty($vId)){
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
			
		}else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.radiology', 'Report Radiologi','Radiologi',[
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportAudiometri()
    {
        
		$customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
		}
	    else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.audiometri', 'Report Audiometri','Audiometri',[
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
		//return view('reports.patient.audiometri'); //disini
    }

    public function reportSpirometri()
    {
        $spiros = Spirometri::selectRaw('distinct(kesimpulan_spirometri) as spiro')->get();
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vId = session()->get('user.customer_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vId))
		{
			 $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
		}
		else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.spirometri','Report Spirometri','Spirometri', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients,
            'spiros' => $spiros
        ]);
    }

    public function reportEkg()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vId))
		{
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
			
		}
		else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.ekg','Report Ekg','EKG', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportDrugScreening()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendors = Vendor::where('active', 'Y')->get();
        $customerId = session()->get('user.customer_id');
        $vendor_id = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vendor_id))
		{
			 $departments = Mcu::selectRaw('distinct(bagian) as bagian')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vendor_id) {
                    $q->where('id', $vendor_id);
                })
                ->get();
			
		}		
		else {
            //$departments = null;
            //$clients = null;
			$departments = Mcu::selectRaw('distinct(bagian) as bagian')->get();
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }

        return $this->view('reports.patient.drug-screening','Report DrugScreening','DrugScreening', [
            'customers' => $customers,
            'vendors' => $vendors,
            'departments' => $departments,
            'clients' => $clients
        ]);
    }

    public function reportStatistic()
    {
        $customerId = session()->get('user.customer_id');
        $vId = session()->get('user.vendor_id');
        if(!empty($customerId)) {
            $clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.customer', function($q) use($customerId) {
                    $q->where('id', $customerId);
                })
                ->get();
        }
		else if(!empty($vId))
		{
			$clients = Mcu::selectRaw('distinct(client) as client')
                ->whereHas('vendorCustomer.vendor', function($q) use($vId) {
                    $q->where('id', $vId);
                })
                ->get();
		}
		else {
            //$clients = null;
			$clients = Mcu::selectRaw('distinct(client) as client')->get();
        }
        return $this->view('reports.statistic','Statistika','Statistik umum', [
            'customers' => Customer::where('active', 'Y')->get(),
            'vendors' => Vendor::where('active', 'Y')->get(),
            'clients' => $clients
        ]);
    }
    // End of Reports


    // Graph
    public function reportWorkHealthDiagnosisSummaryData(Request $request)
    {
        // Initial empty where
        $mcuWhere = "";
        $topWhere = "";

        // Initial Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];
		
        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$vendor_id;
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$mcuWhere .= " AND vc.vendor_id=".$idVendor;
			}
		}
		if(session()->get('user.user_group_id')==2){ //vendor
		
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
			}
		}

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter ID pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $mcuWhere .= "AND substring(m.id, 13, 8) = '".$idPasien."'";
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $mcuWhere .= " AND m.no_nip = '".$nik."'";
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $mcuWhere .= " AND m.nama_pasien like '%".$name."%'";
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $mcuWhere .= " AND m.tgl_lahir = '".$tglLahir."'";
        }

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $mcuWhere .= " AND m.bagian='".$bagian."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

        // Filter Bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $mcuWhere .= " AND m.bagian='".$bagian."'";
        }

        // Filter Diagnosis
        if($request->diagnosis != '') {
            $diagnosis = $request->diagnosis;
            $topWhere .= " AND wh_id='".$diagnosis."'";
        }

        // Records filtered
        $SQL = $this->createWHDSQL($orderColumn, $orderDir, $mcuWhere, $topWhere, null, null, true);
        $data = DB::select($SQL);

        return response()->json($data);
    }

    public function reportRadiologySummary(Request $request)
    {
        $m = Rontgen::selectRaw('(case kesan_rontgen when "Dalam batas normal" then "Normal" else "Abnormal" end) as kesan_radiology, count(case kesan_rontgen when "Dalam batas normal" then "Normal" else "Abnormal" end) as total');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        // Fiter ID pasien/medical check up
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Fiter ID pasien/medical check up
        if($request->rontgen != '') {
            $rontgen = $request->rontgen;
            if($rontgen == 'Dalam batas normal') {
                $m->where('kesan_rontgen', $rontgen);
            } else {
                $m->where('kesan_rontgen', '!=', 'Dalam batas normal');
            }
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->whereHas('mcu', function($q) use($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->whereHas('mcu', function($q) use($name) {
                $q->where('nama_pasien', 'like', '%'.$name.'%');
            });
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->whereHas('mcu', function($q) use($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->whereHas('mcu', function($q) use($lp) {
                $q->where('jenis_kelamin', $lp);
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->whereHas('mcu', function($q) use($bagian) {
                $q->where('bagian', $bagian);
            });
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->whereHas('mcu', function($q) use($client) {
                $q->where('client', $client);
            });
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Perusahaan
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('mcu.vendorCustomer.vendor', function($q) use($idVendor){
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2) { //vendor 
		
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $m->groupBy(DB::raw('kesan_radiology'));

        return response()->json($m->get());
    }

    public function reportAudiometriSummary(Request $request)
    {
        $l = Audiometri::selectRaw('hasil_telinga_kiri, count(hasil_telinga_kiri) as kiri')
            ->whereHas('mcu', function($q) {
                $q->where('published', 'Y');
            });

        $r = Audiometri::selectRaw('hasil_telinga_kanan, count(hasil_telinga_kanan) as kanan')
        ->whereHas('mcu', function($q) {
            $q->where('published', 'Y');
        });

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $l->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
            $r->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has customer
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $l->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
            $r->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $l->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
            $r->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $l->whereHas('mcu', function($q) use($nik) {
                $q->where('no_nip', $nik);
            });
            $r->whereHas('mcu', function($q) use($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $l->whereHas('mcu', function($q) use($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
            $r->whereHas('mcu', function($q) use($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $l->whereHas('mcu', function($q) use($lp) {
                $q->where('jenis_kelamin', $lp);
            });
            $r->whereHas('mcu', function($q) use($lp) {
                $q->where('jenis_kelamin', $lp);
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $l->whereHas('mcu', function($q) use($name) {
                $q->where('nama_pasien', 'like', $name);
            });
            $r->whereHas('mcu', function($q) use($name) {
                $q->where('nama_pasien', 'like', $name);
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $l->whereHas('mcu', function($q) use($bagian) {
                $q->where('bagian', $bagian);
            });
            $r->whereHas('mcu', function($q) use($bagian) {
                $q->where('bagian', $bagian);
            });
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $l->whereHas('mcu', function($q) use($client) {
                $q->where('client', $client);
            });
            $r->whereHas('mcu', function($q) use($client) {
                $q->where('client', $client);
            });
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
        //    $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
        //    $l->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        //    $r->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        //}
		
		
		    // Check is has customer
       if(session()->get('user.user_group_id')==1) { //admin 
	   
			if($request->idPerusahaan != '')
			{
				
				$customerId =$request->idPerusahaan;
				$l->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
				$r->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
		
		    // Check is has vendor
			if($request->idVendor != '')
			{	
				$vendor_id = $request->idVendor;
				$l->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
					$q->where('id', $vendor_id);
				});
				$r->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
					$q->where('id', $vendor_id);
				});
			}
	   }
	   
	   if(session()->get('user.user_group_id')==2) { //vendor

			$customerId = session()->get('user.customer_id');
            $l->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
            $r->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
       
	   }
	   
	   

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $l->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
            $r->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $l->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
            $r->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $l->groupBy('hasil_telinga_kiri');
        $r->groupBy('hasil_telinga_kanan');

        return response()->json([
            'l' => $l->get(),
            'r' => $r->get()
        ]);
    }

    public function reportDrugScreeningSummary(Request $request)
    {
        $m = DrugScreening::selectRaw('kesimpulan_drug_screening, count(kesimpulan_drug_screening) as total')
            ->whereHas('mcu', function($q) {
                $q->where('published', 'Y');
            });

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vn
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->whereHas('mcu', function($q) use($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->whereHas('mcu', function($q) use($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->whereHas('mcu', function($q) use($lp) {
                $q->where('jenis_kelamin', $lp);
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->whereHas('mcu', function($q) use($name) {
                $q->where('nama_pasien', 'like', $name);
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->whereHas('mcu', function($q) use($bagian) {
                $q->where('bagian', $bagian);
            });
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->whereHas('mcu', function($q) use($client) {
                $q->where('client', $client);
            });
        }

        // Filter Id Perusahaan
		if(session()->get('user.user_group_id')==1) { //admin 
			if($request->idPerusahaan != '') {
				$idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
				$m->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
			}
			
			 if($request->idVendor != '') {
				$idVendor =  str_pad($request->idVendor, 4, 0, 0);
				$m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			
			 }
		 }
		 if(session()->get('user.user_group_id')==2){ //vendor
			if($request->idPerusahaan != '') {
				$idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
				$m->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
			}
		 
		 }
		 
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $m->groupBy('kesimpulan_drug_screening');

        return response()->json($m->get());
    }

    public function reportSpirometriSummary(Request $request)
    {
        $m = Spirometri::selectRaw('kesimpulan_spirometri, count(kesimpulan_spirometri) as total')
                ->whereHas('mcu', function($q) {
                    $q->where('published', 'Y');
                });

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 if(!empty(session()->get('user.vendor_id'))) {
            $vnId = session()->get('user.vendor_id');
            $m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vnId) { 
                $q->where('id', $vnId);
            });
        }

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter spiro
        if($request->spiro != '') {
            $spiro = $request->spiro;
            $m->where('kesimpulan_spirometri', $spiro);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->whereHas('mcu', function($q) use ($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->whereHas('mcu', function($q) use ($name) {
                $q->where('nama_pasien', 'like', $name);
            });
        }

        // Filter Tgl lahir
        if($request->tglLahir!= '') {
            $tglLahir = $request->tglLahir;
            $m->whereHas('mcu', function($q) use ($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->whereHas('mcu', function($q) use ($lp) {
                $q->where('jenis_kelamin', $lp);
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->whereHas('mcu', function($q) use ($bagian) {
                $q->where('bagian', $bagian);
            });
        }

        // Filter client
        if($request->client != '') {
            $client = $request->client;
            $m->whereHas('mcu', function($q) use ($client) {
                $q->where('client', $client);
            });
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
        //    $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
        //    $m->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        //}
		if(session()->get('user.user_group_id')==1) { //admin 
			 // Check is has customer
			if($request->idPerusahaan != '') {
				$customerId = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
			
			 if($request->idVendor != '') {
				$vnId = $request->idVendor;
				$m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vnId) { 
					$q->where('id', $vnId);
				});
			}
		}
		
		if(session()->get('user.user_group_id')==2) { //admin 
			
			 // Check is has customer
			if($request->idPerusahaan != '') {
				$customerId = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
		
		}
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $m->groupBy('kesimpulan_spirometri');

        return response()->json($m->get());
    }

    public function reportEkgSummary(Request $request)
    {
        $m = Ekg::selectRaw('(case kesimpulan_ekg when "Normal EKG" then "Normal" else "Abnormal" end) as result_ekg, count(case kesimpulan_ekg when "Normal EKG" then "Normal" else "Abnormal" end) as total');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('mcu.vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 if(!empty(session()->get('user.vendor_id'))) {
            $vId = session()->get('user.vendor_id');
            $m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($vId) {
                $q->where('id', $vId);
            });
        }

        if($request->ekg != '') {
            $ekg = $request->ekg;
            if($ekg == 'Normal EKG') {
                $m->where('kesimpulan_ekg', 'Normal EKG');
            } else {
                $m->where('kesimpulan_ekg', '!=', 'Normal EKG');
            }
        }

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->whereHas('mcu', function($q) use ($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->whereHas('mcu', function($q) use ($name) {
                $q->where('nama_pasien', 'like', '%'.$name.'%');
            });
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->whereHas('mcu', function($q) use ($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
        }

        // Filter Lp
        if($request->lp != '') {
            $lp = $request->lp;
            $m->whereHas('mcu', function($q) use ($lp) {
                $q->where('jenis_kelamin', $lp);
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->whereHas('mcu', function($q) use ($bagian) {
                $q->where('bagian', $bagian);
            });
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->whereHas('mcu', function($q) use ($client) {
                $q->where('client', $client);
            });
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('mcu.vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		}
		if(session()->get('user.user_group_id')==2) { //vendor 
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $m->groupBy(DB::raw('result_ekg'));

        return response()->json($m->get());
    }

    public function reportSexSummary(Request $request)
    {
        $m = Mcu::selectRaw('jenis_kelamin, count(jenis_kelamin) as total');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vId) {
                $q->where('id', $vId);
            });
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		}
		
		if(session()->get('user.user_group_id')==2) { //vendro 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}
		
		
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $m->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $m->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $m->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        $m->groupBy('jenis_kelamin');

        return response()->json($m->get());
    }

    public function reportAgeSummary(Request $request)
    {
        $m = Mcu::selectRaw("(case
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 0 and 29 then '< 30'
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 30 and 30 then '30 - 40'
		else '> 40'
	end) as age_range,
	count(case
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 0 and 29 then '< 30'
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 30 and 30 then '30 - 40'
		else '> 40'
	end) as total");

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vId) {
                $q->where('id', $vId);
            });
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }

		if(session()->get('user.user_group_id')==2) { //vendro 
		
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		}
		
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $m->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $m->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $m->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        $m->groupBy(DB::raw("(case
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 0 and 29 then '< 30'
		when truncate(((to_days(curdate()) - to_days(str_to_date(tgl_lahir,'%Y-%m-%d'))) / 365), 0) between 30 and 30 then '30 - 40'
		else '> 40'
	end)"));

        return response()->json($m->get());
    }

    public function reportEventSummary(Request $request)
    {
        $m = Mcu::selectRaw('tgl_input, count(tgl_input) as total');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has customer
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		}
		
		if(session()->get('user.user_group_id')==2) { //vendro 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $m->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $m->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $m->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        $m->groupBy('tgl_input');

        return response()->json($m->get());
    }

    public function reportEventSexSummary(Request $request)
    {
        $m = Mcu::selectRaw('tgl_input, jenis_kelamin, count(jenis_kelamin) as total')->where('published', 'Y');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		if(!empty(session()->get('user.vendor_id'))) {
            $vId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vId) {
                $q->where('id', $vId);
            });
        }
		//sampai disini cek sampai modul report audioMetri
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', $name);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id bagian
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
            $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $m->groupBy('jenis_kelamin', 'tgl_input');

        return response()->json($m->get());
    }
    // End of Graph

    public function datatables(Request $request)
    {
        $m = Mcu::with(['vendorCustomer.customer','vendorCustomer.vendor','reportsendwa']);

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $customerId = session()->get('user.vendor_id');
            $m->whereHas('vendor', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }


        $recordTotal = $m->count();

        if($request->idPasien != '') {
            //$idPasien = str_pad($request->idPasien, 8, 0, 0);
            $idPasien = $request->idPasien;
            //$m->whereRaw('substring(id, 13, 8) = '.$idPasien);
            $m->where('id',$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }
       
        // Filter Client
        if($request->client != '') {
   
            $client = $request->client;
            $m->whereHas('vendorCustomer.customer', function($q) use($client) {
               $q->where('id',$client);
            });
            
        }

        // Filter Id Perusahaan
        // if($request->idPerusahaan != '') {
        //     $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
        //     $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        // }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }


    public function reportMedicalCheckUpDatatables(Request $request)
    {
        $m = Mcu::with('vendorCustomer');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = $request->idPerusahaan;
            $m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
                $q->where('id', $idPerusahaan);
            });
        }

        // Filter Id Vendor
        if($request->idVendor != '') {
            $idVendor = $request->idVendor;
            $m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
                $q->where('id', $idVendor);
            });
        }

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportWorkHealthDiagnosisDatatables(Request $request)
    {
        // Initial empty where biasa
        $mcuWhere = "";
        $topWhere = "";

        // Initial Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColumn = $request->columns[$orderIndex]['data'];

        // Records totals
        $recordsTotalSQL = $this->createWHDSQL($orderColumn, $orderDir, $topWhere, null, null, null, null);
        $recordsTotal = DB::select("SELECT COUNT(*) AS total FROM (".$recordsTotalSQL.") rt");

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.customer_id=".$customerId;
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $mcuWhere .= " AND vc.vendor_id=".$vId;
        }

        // Filter Id Perusahaan
        if($request->idPerusahaan != '') {
            $idPerusahaan = $request->idPerusahaan;
            $mcuWhere .= " AND vc.customer_id=".$idPerusahaan;
        }

        // Filter Id Vendor
        if($request->idVendor != '') {
            $idVendor = $request->idVendor;
            $mcuWhere .= " AND vc.vendor_id=".$idVendor;
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $mcuWhere .= " AND m.client='".$client."'";
        }

        // Filter ID pasien
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $mcuWhere .= "AND substring(m.id, 13, 8) = '".$idPasien."'";
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $mcuWhere .= " AND m.no_nip = '".$nik."'";
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $mcuWhere .= " AND m.nama_pasien like '%".$name."%'";
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $mcuWhere .= " AND m.tgl_lahir = '".$tglLahir."'";
        }

        // Filter Sex
        if($request->sex != '') {
            $sex = $request->sex;
            $mcuWhere .= " AND m.jenis_kelamin='".$sex."'";
        }

        // Filter Bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $mcuWhere .= " AND m.bagian='".$bagian."'";
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $mcuWhere .= " AND m.tgl_input > '".$request->startDate."'";
        }

        if($request->startDate == '' && $request->endDate != '') {
            $mcuWhere .= " AND m.tgl_input < '".$request->endDate."'";
        }

        if($request->startDate != '' && $request->endDate != '') {
            $mcuWhere .= " AND (m.tgl_input BETWEEN '".$request->startDate."' AND '".$request->endDate."')";
        }

        // Filter Bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $mcuWhere .= " AND m.bagian='".$bagian."'";
        }

        // Filter Diagnosis
        if($request->diagnosis != '') {
            $diagnosis = $request->diagnosis;
            $topWhere .= " AND wh_id='".$diagnosis."'";
        }

        // Records filtered
        $recordsFilteredSQL = $this->createWHDSQL($orderColumn, $orderDir, $mcuWhere, $topWhere, null, null, null);
        $recordsFiltered = DB::select("SELECT COUNT(*) AS total FROM (".$recordsFilteredSQL.") rf");

        // Records Paging
        $recordsFilteredPagingSQL = $this->createWHDSQL($orderColumn, $orderDir, $mcuWhere, $topWhere, $request->start, $request->length, false);
        $recordsPaging = DB::select($recordsFilteredPagingSQL);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordsTotal[0]->total,
            'recordsFiltered'   => $recordsFiltered[0]->total,
            'data'              => $recordsPaging,
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    private function createWHDSQL($orderColumn, $orderDir, $where = null, $topWhere = null, $take = null, $limit = null, $group = false)
    {
        $fields = "m.*, wh.id AS wh_id, wh.name AS wh_name ";
        $orderOrGroup = " ORDER BY ".$orderColumn." ".$orderDir;

        if($group) {
            $fields = "wh.id AS wh_id, wh.name AS wh_name, COUNT(wh.id) AS total ";
            $orderOrGroup = " GROUP BY wh.id, wh.name";
        }

        $SQL = "SELECT ".$fields."
        FROM (
            SELECT m.*
            FROM mcu m
            JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
            WHERE 1=1 ".$where."
        ) m
        JOIN (
            SELECT d.mcu_id, MIN(r.work_health_id) AS wh_id
            FROM (
                SELECT mcu_id, recommendation_id
                FROM diagnoses
                WHERE mcu_id IN (
                    SELECT m.id
                    FROM mcu m
                    JOIN vendor_customer vc ON m.vendor_customer_id=vc.id
                    WHERE 1=1 ".$where."
                ) AND deleted = '0'
            ) d
            JOIN (
                SELECT id, work_health_id
                FROM recommendations r
                WHERE id IN (
                    SELECT recommendation_id
                    FROM diagnoses
					where deleted = '0'
                    GROUP BY recommendation_id
                )
            ) r ON d.recommendation_id=r.id
            GROUP BY d.mcu_id
        ) d ON m.id=d.mcu_id
        JOIN work_healths wh ON d.wh_id=wh.id
        WHERE 1=1 "
        .$topWhere
        .$orderOrGroup;

        if($take != null && $limit != null) {
            $SQL .= " LIMIT ".$take.",".$limit;
        }

        //echo $SQL;

        return $SQL;
    }

    public function reportMostSufferedDatatables(Request $request)
    {
        
		$m = Mcu::whereHas('diagnosis', function ($query) {
				$query->where('deleted', 0);
			})->with('vendorCustomer.customer')->withCount('diagnosis');
		/* $m = Mcu::has('diagnosis')
                ->with('vendorCustomer.customer')
                ->withCount('diagnosis'); */

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		//Check is has vendor
		 if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id Vendor
        //if($request->idVendor != '') {
          //  $idVendor = $request->idVendor;
            //$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
              //  $q->where('id', $idVendor);
            //});
        //}

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
            //$idPerusahaan = $request->idPerusahaan;
            //$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
              //  $q->where('id', $idPerusahaan);
            //});
        //}
		if(session()->get('user.user_group_id')==1) { //admin 
			
			 if($request->idVendor != '') {
			   $idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor) {
				   $q->where('id', $idVendor);
				});
			}

       
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
				   $q->where('id', $idPerusahaan);
				});
			}
		
		}
		if(session()->get('user.user_group_id')==2){ //vendor
			
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan) {
				   $q->where('id', $idPerusahaan);
				});
			}
		
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }
	
	public function filterRequest(Request $request)
	{
		$m = Mcu::with('rontgen')->has('rontgen');	
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendr
        if(!empty(session()->get('user.vendor_id'))) {
            $cvd = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($cvd) {
                $q->where('id', $cvd);
            });
        }

        $recordTotal = $m->count();

        // Filter ID pasien/medical check up
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter kesan rontgen
        if($request->rontgen != '') {
            $rontgen = $request->rontgen;
            $m->whereHas('rontgen', function($q) use($rontgen) {
                if($rontgen == 'Dalam batas normal') {
                    $q->where('kesan_rontgen', $rontgen);
                } else {
                    $q->where('kesan_rontgen', '!=', 'Dalam batas normal');
                }
            });
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor){
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		return [$m,$recordTotal];
	}
	
    public function reportRadiologyDatatables(Request $request)
    {
        

        $m = $this->filterRequest($request)[0];
        $recordTotal = $this->filterRequest($request)[1];

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportAudiometriDatatables(Request $request)
    {
        //$m = Mcu::with('audiometri'); //oko
        $m = Audiometri::with('mcu'); //oko

       
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $cusd = str_pad(session()->get('user.customer_id'), 4, 0, 0);
            $m->whereHas('mcu.vendorCustomer', function($q) use ($cusd) {
                $q->where('customer_id', $cusd);
            });
			
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            
			$vendorId = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $m->whereHas('mcu.vendorCustomer', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            });
        }


        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(mcu_id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            //$m->where('mcu.no_nip', $nik);
			$m->whereHas('mcu', function($q) use ($nik) {
                $q->where('no_nip', $nik);
            });
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            //$m->where('mcu.tgl_lahir', $tglLahir);
			$m->whereHas('mcu', function($q) use ($tglLahir) {
                $q->where('tgl_lahir', $tglLahir);
            });
		
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            //$m->where('mcu.jenis_kelamin', $lp);
			$m->whereHas('mcu', function($q) use ($lp) {
                $q->where('jenis_kelamin', 'like', '%'.$lp.'%');
            });
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
           
			$m->whereHas('mcu', function($q) use ($name) {
                $q->where('nama_pasien', 'like', '%'.$name.'%');
            });
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            //$m->where('mcu.bagian', $bagian);
			$m->whereHas('mcu', function($q) use ($bagian) {
                $q->where('bagian', 'like', '%'.$bagian.'%');
            });
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            //$m->where('mcu.client', $client);
			$m->whereHas('mcu', function($q) use ($client) {
                $q->where('client', 'like', '%'.$client.'%');
            });
        }


        // Filter Kategori
        if($request->category != '') {
            $category = $request->category;
            $m->where('kesimpulan_audiometri', 'like', '%'.$category.'%');
            
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
        //    $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
        //    $m->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        //}
		
		
		if(session()->get('user.user_group_id')==1) { //admin 
			if($request->idPerusahaan != '') {
				$cusd = $request->idPerusahaan;
					$m->whereHas('mcu.vendorCustomer', function($q) use ($cusd) {
					$q->where('customer_id', $cusd);
					});
			}
			if($request->idVendor != '') {
				$vendorId = $request->idVendor;
				$m->whereHas('mcu.vendorCustomer', function($q) use ($vendorId) {
					$q->where('vendor_id', $vendorId);
				});
			}
        }
		
		if(session()->get('user.user_group_id')==2) { //vendor
			if($request->idPerusahaan != '') {
				$cusd = $request->idPerusahaan;
				$m->whereHas('mcu.vendorCustomer', function($q) use ($cusd) {
					$q->where('customer_id', $cusd);
				});
			}
		}
		

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        //$m->orderBy($orderColum, $orderDir);
        $m->orderBy('mcu_id', 'desc');
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportDrugScreeningDatatables(Request $request)
    {
        $m = Mcu::with('drugScreening')->has('drugScreening');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
		if(session()->get('user.user_group_id')==1) { //admin 
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		}
		if(session()->get('user.user_group_id')==2){ //vendor
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}
		
		
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportSpirometriDatatables(Request $request)
    {
        $m = Mcu::with('spirometri')->has('spirometri');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = $m->count();

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter Spiro
        if($request->spiro != '') {
            $spiro = $request->spiro;
            $m->whereHas('spirometri', function($q) use($spiro) {
                $q->where('kesimpulan_spirometri', $spiro);
            });
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', $name);
        }

        // Filter Tgl lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id Perusahaan
        //if($request->idPerusahaan != '') {
        //    $idPerusahaan = str_pad($request->idPerusahaan, 4, 0, 0);
        //    $m->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        //}
		if(session()->get('user.user_group_id')==1) { //admin 
			 // Check is has customer
			if($request->idPerusahaan != '') {
				$customerId =$request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
			
			// Check is has vendor
			if($request->idVendor != '') {
				$vendor_id = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
					$q->where('id', $vendor_id);
				});
			}
		}
		if(session()->get('user.user_group_id')==2) { //admin 
			 // Check is has customer
			if($request->idPerusahaan != '') {
				$customerId =$request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
					$q->where('id', $customerId);
				});
			}
			
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportEkgDatatables(Request $request)
    {
        $m = Mcu::has('ekg')->with('ekg');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		 // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = $m->count();

        if($request->ekg != '') {
            $ekg = $request->ekg;
            $m->whereHas('ekg', function($q) use($ekg) {
                if($ekg == 'Normal EKG') {
                    $q->where('kesimpulan_ekg', 'Normal EKG');
                } else {
                    $q->where('kesimpulan_ekg', '!=', 'Normal EKG');
                }
            });
        }

        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter Sex
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		
		if(session()->get('user.user_group_id')==2) { //admin 
				
				// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
			
			
		}
		
        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        $recordFiltered = $m->count();

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportPaketDatatables(Request $request)
    {
        $paket = Mcu::selectRaw('paket_mcu, count(paket_mcu) as total')->groupBy('paket_mcu');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $paket->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }

        // Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            //$vendor_id = str_pad(session()->get('user.vendor_id'), 4, 0, 0);
            $vendor_id = session()->get('user.vendor_id');
			$paket->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = count($paket->get());

        // Search
        foreach($request->columns as $column) {
            if($column['searchable'] == 'true') {
                $paket->where($column['data'], 'like' ,'%'.$request->search['value'].'%');
            }
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$paket->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$paket->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		
		if(session()->get('user.user_group_id')==2) { //vendr 
			
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$paket->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

		}
		

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $paket->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $paket->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $paket->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $paket->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        $recordFiltered = count($paket->get());

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $paket->orderBy($orderColum, $orderDir);
        $paket->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $paket->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportBagianDatatables(Request $request)
    {
        $m = Mcu::selectRaw('bagian, count(bagian) as total')->groupBy('bagian');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendor_id = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendor_id) {
                $q->where('id', $vendor_id);
            });
        }

        $recordTotal = count($m->get());

        // Search
        foreach($request->columns as $column) {
            if($column['searchable'] == 'true') {
                $m->where($column['data'], 'like' ,'%'.$request->search['value'].'%');
            }
        }
		
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2) { //vendor 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		}
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $m->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $m->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $m->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        $recordFiltered = count($m->get());

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function reportClientDatatables(Request $request)
    {
        $m = Mcu::selectRaw('client, count(client) as total')->groupBy('client');

        // Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = count($m->get());
		if(session()->get('user.user_group_id')==1) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use ($idVendor) {
					$q->where('id', $idVendor);
				});
			}
		}
		if(session()->get('user.user_group_id')==2) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use ($idPerusahaan) {
					$q->where('id', $idPerusahaan);
				});
			}
		
		}
		
		
		
        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Date
        if($request->startDate != '' && $request->endDate == '') {
            $m->where('tgl_input', '>', $request->startDate);
        }

        if($request->startDate == '' && $request->endDate != '') {
            $m->where('tgl_input', '<', $request->endDate);
        }

        if($request->startDate != '' && $request->endDate != '') {
            $m->whereBetween('tgl_input', [$request->startDate, $request->endDate]);
        }

        // Search
        foreach($request->columns as $column) {
            if($column['searchable'] == 'true') {
                $m->where($column['data'], 'like' ,'%'.$request->search['value'].'%');
            }
        }

        $recordFiltered = count($m->get());

        // Order
        $orderIndex = (int) $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $orderColum = $request->columns[$orderIndex]['data'];

        $m->orderBy($orderColum, $orderDir);
        $m->skip($request->start)->take($request->length);

        return response()->json([
            'draw'              => $request->draw,
            'recordsTotal'      => $recordTotal,
            'recordsFiltered'   => $recordFiltered,
            'data'              => $m->get(),
            'input'             => [
                'start' => $request->start,
                'draw' => $request->draw,
                'length' => $request->length,
                'order' => $orderIndex,
                'orderDir' => $orderDir,
                'orderColumn' => $request->columns[$orderIndex]['data']
            ]
        ]);
    }

    public function compareMedicalCheckUp(Request $request)
    {
        $ids = $request->id;
        $mcus = Mcu::whereIn('id', $ids);
        $class = $mcus->count() == 2 ? 'col-md-4' : 'col-md-3';
        return $this->view('reports.patient.compare-mcu','Compare','Compare', [
            'class' => $class,
            'mcus' => $mcus->get()
        ]);
    }
	
	function exportRadiology(Request $request)
    {
        $m = $this->filterRequest($request)[0];
		$data = $m->get();
		return Excel::download(new CollectionExportRadiology($data), 'report-radiologi.xlsx');
		
	}
	
	public function filterRequestDrugScreening(Request $request) 
	{
		$m = Mcu::with('drugScreening')->has('drugScreening');	
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = $m->count();

        // Filter ID pasien/medical check up
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter kesan rontgen
        /* if($request->rontgen != '') {
            $rontgen = $request->rontgen;
            $m->whereHas('rontgen', function($q) use($rontgen) {
                if($rontgen == 'Dalam batas normal') {
                    $q->where('kesan_rontgen', $rontgen);
                } else {
                    $q->where('kesan_rontgen', '!=', 'Dalam batas normal');
                }
            });
        } */

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

        // Filter Id Perusahaan
		if(session()->get('user.user_group_id')==1) { //admin 
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor){
					$q->where('id', $idVendor);
				});
			}
        }
		if(session()->get('user.user_group_id')==2){ //vendor
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		return [$m,$recordTotal];
	}
	
	
	function exportDrugScreening(Request $request) //waya
    {
        $m = $this->filterRequestDrugScreening($request)[0];
		$data = $m->get();
		return Excel::download(new CollectionExportDrugScreening($data), 'report-export-drug-screening.xlsx');
		
	}
	
	public function filterRequestAdiometri(Request $request)
	{
		$m = Mcu::with(['audiometri','vendorCustomer']); //->has('audiometri');	
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = $m->count();

        // Filter ID pasien/medical check up
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

       

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Category
        if($request->category != '') {
            $category = $request->category;
           
            $m->whereHas('audiometri', function($q) use ($category) {
                $q->where('kesimpulan_audiometri', 'like', '%'.$category.'%');
            });

        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }
		if(session()->get('user.user_group_id')==1) { //admin 
        
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor){
					$q->where('id', $idVendor);
				});
			}
		}
		if(session()->get('user.user_group_id')==2) { //admin 
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		return [$m,$recordTotal];
	}
	
	function exportAudiometri(Request $request)
    {
        $m = $this->filterRequestAdiometri($request)[0];
		$data = $m->get();
        // var_dump($data);
		return Excel::download(new CollectionExportAudiometri($data), 'report-audiometri.xlsx');
		
	}
	
	public function filterRequestSpirometri(Request $request)
	{
		$m = Mcu::with('spirometri')->has('spirometri');	
		// Check is has customer
        if(!empty(session()->get('user.customer_id'))) {
            $customerId = session()->get('user.customer_id');
            $m->whereHas('vendorCustomer.customer', function($q) use ($customerId) {
                $q->where('id', $customerId);
            });
        }
		
		// Check is has vendor
        if(!empty(session()->get('user.vendor_id'))) {
            $vendorId = session()->get('user.vendor_id');
            $m->whereHas('vendorCustomer.vendor', function($q) use ($vendorId) {
                $q->where('id', $vendorId);
            });
        }

        $recordTotal = $m->count();

        // Filter ID pasien/medical check up
        if($request->idPasien != '') {
            $idPasien = str_pad($request->idPasien, 8, 0, 0);
            $m->whereRaw('substring(id, 13, 8) = '.$idPasien);
        }

        // Filter kesan rontgen
        /* if($request->rontgen != '') {
            $rontgen = $request->rontgen;
            $m->whereHas('rontgen', function($q) use($rontgen) {
                if($rontgen == 'Dalam batas normal') {
                    $q->where('kesan_rontgen', $rontgen);
                } else {
                    $q->where('kesan_rontgen', '!=', 'Dalam batas normal');
                }
            });
        } */

        // Filter NIK
        if($request->nip != '') {
            $nik = $request->nip;
            $m->where('no_nip', $nik);
        }

        // Filter Name
        if($request->nama != '') {
            $name = $request->nama;
            $m->where('nama_pasien', 'like', '%'.$name.'%');
        }

        // Filter Tgl Lahir
        if($request->tglLahir != '') {
            $tglLahir = $request->tglLahir;
            $m->where('tgl_lahir', $tglLahir);
        }

        // Filter LP
        if($request->lp != '') {
            $lp = $request->lp;
            $m->where('jenis_kelamin', $lp);
        }

        // Filter Client
        if($request->client != '') {
            $client = $request->client;
            $m->where('client', $client);
        }

        // Filter Id bagian
        if($request->bagian != '') {
            $bagian = $request->bagian;
            $m->where('bagian', $bagian);
        }

		if(session()->get('user.user_group_id')==1) { //admin 	
			// Filter Id Perusahaan
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}

			// Filter Id Vendor
			if($request->idVendor != '') {
				$idVendor = $request->idVendor;
				$m->whereHas('vendorCustomer.vendor', function($q) use($idVendor){
					$q->where('id', $idVendor);
				});
			}
		}
		if(session()->get('user.user_group_id')==2) { //admin 	
			if($request->idPerusahaan != '') {
				$idPerusahaan = $request->idPerusahaan;
				$m->whereHas('vendorCustomer.customer', function($q) use($idPerusahaan){
					$q->where('id', $idPerusahaan);
				});
			}
		
		}

        // Filter Date
        if($request->startDate != '') {
            $startDate = date('Ymd', strtotime($request->startDate));
            $m->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }
        if($request->endDate != '') {
            $endDate = date('Ymd', strtotime($request->endDate));
            $m->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }
		
		return [$m,$recordTotal];
	}
	
	
	function exportSpirometri(Request $request)
    {
        $m = $this->filterRequestSpirometri($request)[0];
		$data = $m->get();
		return Excel::download(new CollectionExportSpirometri($data), 'report-spirometri.xlsx');
		
	}
    
}
