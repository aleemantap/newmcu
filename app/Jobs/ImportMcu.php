<?php

namespace App\Jobs;
use Illuminate\Support\Facades\DB;
use App\Models\Mcu;
use App\Models\Riwayat;
use App\Models\Antrovisus;
use App\Models\Fisik;
use App\Models\Hematologi;
use App\Models\Kimia;
use App\Models\Serologi;
use App\Models\Urin;
use App\Models\DrugScreening;
use App\Models\RectalSwab;
use App\Models\Feses;
use App\Models\Rontgen;
use App\Models\Ekg;
use App\Models\Treadmill;
use App\Models\Umum;
use App\Models\Audiometri;
// use App\Models\Oae;
use App\Models\Spirometri;
use App\Models\PapSmear;
use App\Models\Process;
// use App\Models\FormulaDetail;
// use App\Models\Formula;
// use App\Models\Parameter;
use App\Models\Diagnosis;
use App\Models\Ttd;
use Exception;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

//use Illuminate\Support\Facades\DB;


class ImportMcu implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    protected $processId;
    protected $loop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $processId)
    {
        $this->filename = $filename;
        $this->processId = $processId;
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        try {
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$this->filename);
            $reader = ReaderEntityFactory::createReaderFromFile($path);
            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                if($sheet->getIndex() === 0) {
                    $this->calculateRow($sheet, $this->processId);
                    $this->readSheet($sheet, $this->processId);
                    break;
                }
            }

            $reader->close();

            // delete file
            unlink($path);

        } catch (Exception $e) {
			$this->updateProcess2($this->processId, $this->loop);
            echo $e->getMessage(); 
			
        }
    }

    private function calculateRow($sheet, $processId)
    {
        $totalRow = 0;
        foreach($sheet->getRowIterator() as $i => $row) {
            $totalRow += 1;
        }

        $process = Process::find($processId);
        $process->total = $totalRow;
        $process->save();
    }
	
	private function readSheet2($sheet, $processId)
    {
        foreach ($sheet->getRowIterator() as $i => $row)
		{

            if($i == 1) {
                continue;
            }
			
			$this->updateProcess($processId, $i);
			$this->loop = $i;
            //mcu id
            $r = $row->toArray();

            $date = is_string($r[13])?date("Ymd", strtotime($r[13])):$r[13]->format('Ymd');
            $mcuId = $date.str_pad(str_replace(" ","", $r[11]), 4, 0, 0) . str_pad(str_replace(" ","", $r[0]), 8, 0, 0);
			//$i230 = isset($r[230])?$r[230]:'';
			$i230 = $r[230];
			//echo $mcuId.'=='.$i230.'<br>';
			print_r($r);
		}
	}


    private function readSheet($sheet, $processId)
    {
        foreach ($sheet->getRowIterator() as $i => $row)
		{

            if($i == 1) {
                continue;
            }

            $this->updateProcess($processId, $i);
			$this->loop = $i;

            //mcu id
            $r = $row->toArray();

            $date = is_string($r[13])?date("Ymd", strtotime($r[13])):$r[13]->format('Ymd');
            $mcuId = $date.str_pad(str_replace(" ","", $r[11]), 4, 0, 0) . str_pad(str_replace(" ","", $r[0]), 8, 0, 0);
			
            //Medical Check Up
			//echo $r[13];
			//$r2 = array();
			//id mcu
			// id project
			// tgl input
			$i230 = isset($r[230])?$r[230]:'';
			$i231 = isset($r[231])?$r[231]:'';
            Mcu::updateOrCreate(
                [
                    'id'    => $mcuId
                ],
                [
                    'no_nip'        => $r[1],
                    'no_paper'      => $r[2],
                    'tgl_input'     => $this->setAsDate($r[13]),
                    'nama_pasien'   => $r[3],
                    'tgl_lahir'     => $this->setAsDate($r[4]),
                    'jenis_kelamin' => $r[5]=='PEREMPUAN'?'P':'L',
                    'bagian'        => $r[6],
                    'paket_mcu'     => $r[12],
                    'tgl_kerja'     => $this->setAsDate($r[8]),
                    'email'         => $r[9],
                    'telepon'       => $r[10],
                    'client'        => $r[7],
                    'vendor_customer_id' => $r[11],
					'catatan'		 => $i230,
					'saran'			 => $i231,
			        'published'      => 'N',
					'mcu_id_encript' => md5($mcuId).$r[0],
					'process_id' => $processId
                ]
            );
			
            for($g=14; $g<=231; $g++)
			{
				$r[$g] = isset($r[$g])?$r[$g]:' ';
			}
			
			//Riwayat
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
                    'olahraga'                      => $this->setYN($r[20]),
                    'frekuensi_per_minggu'          => $this->setInteger($r[21]),
                    'merokok'                       => $this->setYN($r[22]),
                    'rokok_bungkus_per_hari'        => $this->setInteger($r[23]),
                    'kopi'                          => $this->setYN($r[24]),
                    'kopi_gelas_per_hari'           => $this->setInteger($r[25]),
                    'alkohol'                       => $this->setYN($r[26]),
                    'alkohol_sebanyak'              => $r[27],
                    'lama_tidur_per_hari'           => $this->setInteger($r[28]),
                    'pernah_kecelakaan_kerja'       => $this->setYN($r[29]),
                    'tahun_kecelakaan_kerja'        => $r[30],
                    'tempat_kerja_berbahaya'        => $this->setYN($r[31]),
                    'pernah_rawat_inap'             => $this->setYN($r[32]),
                    'hari_lama_rawat_inap'          => $this->setInteger($r[33]),
                    'rawat_inap_penyakit'           => $r[34],
					'process_id' => $processId
                ]
				
            );
			//array_push($r2, 14,15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34);
            // Umum
            Umum::updateOrCreate(
                [
                    'mcu_id'        => $mcuId
                ],
                [
                    'nadi'          => $this->setInteger($r[35]),
                    'sistolik'      => $this->setInteger($r[36]),
                    'diastolik'     => $this->setInteger($r[37]),
                    'respirasi'     => $this->setInteger($r[38]),
                    'suhu'          => $this->setInteger($r[39]),
					'process_id' => $processId
                ]
            );
			//array_push($r2, 35, 36, 37, 38, 39);

            // Antrovisus
            Antrovisus::updateOrCreate(
                [
                    'mcu_id'        => $mcuId
                ],
                [
                    'berat_badan'   => $this->setInteger($r[41]),
                    'tinggi_badan'  => $this->setInteger($r[40]),
                    'bmi'           => $this->setDouble($r[42]),
                    'visus_kanan'   => $r[43],
                    'visus_kiri'    => $r[44],
                    'rekomendasi_kacamatan' => $this->setYN($r[45]),
                    'spheris_kanan' => $r[46],
                    'cylinder_kanan'=> $r[47],
                    'axis_kanan'    => $r[48],
                    'addition_kanan'=> $r[49],
                    'spheris_kiri'  => $r[50],
                    'cylinder_kiri' => $r[51],
                    'axis_kiri'     => $r[52],
                    'addition_kiri' => $r[53],
                    'pupil_distance'=> $r[54],
					'process_id' => $processId
                ]
            );
			
			//array_push($r2, 41, 40, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54);

            //$periksa = array();
            //$cek_periksa = array();
            // Fisik
			//array_push($periksa,range(56,67));
            if($r[55] == 'DIPERIKSA') { // ????????????????
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
                        //'mulut'         => $r[62], kabalik
                        //'gigi'          => $r[63],
						'gigi'           => $r[62],
                        'mulut'          => $r[63],
						'dada'          => $r[64],
                        'abdomen'       => $r[65],
                        'extremitas'    => $r[66],
                        'anogenital'    => $r[67],
						'process_id' => $processId
                    ]
                );

				//array_push($cek_periksa,range(56,67));
				//array_push($r2, range(56,67));
            }
			else
			{
				for($i=56; $i<=67; $i++)
				{
					unset($r[$i]);
				}
			}

            // Hematologi
			//array_push($periksa,range(69,85));
            if($r[68] == 'DIPERIKSA') {
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
                        'golongan_darah_rh'  => $r[85],
						'process_id' => $processId
                        ]
                );
				//array_push($cek_periksa,range(69,85));
				//array_push($r2, range(69, 85));
            }
			else
			{
				for($i=69; $i<=85; $i++)
				{
					unset($r[$i]);
				}
			}
			
            // Kimia
			//array_push($periksa,range(86,112));
            if($r[68] == 'DIPERIKSA') {
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
						//--
                        'asam_urat'         => $r[93],
						
                        'bilirubin_total'   => $r[94],
						
                        'bilirubin_direk'   => $r[95],
						
                        'bilirubin_indirek' => $r[96],
                        'sgot'              => $this->setInteger($r[97]),
                        'sgpt'              => $this->setInteger($r[98]),
                        'protein'           => $r[99],
						//
                        'albumin'           => $r[100],
                        'alkaline_fosfatase'=> $r[101],
                        'choline_esterase'  => $r[102],
                        'gamma_gt'          => $r[103],
                        'trigliserida'      => $r[104],
                        'kolesterol_total'  => $r[105],
                        'hdl'               => $r[106],
                        'ldl_direk'         => $r[107],
                        'ldl_indirek'       => $r[108],
                        'ck'                => $r[109],
                        'ckmb'              => $r[110],
                        'spuktum_bta1'      => $r[111],
                        'spuktum_bta2'      => $r[112],
                        'spuktum_bta3'      => $r[113],
						'process_id' => $processId
                    ]
                );

				//array_push($cek_periksa,range(86,112));
				//array_push($r2, range(86, 112));
            }
			else
			{
				for($i=86; $i<=113; $i++)
				{
					unset($r[$i]);
				}
			}
			
            // Serologi

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
                    'troponin_i'                => $r[135],
					'process_id' => $processId
                ]
            );
			//array_push($r2, range(113, 134));
			
            // Urin
			//array_push($periksa,range(136,155));
			 
            if($r[136] == 'DIPERIKSA') {
                Urin::updateOrCreate(
                    [
                        'mcu_id'            => $mcuId
                    ],
                    [
                        'warna_urin'        => $r[137],
                        'kejernihan'        => $r[138],
                        'berat_jenis'       => $this->setDouble($r[139]),
                        'ph'                => $this->setDouble($r[140]),
						
                        'protein_urin'      => $r[141],
                        'reduksi'           => $r[142],
						
                        'keton'             => $r[143],
                        'bilirubin'         => $r[144],
                        'urobilinogen'      => $this->setDouble($r[145]),
						
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
						'process_id' => $processId
                        ]
                );
				//array_push($cek_periksa,range(136,155));
				//array_push($r2, range(136, 155));
            }
			else
			{
				for($i=137; $i<=156; $i++)
				{
					unset($r[$i]);
				}
			}

            // Drug Screening
			//array_push($periksa,array(157)); 

            if($r[157] == 'DIPERIKSA') { //???????? ala
                DrugScreening::updateOrCreate(
                    [
                        'mcu_id'                    => $mcuId
                    ],
                    [
                        'kesimpulan_drug_screening' => $r[158],
						'process_id' => $processId
                    ]
                 );

				 //array_push($cek_periksa,array(157));
				 //array_push($r2, 157);
            }
			else
			{
				
					unset($r[158]);
				
			}

            

            // Feses Lengkap
			//array_push($periksa,range(159,175));

            if($r[159] == 'DIPERIKSA') {
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
                        'lain_lain'             => $r[176],
						'process_id' => $processId
                    ]
                );
				 //array_push($cek_periksa,range(159,175));
				 //array_push($r2, range(159,175));
            }
			else
			{
				
				for($i=160; $i<=176; $i++)
				{
					unset($r[$i]);
				}
				
			}


			// Rectal Swab
			//array_push($periksa,range(177,185));

            if($r[177] == 'DIPERIKSA') {
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
                        'kesimpulan_rectal_swab'=> $r[186],
						'process_id' => $processId
                    ]
                );
				//array_push($cek_periksa,range(177,185));
				//array_push($r2, range(177,185));
            }
			else
			{
				
				for($i=178; $i<=186; $i++)
				{
					unset($r[$i]);
				}
				
			}
            // ===== ala
            // Rontgen 
			//array_push($periksa,array(188));
            if($r[187] == 'DIPERIKSA') {

				$ttd_r = Ttd::where("jenis","rontgen")->orderBy('created_at', 'desc')->first();        

                Rontgen::updateOrCreate(
                    [
                        'mcu_id'        => $mcuId
                    ],
                    [
                        // index 187 jenis foto ala
						'kesan_rontgen' => $r[189],
						'process_id' => $processId,
						'ttd_id'=>($ttd_r) ?  $ttd_r->id : "",
                    ]
                );
				//array_push($cek_periksa,array(188));
				//array_push($r2, 188);
            }
			else
			{
				unset($r[189]);
				
			}
			
            // Ekg
			//array_push($periksa,range(190,191));
            if($r[190] == 'DIPERIKSA') {

				$ttd_e = Ttd::where("jenis","ekg")->orderBy('created_at', 'desc')->first(); 
       

                Ekg::updateOrCreate(
                    [
                        'mcu_id'        => $mcuId
                    ],
                    [
                        'hasil_ekg'     => $r[191],
                        'kesimpulan_ekg'=> $r[192],
						'process_id' => $processId,
						'ttd_id'     =>  ($ttd_e) ?  $ttd_e->id : null,
                    ]
                );
				//array_push($cek_periksa,range(190,191));
				//array_push($r2, 190, 191);
            }
			else
			{
				unset($r[191]);
				unset($r[192]);
				
			}
			
            //Trreadmill
			//array_push($periksa,range(193,211));
            if($r[193] == 'DIPERIKSA') {
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
                        'kesimpulan_treadmill'  => $r[212],
						'process_id' => $processId
                    ]
                );

				//array_push($cek_periksa,range(193,211));
				//array_push($r2, range(193,211));
            }
			else
			{
				
				for($i=194; $i<=212; $i++)
				{
					unset($r[$i]);
				}
				
			}
           
            //Adiometri
//            if($r[212] == 'DIPERIKSA') {
//                 Audiometri::updateOrCreate(
//                    [
//                        'mcu_id'                => $mcuId
//                    ],
//                    [
//                        'hasil_oae_ka'          => $r[215],
//                        'hasil_oae_ki'          => $r[214],
//                        'kesimpulan'            => $r[216]
//                    ]
//                 );
//            }

            //Adiometri
			//array_push($periksa,range(214,216));
           
            if($r[213] == 'DIPERIKSA') {
				
				$ttd_e = Ttd::where("jenis","ekg")->orderBy('created_at', 'desc')->first(); 
       
                Audiometri::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        
                        'hasil_audiometri'        => $r[214],
						'kesimpulan_audiometri'        => $r[215], 
						'process_id' => $processId,
						'ttd_id' => ($ttd_e) ?  $ttd_e->id : null,
                    ]
                );
				//array_push($cek_periksa,range(214,216));
				//array_push($r2, range(214,216));
            }
			else
			{
				
				for($i=214; $i<=215; $i++)
				{
					unset($r[$i]);
				}
				
			}
			 
			 //salmonela_typhi_h
            //Spirometri
			//array_push($periksa,range(218,221));
            if($r[218] == 'DIPERIKSA') {
				$ttd_sp = Ttd::where("jenis","spiro")->orderBy('created_at', 'desc')->first(); 
                Spirometri::updateOrCreate(
                    [
                        'mcu_id'                => $mcuId
                    ],
                    [
                        'fev'                   => $r[219],
                        'fvc'                   => $r[220],
                        'pef'                   => $r[221],
                        'kesimpulan_spirometri' => $r[222],
						'process_id' => $processId,
						'ttd_id' => ($ttd_sp) ?  $ttd_sp->id : null,
                    ]
                );
				//array_push($cek_periksa,range(218,221));
				//array_push($r2, range(218,221));
            }
			else
			{
				
				for($i=219; $i<=222; $i++)
				{
					unset($r[$i]);
				}
				
			}

            // Pap Smear
            PapSmear::updateOrCreate(
                [
                    'mcu_id'                    => $mcuId
                ],
                [
                    'tgl_terima'                => $this->setAsDate(trim($r[223])), 
                    'tgl_selesai'               => $this->setAsDate(trim($r[224])),
                    'bahan_pemeriksaan'         => $r[225],
                    'makroskopik'               => $r[226],
                    'mikroskopik'               => $r[227],
                    'kesimpulan_pap_smear'      => $r[228],
					'process_id' => $processId
                ]
            );
			//array_push($r2, range(222,227));
			
            // When mcu Id has diagnosis, delete first
            Mcu::find($mcuId)->diagnosis()->delete();
			

            // Set diagnosis for all field
			ImportMcu::rumus($r,$mcuId,$processId);
			
		}



    }

	
	public static function rumus($ar_excel,$mcuId,$processId)
    {
			//$ar_excel
			
			$valkeyRow = [];
			foreach($ar_excel as $k=>$val)
			{
				array_push($valkeyRow,$k);
			}

			$results = DB::table('rumuses')
				   ->select('rumuses.id','rumuses.nama', 'rumuses.logika_antar_param',DB::raw('count(rumuses.id) as jumlah'))
				   ->leftJoin('rumus_details', 'rumuses.id', '=', 'rumus_details.rumus_id')
				   ->where('rumuses.active','1')
				   ->groupBy('rumuses.id','rumuses.nama','rumuses.logika_antar_param')
				   ->get();
			
			foreach ($results as $row) {

				$rumus_id = $row->id;
				$jum = $row->jumlah;
                $logika  = $row->logika_antar_param;

				
				//$data_index = array();
				
				if($jum > 1)
				{
					
					$data_array_index_excel = array();
					$sq = DB::table('rumus_details')
						   ->select('parameters.index_of_colom_excel')
						   ->leftJoin('parameters', 'parameters.id', '=', 'rumus_details.parameter_id')
						   ->where('rumus_details.rumus_id', $rumus_id);
						   //$sq->whereIn('parameters.index_of_colom_excel', $valkeyRow);
						   $sq = $sq->where('rumus_details.active', 1)
						   ->orderBy('rumus_details.urutan_grup_paramater')
						   ->get();	
					$t = 1;
					foreach ($sq as $rw){
						
						$f = $rw->index_of_colom_excel;
						if(isset($ar_excel[$f]))
						{
							$data_array_index_excel[$t] = $ar_excel[$f];
						    $t++;	
						}
						
					}
					//echo "rumus_id-".$rumus_id."-mcuId-".$mcuId."-";
					if(count($data_array_index_excel)==$jum)
					{
						ImportMcu::setDiagnosis($mcuId, $data_array_index_excel, $rumus_id, $processId, $logika);
						
					}	
					
					
				}
				else
				{
					
					$data_array_index_excel = array();
					$sq = DB::table('rumus_details')
						   ->select('parameters.index_of_colom_excel')
						   ->leftJoin('parameters', 'parameters.id', '=', 'rumus_details.parameter_id')
						   ->where('rumus_details.rumus_id', $rumus_id);
						   //$sq->whereIn('parameters.index_of_colom_excel', $valkeyRow);
						   $sq = $sq->where('rumus_details.active', 1)
						   ->orderBy('rumus_details.urutan_grup_paramater')
						   ->get();
					
					$f = $sq[0]->index_of_colom_excel;
				   
					if(isset($ar_excel[$f]))
					{
						$data_array_index_excel[1] = $ar_excel[$f];
						ImportMcu::setDiagnosis($mcuId, $data_array_index_excel, $rumus_id, $processId, $logika);
					}
					
				
				}
				
				   //anti_hbs hbsags

			

			}
	}

	private function updateProcess2($processId, $i)
    {
        $process = Process::find($processId);
        $process->processed = $i;
        $process->status  = 'STOPPED';

        $process->save();
    }
	
    private function updateProcess($processId, $i)
    {
        $process = Process::find($processId);
        $process->processed = $i;
        $process->success = $i;

        if($process->total == $i) {
            $process->status = 'DONE';
        }

        $process->save();
    }

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

    private function setDouble($double)
    {
        $double = trim($double);

        if($double=='-');
        {
            $double = str_replace("-", "", $double);
        }

        


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

 
	public static function setDiagnosis($mcuId, $data_array, $rumus_id, $processId, $logika)
	{

			$ar_nilai = $data_array;
			
			$ar1= array();
			
			$ar3= array();
            
			$results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus_id)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->groupBy('a.baris_kondisi_ke')
					->get();
					

		    if ($results->count() > 0) {
				$a=1;
				foreach ($results as $row) {

					$ck = ImportMcu::cek_contain_operator($rumus_id,$row->baris_kondisi_ke); 
					if($ck=="contain")
					{
						ImportMcu::composit_kondisi($mcuId,$ck,$row->baris_kondisi_ke,$rumus_id,$ar_nilai, $processId);
					   
					}	
					else
					{  
									$results2 = DB::table('formula_details as a')
									->select('b.id',
											  'b.rumus_id',
											  'd.nama AS nama_rumus',
											  'b.nama_kolom',
											  'a.formula_id',
											  'a.nilai_kolom',
											  'a.ket_or_satuan',
											  'a.jenis_kolom_atau_operator',
											  'b.jenis_kolom',
											  'b.urutan',
											  'a.type_inputan_nilai_kolom',
											  'a.id',
											  'c.recommendation',
											  'c.deleted',
											  'c.id as recommendation_id',
											  'a.baris_kondisi_ke')
									->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
									->leftJoin('recommendations as c', 'a.id', '=', 'c.formula_detail_id')
									->leftJoin('rumuses as d', 'b.rumus_id', '=', 'd.id')
									->where('b.rumus_id', $rumus_id)
									->where('a.baris_kondisi_ke', $row->baris_kondisi_ke)
									->where('a.deleted', '0')
									//->where('c.deleted', '0')
									//->where('c.active', '1')
									->orderBy('b.urutan')
									->get();
									$cekRumusPerkondisi = true;
									$ar2 = array();
									$ar_kesimpulan = array();
									$i=1;
									foreach ($results2 as $r) {
										$n_cek  = false;
										if($r->jenis_kolom != "kesimpulan")
										{
											
											$nilaikolom  = null;
											//pengecualian
											/*if( strtolower($r->nama_kolom) == "hba1c" )
											{
												//Hba1c
												if($r->ket_or_satuan == "%")
												{
													$nlk = $r->nilai_kolom.''.$r->ket_or_satuan;
													//$nk = str_replace(",".",",$nlk);
													$nk = str_replace(",",".",$nlk);
													$nilaikolom  =  floatval($nk) / 100.00;
													//echo 'A'.$nilaikolom;
												}
												else
												{
													$nk = str_replace(",",".",$r->nilai_kolom);
													$nilaikolom  =  floatval($nk) / 100.00;
													//echo 'B'.$nilaikolom;
												}

												


											}
											else
											{
												$nilaikolom = $r->nilai_kolom;
											}
											*/
											    $nilaikolom = $r->nilai_kolom;
											
											
												$n_cek  = ImportMcu::cek_kodisi($nilaikolom,
																				$ar_nilai[$i],
																				$r->jenis_kolom_atau_operator,
																				$r->ket_or_satuan,
																				$r->type_inputan_nilai_kolom,
																				$r->nama_kolom
																				); 


												$ar2[$i]['nilai'] = $n_cek;
												$ar2[$i]['nilai_kolom'] = $r->nilai_kolom;
												$ar2[$i]['nama_kolom'] = $r->nama_kolom;

										}
										else if($r->jenis_kolom == "kesimpulan")
										{

											
											
											$ar_kesimpulan['kesimpulan'] = $r->nilai_kolom;
											$ar_kesimpulan['recommendation_id'] = $r->recommendation_id;
											$ar_kesimpulan['recommendation_del'] = $r->deleted;
											
											
											
										}
										
										//kesimpulan

										$i++;
									} 
									
									//disini
                                    if($logika == 'or')
                                    {
                                        $search = true;
                                        $found = false;
                                        foreach($ar2 as $v) {
                                           if ($v['nilai'] == $search) {
                                               $found = true;
                                           }
                                        }
                                        
                                        //echo $rumus_id
                                        
                                        if($found==true)
                                        {
                                             $recom_id = $ar_kesimpulan['recommendation_id'];
                                             if ($recom_id !="" or $recom_id != null )
                                             {
                                                Diagnosis::updateOrCreate(
                                                    [
                                                        'mcu_id'    => $mcuId,
                                                        'recommendation_id'  => $ar_kesimpulan['recommendation_id'],
                                                        'deleted' => $ar_kesimpulan['recommendation_del'],
                                                    ], 
                                                    [
                                                        'mcu_id' => $mcuId,
                                                        'recommendation_id' => $ar_kesimpulan['recommendation_id'],// ($r->recommendation_id)? $r->recommendation_id : "1",
                                                        'deleted' => $ar_kesimpulan['recommendation_del'], //($r->deleted)? $r->deleted : 0, 
                                                        'process_id' => $processId
                                                    ]
                                                ); 
                                             }
                                                
                                        } 
                                    }
                                    else
                                    {
								
    									$search = false;
    									$found = true;
    									foreach($ar2 as $v) {
    									   if ($v['nilai'] == $search) {
    										  $found = false;
    									   }
    									}
    									
    									//echo $rumus_id
    									
    									if($found==true)
    									{
    										 $recom_id = $ar_kesimpulan['recommendation_id'];
    										 if ($recom_id !="" or $recom_id != null )
    										 {
    											Diagnosis::updateOrCreate(
    												[
    													'mcu_id'    => $mcuId,
    													'recommendation_id'  => $ar_kesimpulan['recommendation_id'],
    													'deleted' => $ar_kesimpulan['recommendation_del'],
    												], 
    												[
    													'mcu_id' => $mcuId,
    													'recommendation_id' => $ar_kesimpulan['recommendation_id'],// ($r->recommendation_id)? $r->recommendation_id : "1",
    													'deleted' => $ar_kesimpulan['recommendation_del'], //($r->deleted)? $r->deleted : 0, 
    													'process_id' => $processId
    												]
    											); 
    										 }
    											
    									} 
                                    }
									
			
					
					}

					//$ar3[$a] = $ar2;

				 $a++;
				}

				//kesimpulan
			    

			} 


	}
	
	public static function composit_kondisi($mcuId,$op,$baris_kondisi_ke,$rumus_id,$ar_nilai, $processId){
					
					 $q = DB::table('formula_details as a')
								->select('b.id',
								  'b.rumus_id',
								  'd.nama AS nama_rumus',
								  'b.nama_kolom',
								  'a.formula_id',
								  'a.nilai_kolom',
								  'a.ket_or_satuan',
								  'a.jenis_kolom_atau_operator',
								  'b.jenis_kolom',
								  'b.urutan',
								  'a.type_inputan_nilai_kolom',
								  'a.id',
								  'c.recommendation',
								  'c.deleted',
								  'c.note',
								  'c.id as recommendation_id',
								  'a.baris_kondisi_ke')
						->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
						->leftJoin('recommendations as c', 'a.id', '=', 'c.formula_detail_id')
						->leftJoin('rumuses as d', 'b.rumus_id', '=', 'd.id')
						->where('b.rumus_id', $rumus_id)
						->where('a.baris_kondisi_ke', $baris_kondisi_ke)
						->where('a.jenis_kolom_atau_operator', 'hasil')
						->where('a.deleted', '0')
						//->where('c.deleted', '0')
						->orderBy('b.urutan')
						->get();
						
				$j = 1;
				$ad_ar = array();
				foreach($q as $row)
				{
					if($row->jenis_kolom == "kesimpulan")
					{
						
						$nilaikolom = $row->note;
						$recom_id = $row->recommendation_id;
						$del = $row->deleted;
						$ad_ar[$j] = [
										'mcu_id' => $mcuId,
										'recommendation_id' => $recom_id,
										'deleted' => $del,
										'note' => 'contain',
										'nilaikolom' => str_replace(' ','',$nilaikolom)
									];
						$j++;
							
					}
					
				}	
				
				
				$ar_ni = $ar_nilai[1];

				$nilai_input = strtolower(trim($ar_ni));
				$kata_find = $nilai_input;
				$kata_find = str_replace(' ','',$kata_find);
				$kata_find = str_replace('+','',$kata_find);
				$s = explode(';',$kata_find);

				for($i=0; $i < count($s); $i++)
				{
					
					foreach($ad_ar as $r){
						
						$ts = trim(strtolower(str_replace(';','',$r['nilaikolom'])));
						$ts = trim(strtolower(str_replace('+','',$ts)));
						$t =  strtolower($s[$i]);
						if($ts == $t){
							
							//diagnosis 
							Diagnosis::updateOrCreate(
									[
										'mcu_id' => trim(str_replace(' ','',$r['mcu_id'])),
										'recommendation_id' => trim(str_replace(' ','',$r['recommendation_id'])),
										'deleted' => trim(str_replace(' ','',$r['deleted'])),
										'note' =>  trim(str_replace(' ','',$r['note'])),
										'process_id' => $processId
										
									]
							);
							
						} 
						
					}
					
						
				}	
			 
		
	}

	public static function cek_kodisi($nilaikolom,$nilai_input,$jenis_kolom_atau_operator,$satuan,$type_input_nilai,$nama_kolom)
	{

		    $nilai_input = strtolower(trim($nilai_input));
		    $nilaikolom =strtolower(trim($nilaikolom));
		   

			$oper = $jenis_kolom_atau_operator;
			$value_kolom      = $nilaikolom; // ini nilai rumus
			


			if($satuan != "" or $satuan != null)
			{
				 $s=strtolower($satuan);
				 //$sk = explode($s,$value_kolom);
				 //$value_kolom = trim($sk[0]);

				 $sk2 = explode($s,$nilai_input);
				 $nilai_input = trim($sk2[0]);

				 //echo $nilai_input; echo '-'; echo $value_kolom;


			}
			
			
			$e = false;
			switch($oper) {

				case '<':
					
					if($nilai_input == ""){
					   break;
					}
					
				    $nilai_input = str_replace(" ","",$nilai_input);
					$e =  ( ImportMcu::converttonumber($nilai_input) < ImportMcu::converttonumber($value_kolom));
					break;
				case '<=':
					if($nilai_input == ""){
					   break;
					}
				    $nilai_input = str_replace(" ","",$nilai_input);
					$e =  ( ImportMcu::converttonumber($nilai_input) <= ImportMcu::converttonumber($value_kolom));
					break;
				case '>':
				    if($nilai_input == ""){
					   break;
					}
				    $nilai_input = str_replace(" ","",$nilai_input);
					$e = ( ImportMcu::converttonumber($nilai_input) > ImportMcu::converttonumber($value_kolom));
					//echo ImportMcu::converttonumber($nilai_input); echo '-'; echo ImportMcu::converttonumber($value_kolom);
					break;
				case '>=':
				    if($nilai_input == ""){
					   break;
					}
				    $nilai_input = str_replace(" ","",$nilai_input);
					$e = ( ImportMcu::converttonumber($nilai_input) >= ImportMcu::converttonumber($value_kolom));
					//echo ImportMcu::converttonumber($nilai_input)." >=". ImportMcu::converttonumber($value_kolom)."+";
					break;
				case '==':
					
					if(strtolower(trim($nama_kolom)) == "anti hbs" )
					{
								if($nilai_input == $value_kolom){
									$e = true;
									//echo $nilai_input."kap";
								}
								else {
									$e = false;
								}
					}
					else
					{
						   if($nilai_input == ""){
							   break;
						   }
					
							$nilai_input = str_replace(" ","",$nilai_input);
							$nilai_input =str_replace("+","",$nilai_input);
							$nilai_input =str_replace(";","",$nilai_input);
							
							
							$value_kolom = str_replace(" ","",$value_kolom);
							$value_kolom =str_replace("+","",$value_kolom);
							$value_kolom =str_replace(";","",$value_kolom);
					
							if ( is_numeric($nilai_input) ) {
								$e = ( ImportMcu::converttonumber($nilai_input) == ImportMcu::converttonumber($value_kolom));
							} else {
								
								if($nilai_input == $value_kolom){
									$e = true;
									//echo $nilai_input."kap";
								}
								else {
									$e = false;
								}
								
							}

					}
					
					break;
				case '<>':
				    if($nilai_input == ""){
					   break;
					}
					 $nilai_input = str_replace(" ","",$nilai_input);
					 $nilai_input =str_replace("+","",$nilai_input);
					 $nilai_input =str_replace(";","",$nilai_input);
					 
					 $value_kolom = str_replace(" ","",$value_kolom);
					 $value_kolom =str_replace("+","",$value_kolom);
					 $value_kolom =str_replace(";","",$value_kolom);
					
					 //$e = ( ImportMcu::converttonumber($nilai_input) <> ImportMcu::converttonumber($value_kolom));
					 //echo ImportMcu::converttonumber($nilai_input)."<>". ImportMcu::converttonumber($value_kolom)."+";
					 if ( is_numeric($nilai_input) ) {
						$e = ( ImportMcu::converttonumber($nilai_input) != ImportMcu::converttonumber($value_kolom));
					} else {
						
						if($nilai_input != $value_kolom){
							$e = true;
							//echo '<>';
							//echo $nilai_input."kap";
						}
						else {
							$e = false;
						}
						
					}

					break;
				case 'enum':
				      if($nilai_input == ""){
						   break;
					  }
						
						$value_kolom =str_replace("+","",$value_kolom);
					    $value_kolom =str_replace(";","",$value_kolom);
						
						$nilai_input =str_replace("+","",$nilai_input);
					    $nilai_input =str_replace(";","",$nilai_input);
						
						
						$st = str_replace(" ","",$value_kolom);
						$st = str_replace(",",".",$st);
						$st = explode("#",$st);
						$val = str_replace(",",".",$nilai_input);
						$val = str_replace(" ","",$val);
						if (in_array($val, $st))
						{
						  $e = true;
						}
					break;
				case 'not enum':
				        if($nilai_input == ""){
						   break;
						}
						$value_kolom =str_replace("+","",$value_kolom);
					    $value_kolom =str_replace(";","",$value_kolom);
						
						$nilai_input =str_replace("+","",$nilai_input);
					    $nilai_input =str_replace(";","",$nilai_input);
						
						$st = str_replace(" ","",$value_kolom);
						$st = str_replace(",",".",$st);
						$st = explode("#",$st);
						$val = str_replace(",",".",$nilai_input);
						$val = str_replace(" ","",$val);
						if (in_array($val, $st))
						{
						   $e = false;
						   //echo 'false';
						}
						else
						{
							$e = true;
							//echo 'true';
						}
					break;
				case 'not range':
					   if($nilai_input == ""){
							break;
						}
						
						if (fmod($nilai_input, 1) !== 0.0) { //is desimal
						  
							//$nilai_input =  ImportMcu::converttonumber($nilai_input);
							$nilai_input =  $nilai_input;
							
							$st = explode("-",$value_kolom);
							$batas_bawah = str_replace(" ","",$st[0]);
							$clean2 = preg_replace("/[^0-9]/", "",$batas_bawah);
							//$batas_bawah =  ImportMcu::converttonumber($clean2);
							$batas_bawah =  $clean2;


							$batas_atas  = str_replace(" ","",$st[1]);
							$clean = preg_replace("/[^0-9]/", "",$batas_atas);
							//$batas_atas =  ImportMcu::converttonumber($clean);
							$batas_atas =  $clean;
							
							if ( ($nilai_input > $batas_atas) OR ($nilai_input < $batas_bawah ) )
							{
								 $e = true;
							}	
						
						} 
						else
						{
								$st = explode("-",$value_kolom);
							    $batas_bawah = str_replace(" ","",$st[0]);
								$clean2 = preg_replace("/[^0-9]/", "",$batas_bawah);
								$batas_bawah =  $clean2;


							    $batas_atas  = str_replace(" ","",$st[1]);
								$clean = preg_replace("/[^0-9]/", "",$batas_atas);
								$batas_atas =  $clean;

								$nilai_input  = str_replace(" ","",$nilai_input);
								$nilai_input = preg_replace("/[^0-9]/", "",$nilai_input);

								$number = range($batas_bawah,$batas_atas);
								if(in_array($nilai_input, $number))
								{
								  $e = false;

								}
								else
								{
								  $e = true;
								}
							
						}
						

							    

							  break;
				case 'range':
						if($nilai_input == ""){
						   break;
						}
						
						if (fmod($nilai_input, 1) !== 0.0) { //is desimal
						  
							//$nilai_input =  ImportMcu::converttonumber($nilai_input);
							$nilai_input =  $nilai_input;
							
							$st = explode("-",$value_kolom);
							$batas_bawah = str_replace(" ","",$st[0]);
							$clean2 = preg_replace("/[^0-9]/", "",$batas_bawah);
							//$batas_bawah =  ImportMcu::converttonumber($clean2);
							$batas_bawah =  $clean2;


							$batas_atas  = str_replace(" ","",$st[1]);
							$clean = preg_replace("/[^0-9]/", "",$batas_atas);
							//$batas_atas =  ImportMcu::converttonumber($clean);
							$batas_atas =  $clean;
							
							if ( ($nilai_input <= $batas_atas) AND ($nilai_input >= $batas_bawah ) )
							{
								 $e = true;
							}	
						
						} 
						else
						{
							
							$st = explode("-",$value_kolom);
							$batas_bawah = str_replace(" ","",$st[0]);
							$clean2 = preg_replace("/[^0-9]/", "",$batas_bawah);
							$batas_bawah =  $clean2;


							$batas_atas  = str_replace(" ","",$st[1]);
							$clean = preg_replace("/[^0-9]/", "",$batas_atas);
							$batas_atas =  $clean;

							$nilai_input  = str_replace(" ","",$nilai_input);
							$nilai_input = preg_replace("/[^0-9]/", "",$nilai_input);
							//echo 'kaprok';
							$number = range($batas_bawah,$batas_atas);
							if(in_array($nilai_input, $number))
							{
							  $e = true;
							  //echo 'kaprok2';
							}
							
						}
												
						
						
					break;
                case 'intext':
				     if($nilai_input == ""){
					   break;
					 }
                     if(stripos($nilai_input,$nilaikolom) !== false)
					 {
						 $e = true;
					 }
					 else
					 {
						  
						 $e = false;
					 }
                    break;
                 case 'not intext':
					   if($nilai_input == ""){
					    break;
					   }
                       if(stripos($nilai_input,$nilaikolom) !== false)
					   {
						  $e = false;
					  }
					  else
					  {
						  $e = true;
					  }
                     break;
				case 'between':
                     
					  if($nilai_input == ""){
						  $e =  false;
					  }
					  else
					  {
						  $nilai_input = str_replace(" ","",$nilai_input);
						  $nilai_input  = ImportMcu::converttodesimal($nilai_input);
						  $st = explode("-",$value_kolom);
						  $batas_bawah = str_replace(" ","",$st[0]);
						  $batas_bawah =  ImportMcu::converttonumber($batas_bawah);
						  $batas_atas  = str_replace(" ","",$st[1]);
						  $batas_atas =  ImportMcu::converttonumber($batas_atas);
						  
						  if( ($nilai_input >= $batas_bawah)  and  ($nilai_input <= $batas_atas) ) 
						  {
							  $e = true;
						  }
						  else {
							  $e = false;
						  }	
					  }
					
					break;
				case 'not between':
                     if($nilai_input == "")
					 {
						  $e =  false;
					 }
					 else
					 {
						  $nilai_input = str_replace(" ","",$nilai_input);
						  $nilai_input  = ImportMcu::converttodesimal($nilai_input);
						  $st = explode("-",$value_kolom);
						  $batas_bawah = str_replace(" ","",$st[0]);
						  $batas_bawah =  ImportMcu::converttonumber($batas_bawah);
						  $batas_atas  = str_replace(" ","",$st[1]);
						  $batas_atas =  ImportMcu::converttonumber($batas_atas);
						   
						  if( ($nilai_input > $batas_bawah)  and  ($nilai_input < $batas_atas) ) 
						  {
							  $e = false;
						  }
						  else 
						  {
							  $e = true;
						  }	
						  
					  }
                    break; 
				 case 'contain2':
				     if($nilai_input == ""){
					   break;
					 }
				     
					$s = explode(',',strtolower($nilaikolom));
					$tru = array();
					for($i=0; $i < count($s); $i++)
					{
					   
					   $kr = $s[$i];
					   if(stripos(strtolower($nilai_input),$kr) !== false)
					   {
						  $tru[$i] = 1;
					   }
					   else
					   {
						  $tru[$i] = 0;
					   }	
					}	
					
					if (in_array(1, $tru))
					{
					    $e = true;
					}
					else
					{
					   $e = false;
					}
					 
                    break;
				
			}

			return $e;
	}
	
	
	
	static function converttodesimal($double)
    {
        if(empty($double)) {
            return NULL;
        }

        if(is_string($double)) {
            return str_replace(",", ".", $double);
        }

        return $double;
    }
	
	static function converttonumber($val)
	{
        if($val=="")
        {
			return $val;
        }
		else
		{
			
			$val = str_replace(",",".",$val);
			return $val;
		}


	}
	static function cek_contain_operator($rumus,$baris_kondisi)
	{
		$results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus)
					->where('a.baris_kondisi_ke', $baris_kondisi)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->get()->toArray(); 
					
		
		return $results[0]->jenis_kolom_atau_operator;
					
	}
	
	static function cek_val_double($nama_kolom,$nilai_input)
	{
		
		$klm = array('bmi','hemoglobin','hematokrit','eritrosit','mcv','mch','mchc','gds','gdp','kreatinin','berat_jenis','ph','urobilinogen');
		
		if(in_array($nama_kolom,$klm))
		{
			return  str_replace(",",".",$nilai_input);
		}		
		
	}

}
