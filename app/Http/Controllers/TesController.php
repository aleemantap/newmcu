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

class TesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//SELECT  
//rumuses.id,rumuses.nama,rumus_details.parameter_id,parameters.index_of_colom_excel,parameters.field

//from rumuses
//left Join rumus_details on rumuses.id = rumus_details.rumus_id
//left join parameters on parameters.id =  rumus_details.parameter_id
//where rumuses.active = 1

//$rumuses = DB::table('rumuses')->select('rumuses.id as id','rumuses.nama as nama','parameters.index_of_colom_excel','parameters.field')
	//		->leftJoin('rumus_details', 'rumuses.id', '=', 'rumus_details.rumus_id')
		//	->leftJoin('parameters', 'parameters.id', '=', 'rumus_details.parameter_id')
			//->where('rumuses.active',1)->get()->toArray();


//select rumus_details.id,parameters.field,parameters.index_of_colom_excel, rumuses.id as rumusId, rumuses.nama,rumus_details.urutan_grup_paramater

//from rumus_details
//left join parameters on parameters.id = rumus_details.parameter_id
//left join rumuses on rumuses.id = rumus_details.rumus_id and rumuses.active=1

	
	
	 
	 public function hitungrumus($nilai_rumus, $oper, $val_dari_excel){
		 
		 switch($oper)
		 {
			 
			case "<>" : 
						if($nilai_rumus != $val_dari_excel)
						{	
							return true;
						}
						else
						{
							return false;
						}
							
							
					
			 break;
			 
			case "==" :
						if($nilai_rumus == $val_dari_excel)
						{	
							return true;
						}
						else
						{
							return false;
						}
			 break;
			
			default:
			return false;
		 }
	 }

	 public function indexxx2()
     {
		 	//$rumuses = DB::table('rumuses')->select('rumuses.id as id','rumuses.nama as nama')
			//->where('active',1)->get()->toArray();
			
			//$rumuses = DB::table('rumuses')->select('rumuses.id as id','rumuses.nama as nama','parameters.index_of_colom_excel','parameters.field')
			//->leftJoin('rumus_details', 'rumuses.id', '=', 'rumus_details.rumus_id')
			//->leftJoin('parameters', 'parameters.id', '=', 'rumus_details.parameter_id')
			//->where('rumuses.active',1)->get()->toArray();
			
			$rumuses = DB::table('rumus_details')
					->select(
					'rumus_details.id',
					'parameters.field',
					'parameters.index_of_colom_excel',
					'rumuses.id as rumusId', 
					'rumuses.nama',
					'rumus_details.urutan_grup_paramater')
					->leftJoin('parameters', 'parameters.id', '=', 'rumus_details.parameter_id')
					->leftJoin('rumuses', 'rumuses.id', '=', 'rumus_details.rumus_id')
					->where('rumuses.active',1)
					->where('rumus_details.active',1)
					->get()->toArray();
			
			$da = array();
			$ar_ak = array();
			foreach($rumuses as $rows){
				
				$results = DB::table('formula_details as a')
					 ->select('a.baris_kondisi_ke','b.jenis_kolom','a.jenis_kolom_atau_operator')
					 ->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					 ->where('b.rumus_id', $rows->id)
					 ->where('b.jenis_kolom', '<>', 'kesimpulan')
					 ->orderBy('a.baris_kondisi_ke')
					 ->get()->toArray();	
					 
					 $id = $rows->rumusId;
					 $field_excel = $rows->field;
					 $index_of_colom_excel = $rows->index_of_colom_excel;
					 $da3 = array();
						//$da1
					 $a=1;
					 foreach ($results as $row) {
						 
							
								$da2 = array();
								$da1 = array();
								$rumus_detail = DB::table('formula_details as a')
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
													  'a.id as formula_detail_id',
													  'c.recommendation',
													  'c.note',
													  'c.id as recommendation_id',
													  'c.deleted',
													  'f.id as icd10_id',
													  'f.name as icd_name',
													  'f.code as icd_code',
													  'e.id as work_health_id',
													  'e.name as wh_name',
													  'a.baris_kondisi_ke')
											->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
											->leftJoin('recommendations as c', 'a.id', '=', 'c.formula_detail_id')
											->leftJoin('rumuses as d', 'b.rumus_id', '=', 'd.id')
											->leftJoin('work_healths as e', 'e.id', '=', 'c.work_health_id')
											->leftJoin('icd10s as f', 'f.id', '=', 'c.icd10_id')
											->where('b.rumus_id', $id)
											//->where('c.deleted', 0)
											->where('a.baris_kondisi_ke', $row->baris_kondisi_ke)
											->orderBy('b.urutan')
											->get()->toArray();
											
											$f=1;
											foreach($rumus_detail as $r)
											{
													// $data =  array (
													  // 'rumus_id' =>  $r->rumus_id,
													  // 'formula_detail_id' => $r->formula_detail_id,
													  // 'formula_id' => $r->formula_id,
													  // 'nama_kolom' => $r->nama_kolom,
													  // 'nilai_kolom' => $r->nilai_kolom,
													  // 'ket_or_satuan' => $r->ket_or_satuan,
													  // 'jenis_kolom_atau_operator' => $r->jenis_kolom_atau_operator,
													  // 'recommendation_id' => $r->recommendation_id,
													  // 'recommendation' => $r->recommendation,
													  // 'note' => $r->note,
													  // 'baris_kondisi_ke' => $r->baris_kondisi_ke,
													  // 'wh_name' => $r->wh_name,
													  // 'work_health_id' => $r->work_health_id,
													  // 'icd_code' => $r->icd_code,
													  // 'icd10_id' => $r->icd10_id,
													  // 'icd_name' => $r->icd_name,
													  // 'deleted' => $r->deleted
													// );
													
													
													$data2 =  array (
													  'rumus_id' =>  $r->rumus_id,
													  'nama_rumus' =>  $r->nama_rumus,
													  'formula_detail_id' => $r->formula_detail_id,
													  'formula_id' => $r->formula_id,
													  'nama_kolom' => $r->nama_kolom,
													  'nilai_kolom' => $r->nilai_kolom,
													  'ket_or_satuan' => $r->ket_or_satuan,
													  'jenis_kolom_atau_operator' => $r->jenis_kolom_atau_operator,
													  'recommendation_id' => $r->recommendation_id,
													  'recommendation' => $r->recommendation,
													  'note' => $r->note,
													  'baris_kondisi_ke' => $r->baris_kondisi_ke,
													  'wh_name' => $r->wh_name,
													  'work_health_id' => $r->work_health_id,
													  'icd_code' => $r->icd_code,
													  'icd10_id' => $r->icd10_id,
													  'icd_name' => $r->icd_name,
													  'deleted' => $r->deleted,
													  'field_excel' => $field_excel,
													  'index_of_colom_excel' => $index_of_colom_excel,
													  'jenis_kolom' => $r->jenis_kolom
													
													);
													
													array_push($ar_ak,$data2);
												
												
												$da1[$f] = $data; 
												
												
											$f++;
											}
							//$da3[$row->baris_kondisi_ke] = ['baris_kondisi_ke'=>$row->baris_kondisi_ke ,'oper'=> $row->jenis_kolom_atau_operator, 'data'=>$da1, "kel"=> $this->cek_count_kolomkondisi_formula_tabel($id)]; 
							$da3[$a] = ['baris_kondisi_ke'=>$row->baris_kondisi_ke ,'oper'=> $row->jenis_kolom_atau_operator, 'data'=>$da1, "kel"=> $this->cek_count_kolomkondisi_formula_tabel($id)]; 
								
							$a++;
						
						 
						 
					 }
						
					
				array_push($da, array('rumusID'=>$rows->id, 'nama'=>$rows->nama,'data' => $da3 )); //, 'data'=>$da3[$row->baris_kondisi_ke])
				//$da['rumus_id'] = $row['id'];
					//print_r($row);
			}
			$tb = '<table border="1">';
			$tb .= '<tr>
						<td>NO</td>
						<td>ID Rumus</td>
						<td>Nama Rumus</td>
						<td>Baris Kondisi</td>
						<td>operator</td>
						<td>formula_id</td>
						<td>formula_detail_id</td>
						<td>nama kolom</td>
						<td>nila kolom</td>
						<td>ket_or_satuan</td>
						<td>recommendation_id</td>
						<td>recommendation</td>
						<td>note</td>
						<td>work_healths</td>
						<td>work_health_id</td>
						<td>icd10_id</td>
						<td>icd_name</td>
						<td>icd_code</td>
						<td>rekom deleted</td> 
						<td>field excel</td> 
						<td>index excel</td> 
						<td>jenis_kolom</td> 
						
						
					</tr>';
			$g = 1;
			foreach($ar_ak as $k)
			{
								 $tb .= '<tr>
										<td>'.$g.'</td>
										<td>'.$k["rumus_id"].'</td>
										<td>'.$k["nama_rumus"].'</td>
										<td>'.$k["baris_kondisi_ke"].'</td>
										<td>'.$k["jenis_kolom_atau_operator"].'</td>
										<td>'.$k["formula_id"].'</td>
										<td>'.$k["formula_detail_id"].'</td>
										<td>'.$k["nama_kolom"].'</td>
										<td>'.$k["nilai_kolom"].'</td>
										<td>'.$k["ket_or_satuan"].'</td>
										<td>'.$k["recommendation_id"].'</td>
										<td>'.$k["recommendation"].'</td>
										<td>'.$k["note"].'</td>
										<td>'.$k["wh_name"].'</td>
										<td>'.$k["work_health_id"].'</td>
										<td>'.$k["icd10_id"].'</td>
										<td>'.$k["icd_name"].'</td>
										<td>'.$k["icd_code"].'</td>
										<td>'.$k["deleted"].'</td>
										<td>'.$k["field_excel"].'</td>
										<td>'.$k["index_of_colom_excel"].'</td> 
										<td>'.$k["jenis_kolom"].'</td> 
									</tr>';
				$g++;
			}
			
			$tb .='</table>';
			echo $tb;
			
			
			/*
			$tb = '<table border="1">';
			$tb .= '<tr>
						<td>NO</td>
						<td>ID Rumus</td>
						<td>Nama Rumus</td>
						<td>Baris Kondisi</td>
						<td>operator</td>
						<td>formula_id</td>
						<td>formula_detail_id</td>
						<td>nama kolom</td>
						<td>nila kolom</td>
						<td>ket_or_satuan</td>
						<td>recommendation_id</td>
						<td>recommendation</td>
						<td>note</td>
						<td>work_healths</td>
						<td>work_health_id</td>
						<td>icd10_id</td>
						<td>icd_name</td>
						<td>icd_code</td>
						<td>rekom deleted</td> 
						
						
					</tr>';
			$g = 1;
			foreach($da as $r)
			{
				//echo '<tr><td>'.$row["nama"].'</td><td></td></tr>';
				//$tb .= '<tr><td>'.$row["rumusID"].'</td><td></td></tr>';
				//print_r($r['data'][$g]);
				
				$i=1;
				foreach($r['data'] as $d)
				{
								$s = 1;
								foreach($d['data'] as $k){
									$tb .= '<tr>
										<td>'.$g.'</td>
										<td>'.$r["rumusID"].'</td>
										<td>'.$r["nama"].'</td>
										<td>'.$d["baris_kondisi_ke"].'</td>
										<td>'.$d["oper"].'</td>
										<td>'.$k["formula_id"].'</td>
										<td>'.$k["formula_detail_id"].'</td>
										<td>'.$k["nama_kolom"].'</td>
										<td>'.$k["nilai_kolom"].'</td>
										<td>'.$k["ket_or_satuan"].'</td>
										<td>'.$k["recommendation_id"].'</td>
										<td>'.$k["recommendation"].'</td>
										<td>'.$k["note"].'</td>
										<td>'.$k["wh_name"].'</td>
										<td>'.$k["work_health_id"].'</td>
										<td>'.$k["icd10_id"].'</td>
										<td>'.$k["icd_name"].'</td>
										<td>'.$k["icd_code"].'</td>
										<td>'.$k["deleted"].'</td>
									
									</tr>';
								$s++;
								}
								
				$i++;
				}
			
				
				//print_r($row);
			$g++;
			}
			$tb .='</table>';
			echo $tb;
			*/
		 
	 }
	 
	
	
	public function cek_count_kolomkondisi_formula_tabel($rumus_id)
	{
		
		$xcv = DB::table('formulas as a')
							->select('a.id')
							->where('a.rumus_id',$rumus_id)
							->get();
		return count($xcv);
		
	}
	 
	 
	 public function indexxx()
     {
		
		$results = DB::table('rumuses')
				   ->select('rumuses.id','rumuses.nama', DB::raw('count(rumuses.id) as jumlah'))
				   ->leftJoin('rumus_details', 'rumuses.id', '=', 'rumus_details.rumus_id')
				   ->where('rumuses.active','1')
				   //->where('rumuses.id','72')
				   // ->orWhere('rumuses.id','28');
				   ->groupBy('rumuses.id','rumuses.nama')
				   ->get();
				   
	    echo "<pre>";
		var_dump($results);
		echo "</pre>";
	 }
	 
	 public function indexx()
     {		
			$mcuId = "20210802002800002603";
			$rumus_id =  42;//69;
			
			
			//$data_array[0] = "Caries Dentis +;Calculus +;Gangren Pulpa +;";  //kanan
			$data_array[0] = "81.2";  //kanan
			//$data_array[0] = "82.2";  //kanan
			//$data_array[1] =  " 20 /20 "; //kiri
			$ar_nilai = array();
			if(count($data_array) > 1)
			{
				//$ar_nilai[1] = $data_array[0];
				//$ar_nilai[2] = $data_array[1];
				$h = 0;
				$g = 1;
				for($n = 0; $n < count($data_array); $n++)
				{
					$ar_nilai[$g] = $data_array[$h];
				$h++;
				$g++;
				}
				//$this->index3($rumus_id,$ar_nilai,$mcuId);
				$this->index2($rumus_id,$ar_nilai,$mcuId);
			}
			else
			{
				$ar_nilai[1] = $data_array[0];
				$this->index2($rumus_id,$ar_nilai,$mcuId);
			}
			
			
		    //$ar_nilai = "Caries Dentis +;Gangren Pulpa +;";
			
			
			
			
			
		 
     }	 
	
    public function index3()
	{
		 $results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', 69)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					//->groupBy('a.baris_kondisi_ke')
					->get();
		 echo "<pre>";
		 
			var_dump($results);
			
		 echo "</pre>";
		 
		 echo count($results);
		 
		 /* foreach ($results as $row) 
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
						->orderBy('b.urutan')
						->get();
				
					
		 }	 */	
		
	}
	
	 
	 
    public function index2xa($rumus_id,$ar_nilai,$mcuId)
    {
        
		
	/* 	$xxx = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus_id)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					//->groupBy('a.baris_kondisi_ke')
					->get(); */
		//echo '<pre>';
		//	var_dump($xxx);
		//echo '</pre>'; 
		
			$ar1= array();
			$ar2= array();
			$ar3= array();
		
		/* $results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus_id)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->get();  */
		$results = DB::table('formula_details as a')
					//->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->select('a.baris_kondisi_ke')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus_id)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->groupBy('a.baris_kondisi_ke')
					->get(); 
		 echo '<pre>';
		//	var_dump($results);
		 echo '</pre>';  //die();
		 if ($results->count() > 0) {
				$a=1;
				foreach ($results as $row) {
                    //echo "-------a".$row->baris_kondisi_ke; 
					 $ck = $this->cek_contain_operator($rumus_id,$row->baris_kondisi_ke);  //cek is contain
					 if($ck=="contain")
					 //if($row->jenis_kolom_atau_operator == 'contain')
					 {
						//ambil fungsi perlakuanya beda
					    	$this->composit_kondisi($mcuId,$ck,$row->baris_kondisi_ke,$rumus_id,$ar_nilai);
						//echo $row->jenis_kolom_atau_operator;
						
					 }	
					 else
					 { 
				    
					
					 		
						//echo "asdsa";
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
						->orderBy('b.urutan')
						->get();
						  echo "waya";
						  echo '<pre>';
							var_dump($results2);
						  echo '</pre>'; 
						  //echo "-------a".$row->baris_kondisi_ke;
						  //die();
						//print_r(count($results2)); die();
						//$temp = 1;
						$i=1;
						foreach ($results2 as $r) {
							$n_cek  = false;
							if($r->jenis_kolom != "kesimpulan")
							{
								
								$nilaikolom  = null;
								//pengecualian
								if( strtolower($r->nama_kolom) == "hba1c" )
								{
									//Hba1c
									if($r->ket_or_satuan == "%")
									{
										$nlk = $r->nilai_kolom.''.$r->ket_or_satuan;
										//$nk = str_replace(",".",",$nlk);
										$nk = str_replace(",",".",$nlk);
										$nilaikolom  =  floatval($nk) / 100.00;
									}
									else
									{
										$nk = str_replace(",",".",$r->nilai_kolom);
										$nilaikolom  =  floatval($nk) / 100.00;
									}


								}
								else
								{
									$nilaikolom = $r->nilai_kolom;
								}
								
								
									//continue;
									//echo $ar_nilai[$i]."--".$r->nama_kolom."-".$row->baris_kondisi_ke; echo "<br>";
									$n_cek  = $this->cek_kodisi($nilaikolom,
																	$ar_nilai[$i],
																	$r->jenis_kolom_atau_operator,
																	$r->ket_or_satuan,
																	$r->type_inputan_nilai_kolom); 


									$ar2[$i]['nilai'] = $n_cek;
									$ar2[$i]['nilai_kolom'] = $r->nilai_kolom;
									$ar2[$i]['nama_kolom'] = $r->nama_kolom;
									echo "lll---".json_encode($n_cek)."-".$r->jenis_kolom_atau_operator;
								

							}
							else if($r->jenis_kolom == "kesimpulan")
							{

								//echo "lll---000000000";
								$ar2[$i]['kesimpulan'] = $r->nilai_kolom;
								$ar2[$i]['recommendation_id'] = $r->recommendation_id;
								$ar2[$i]['recommendation_del'] = $r->deleted;
								
								
							}

							$i++;
						} 
						
						
						//disini
					
					}

					$ar3[$a] = $ar2;

				 $a++;
				}

				//kesimpulan no contain rumus
				//echo count($ar3[1]);
				//print_r($ar3);
				
				if(count($ar3[1]) > 1)
				{	
					$batas_lop = count($ar3[1])-1; //batas lop nilai
					for($f=1; $f<=count($ar3);$f++)
					{
						$ar = array();
						for($h=1; $h<=$batas_lop; $h++)
						{
							if($ar3[$f][$h]['nilai']==true)
							{
								$ar[$h] = 1;
							}
							else
							{
								$ar[$h] = 0;
							}
						}
						//print_r($ar);
						if(!in_array(0,$ar))
						{
							//echo "kaprok";
							//$return = $ar3[$f][$batas_lop+1]['kesimpulan'];
							//$return = trim(strtolower($return));
							
							$recom_id = $ar3[$f][$batas_lop+1]['recommendation_id'];
							$del = $ar3[$f][$batas_lop+1]['recommendation_del'];
							
							//echo "ba-";
							//echo "\n\n";
							//if ($recom_id !="" or $recom_id != null or $return != 'normal' )
							  if ($recom_id !="" or $recom_id != null )
							 {
									//echo $del;
									//DB::table('diagnoses')->where('mcu_id', $mcuId)->where('recommendation_id', $recom_id)->delete();
									// Save to diagnosis
									echo "kaprok";
									 /* Diagnosis::updateOrCreate(
										 [
											 'mcu_id' => $mcuId,
											 'recommendation_id' => $recom_id,
											 'deleted' => $del
											
										 ]
									 );  */


							}  

						} 

					}

				}				
 
			}
		
		
    }
	
	public function composit_kondisi($mcuId,$op,$baris_kondisi_ke,$rumus_id,$ar_nilai){
					
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
			   // echo '<pre>';
				//	var_dump($q);
				//echo '</pre>';
		
				$i = 0;
				$ad_ar = array();
				foreach($q as $row)
				{
					//echo $row->jenis_kolom;
					if($row->jenis_kolom == "kesimpulan")
					{
						
						$nilaikolom = $row->note;
						$recom_id = $row->recommendation_id;
						$del = $row->deleted;
						$ad_ar[$i] = [
										'mcu_id' => $mcuId,
										'recommendation_id' => $recom_id,
										'deleted' => $del,
										'note' => 'contain',
										'nilaikolom' => str_replace(' ','',$nilaikolom)
									];
							
						
						
					}
					$i++;
				}	
				
				$ar_ni = $ar_nilai[1];
				//$ar_ni = $ar_nilai;

				$nilai_input = strtolower(trim($ar_ni));
				$kata_find = $nilai_input;
				$kata_find = str_replace(' ','',$kata_find);
				$s = explode('+;',$kata_find);

				for($i=0; $i < count($s); $i++)
				{
					
					foreach($ad_ar as $r){
						
						$ts = trim(strtolower(str_replace('+;','',$r['nilaikolom'])));
						$t =  strtolower($s[$i]);
						if($ts === $t){
							echo "ok";
							//diagnosis 
							/* Diagnosis::updateOrCreate(
									[
										'mcu_id' => trim(str_replace(' ','',$r['mcu_id'])),
										'recommendation_id' => trim(str_replace(' ','',$r['recommendation_id'])),
										'deleted' => trim(str_replace(' ','',$r['deleted'])),
										'note' =>  trim(str_replace(' ','',$r['note']))
										
									]
							); */
							
						} 
						
					}
					
						
				}	
			 
		
	}
	
	public function tes2()
    {
		
		
	}
	
	public  function cek_kodisi($nilaikolom,$nilai_input,$jenis_kolom_atau_operator,$satuan,$type_input_nilai)
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
					$nilai_input = str_replace(" ","",$nilai_input);
					$e =  ( ImportMcu::converttonumber($nilai_input) < ImportMcu::converttonumber($value_kolom));
					break;
				case '<=':
					$nilai_input = str_replace(" ","",$nilai_input);
					$e =  ( ImportMcu::converttonumber($nilai_input) <= ImportMcu::converttonumber($value_kolom));
					break;
				case '>':
					$nilai_input = str_replace(" ","",$nilai_input);
					$e = ( ImportMcu::converttonumber($nilai_input) > ImportMcu::converttonumber($value_kolom));
					//echo ImportMcu::converttonumber($nilai_input); echo '-'; echo ImportMcu::converttonumber($value_kolom);
					break;
				case '>=':
				    $nilai_input = str_replace(" ","",$nilai_input);
					$e = ( ImportMcu::converttonumber($nilai_input) >= ImportMcu::converttonumber($value_kolom));
					//echo ImportMcu::converttonumber($nilai_input)." >=". ImportMcu::converttonumber($value_kolom)."+";
					break;
				case '==':
					 //$nilai_input = str_replace(" ","",$nilai_input);
					 //$e = ( ImportMcu::converttonumber($nilai_input) == ImportMcu::converttonumber($value_kolom));
					 //echo ImportMcu::converttonumber($nilai_input)."-";
					   
					    $nilai_input = str_replace(" ","",$nilai_input);
					    $value_kolom = str_replace(" ","",$value_kolom);
						if ( is_numeric($nilai_input) ) {
							$e = ( ImportMcu::converttonumber($nilai_input) == ImportMcu::converttonumber($value_kolom));
						} else {
							 echo $nilai_input."---".$value_kolom;
							if($nilai_input === $value_kolom){
								$e = true;
								//echo $nilai_input."qwer";
							}
							else {
								$e = false;
								//echo $nilai_input."qwery";
							}
							
						}
					 

					break;
				case '<>':
				
					$nilai_input = str_replace(" ","",$nilai_input);
					$e = ( ImportMcu::converttonumber($nilai_input) <> ImportMcu::converttonumber($value_kolom));
					//echo ImportMcu::converttonumber($nilai_input)."<>". ImportMcu::converttonumber($value_kolom)."+";
                    //echo ImportMcu::converttonumber($nilai_input)."--";
					break;
				case 'enum':
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

							    $st = explode("-",$value_kolom);
							    $batas_bawah = str_replace(" ","",$st[0]);
								$clean2 = preg_replace("/[^0-9]/", "",$batas_bawah);
								$batas_bawah =  $clean2;


							    $batas_atas  = str_replace(" ","",$st[1]);
								$clean = preg_replace("/[^0-9]/", "",$batas_atas);
								$batas_atas =  $clean;

								$nilai_input  = str_replace(" ","",$nilai_input);
								$nilai_input = preg_replace("/[^0-9]/", "",$nilai_input);
                                echo $batas_bawah."=============".$batas_atas."==".$nilai_input;
								$number = range($batas_bawah,$batas_atas);
								if(in_array($nilai_input, $number))
								{
								  $e = false;

								}
								else
								{
								  $e = true;
								}

							  break;
				case 'range':

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
					break;
                case 'include':
                     $e = strpos($nilaikolom,$nilai_input) !== false ? true : false;
                    break;
                case 'not include':
                    $e = strpos($nilaikolom,$nilai_input) === false ? true : false;
                    break;
				/*case 'contain':
					$kalimat = str_replace(' ','',$nilaikolom);
					
					$kata_find = $nilai_input;
					$kata_find = str_replace(' ','',$kata_find);
					
					$s = explode('+;',$kata_find);
					$o = explode('+;',$kalimat);
					$aa = array_merge($o,$s);
				    $rr = array_unique($aa);
					
					if(count($o) == count($rr))
					{
						$e = true;
						
					}
					
					break;
				 case 'not contain':
					 $kalimat = str_replace(' ','',$nilaikolom);
					 $kata_find = $nilai_input;
					 $kata_find = str_replace(' ','',$kata_find);
					
					 $s = explode('+;',$kata_find);
					 $o = explode('+;',$kalimat);
					 $aa = array_merge($o,$s);
				     $rr = array_unique($aa);
					
					 if(count($o) !== count($rr))
					 {
						 $e = true;
					 }
					
					 break; */
			}

			return $e;
	}
	
	public function cek_contain_operator($rumus,$baris_kondisi)
	{
		$results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $rumus)
					->where('a.baris_kondisi_ke', $baris_kondisi)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->get(); 
					
		
		return $results[0]->jenis_kolom_atau_operator;
		//echo "<pre>";			
		//	var_dump($results);
		//echo "</pre>";			
	}
	
	public function tes3()
	{
		$results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','a.jenis_kolom_atau_operator','b.jenis_kolom')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', 17)
					->where('a.baris_kondisi_ke', 1)
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->get(); 
					
		echo "<pre>";			
			var_dump($results[0]->jenis_kolom_atau_operator);
		echo "</pre>";			
		
		echo $results[0]->jenis_kolom_atau_operator;
	    
	}
	
	public function index()
    {
       DB::table('pre_jenis_pemeriksaan_qc')->truncate();
	   DB::table('pre_jenis_pemeriksaan_qc')->insert([ 
			//[
			//'nama'	=> 'Registrasi',
			//],
			[
			'nama'	=> 'Antrovisus',
			],
			[
			'nama'	=> 'Dokter',
			],
			[
			'nama'	=> 'Sampling',
			],
			[
			'nama'	=> 'Urin',
			],
			[
			'nama'	=> 'Rontgen Thorax',
			],
			[
			'nama'	=> 'Rontgen Lumbal',
			],
			[
			'nama'	=> 'Return Form',
			],
			[
			'nama'	=> 'EKG',
			],
			[
			'nama'	=> 'Audiometri',
			
			],
			[
			'nama'	=> 'Spirometri',
			
			],
			[
			'nama'	=> 'Harvard Test',
			
			],
			[
			'nama'	=> 'Fatigue Test',
			
			],
			[
			'nama'	=> 'Rectal Swab',
			
			],
			[
			'nama'	=> 'Treadmill',
			
			],
			]
			
		);
	   DB::table('pre_jenis_pemeriksaan_peserta')->truncate();
	   DB::table('pre_jenis_pemeriksaan_peserta')->insert([ 
			
			[
			'nama'	=> 'Sampling',
			'url'	=> '',
			],
			[
			'nama'	=> 'Urin',
			'url'	=> '',
			],
			[
			'nama'	=> 'Rontgen Thorax',
			'url'	=> '',
			],
			[
			'nama'	=> 'Rontgen Lumbal',
			'url'	=> '',
			],
			[
			'nama'	=> 'Return Form',
			'url'	=> '',
			],
			[
			'nama'	=> 'EKG',
			'url'	=> '',
			],
			[
			'nama'	=> 'Audiometri',
			'url'	=> '',
			
			],
			[
			'nama'	=> 'Spirometri',
			'url'	=> '',
			
			],
			[
			'nama'	=> 'Harvard Test',
			'url'	=> '',
			
			],
			[
			'nama'	=> 'Fatigue Test',
			'url'	=> '',
			
			],
			[
			'nama'	=> 'Rectal Swab',
			'url'	=> '',
			
			],
			[
			'nama'	=> 'Treadmill',
			'url'	=> '',
			
			],
			]
		);
		
		echo "sukses";
    }

    public function hapus_pre_per_table(Request $request)
    {
    	
    	$table = $request->table;
    	try{

    		DB::statement("DROP TABLE  $table");
    		return response()->json(['responseCode' => 200, 'responseMessage' => 'successfully']);

    	}
    	catch(Exception $e) {
		    //echo 'Message: ' .$e->getMessage();
		    return response()->json(['responseCode' => 500, 'responseMessage' => $e->getMessage()]);
		}
    }

    public function hapus_pre_only_form_input()
    {
    	
        try{
	
    	DB::statement("DROP TABLE  pre_formekg");
		DB::statement("DROP TABLE  pre_formhematologi");
		DB::statement("DROP TABLE  pre_formhematologi_temp");
		DB::statement("DROP TABLE  pre_formkimia");
		DB::statement("DROP TABLE  pre_formkimia_temp");
		DB::statement("DROP TABLE  pre_formsampling");
		DB::statement("DROP TABLE  pre_formsampling_temp");
		DB::statement("DROP TABLE  pre_formreturn");
		DB::statement("DROP TABLE  pre_formrontgen");
		DB::statement("DROP TABLE  pre_formspirometri");
		DB::statement("DROP TABLE  pre_formurin");
		DB::statement("DROP TABLE  pre_form_hasil_audiometri");


		return response()->json(['responseCode' => 200, 'responseMessage' => 'successfully']);
		}
		catch(Exception $e) {
		    //echo 'Message: ' .$e->getMessage();
		    return response()->json(['responseCode' => 500, 'responseMessage' => $e->getMessage()]);
		}
    }
	
	public function hapus_pre()
	{
		DB::statement("DROP TABLE  	pre_absensi");
		// //DB::statement("DROP TABLE  	pre_inisialisasi");
		DB::statement("DROP TABLE  pre_data_peserta");
		DB::statement("DROP TABLE  pre_detail_absensi_cek_pemeriksaan");
		DB::statement("DROP TABLE  pre_detail_absensi_cek_pemeriksaan_qc");
		DB::statement("DROP TABLE  pre_detail_detail_inisialisasi_cek_pemeriksaan_qc");
		DB::statement("DROP TABLE  pre_detail_peserta_cek_pemeriksaan");
		DB::statement("DROP TABLE  pre_formekg");
		DB::statement("DROP TABLE  pre_formhematologi");
		DB::statement("DROP TABLE  pre_formhematologi_temp");
		DB::statement("DROP TABLE  pre_formkimia");
		DB::statement("DROP TABLE  pre_formkimia_temp");
		DB::statement("DROP TABLE  pre_formsampling");
		DB::statement("DROP TABLE  pre_formsampling_temp");
		DB::statement("DROP TABLE  pre_formreturn");
		DB::statement("DROP TABLE  pre_formrontgen");
		DB::statement("DROP TABLE  pre_formspirometri");
		DB::statement("DROP TABLE  pre_formurin");
		DB::statement("DROP TABLE  pre_form_hasil_audiometri");
		DB::statement("DROP TABLE  pre_inisialisasi");
		DB::statement("DROP TABLE  pre_inisialisasi_detail");
		DB::statement("DROP TABLE  pre_jenis_pemeriksaan_peserta");
		DB::statement("DROP TABLE  pre_jenis_pemeriksaan_qc");


		return response()->json(['responseCode' => 200, 'responseMessage' => 'successfully']);
	}
	
	public function truncate_pre()
	{
		 DB::table('pre_absensi')->truncate();
		 DB::table('pre_data_peserta')->truncate();
		 DB::table('pre_detail_absensi_cek_pemeriksaan')->truncate();
		 DB::table('pre_detail_absensi_cek_pemeriksaan_qc')->truncate();
		 DB::table('pre_detail_detail_inisialisasi_cek_pemeriksaan_qc')->truncate();
		 DB::table('pre_detail_peserta_cek_pemeriksaan')->truncate();
		 DB::table('pre_formekg')->truncate();
		 DB::table('pre_formhematologi')->truncate();
		 DB::table('pre_formhematologi_temp')->truncate();
		 DB::table('pre_formkimia')->truncate();
		 DB::table('pre_formkimia_temp')->truncate();
		
		 DB::table('pre_formreturn')->truncate();
		 DB::table('pre_formrontgen')->truncate();
		 DB::table('pre_formspirometri')->truncate();
		 DB::table('pre_formurin')->truncate();
		 DB::table('pre_formsampling')->truncate();
		 DB::table('pre_formsampling_temp')->truncate();
		 
		 DB::table('pre_form_hasil_audiometri')->truncate();
		 DB::table('pre_inisialisasi')->truncate();
		 DB::table('pre_inisialisasi_detail')->truncate();
		 DB::table('pre_jenis_pemeriksaan_peserta')->truncate();
		 DB::table('pre_jenis_pemeriksaan_qc')->truncate();
		 
		 return response()->json(['responseCode' => 200, 'responseMessage' => 'Truncate table successfully']);
	}
	
	public function truncate_pre2()
	{
		 DB::table('pre_absensi')->truncate();
		 DB::table('pre_data_peserta')->truncate();
		 DB::table('pre_detail_absensi_cek_pemeriksaan')->truncate();
		 DB::table('pre_detail_absensi_cek_pemeriksaan_qc')->truncate();
		 DB::table('pre_detail_detail_inisialisasi_cek_pemeriksaan_qc')->truncate();
		 DB::table('pre_detail_peserta_cek_pemeriksaan')->truncate();
		 DB::table('pre_formekg')->truncate();
		 
		 DB::table('pre_formhematologi')->truncate();
		 DB::table('pre_formkimia')->truncate();


		 DB::table('pre_formhematologi_temp')->truncate();
		 DB::table('pre_formkimia_temp')->truncate();


		 DB::table('pre_formreturn')->truncate();
		 DB::table('pre_formrontgen')->truncate();
		 DB::table('pre_formspirometri')->truncate();
		 DB::table('pre_formurin')->truncate();
		 DB::table('pre_formsampling')->truncate();
		 DB::table('pre_formsampling_temp')->truncate();

		 DB::table('pre_form_hasil_audiometri')->truncate();
		 DB::table('pre_inisialisasi')->truncate();
		 DB::table('pre_inisialisasi_detail')->truncate();
		 
		 return response()->json(['responseCode' => 200, 'responseMessage' => 'Truncate table successfully']);
	}
	public function tesQuery(){

				/*select id, nama_pasien from mcu
                where id not in(
                
                		-- select count(v.mcu_id) as t from (select mcu_id from diagnoses where deleted=0  group by mcu_id) as v
                		select mcu_id from diagnoses where deleted=0  group by mcu_id
                )*/

				// $m = Mcu::pluck('id','nama_pasien');//find('19700101005600000002');//with(['vendorCustomer'])->find('19700101005600000002');  //->where('nama_pasien','al')->value('email');
				
				// //dd($m);
				// //echo  $m->nama_pasien;
				// echo '<br/>';
				// echo $m->count();
				// //echo '<pre>';
				// // var_dump($m);
				// //echo '</pre>';
				// foreach ($m as $t) {
				// 	// print_r($t);
				// 	//echo $t->id; //echo '-'; echo $t->nama_pasien; echo '<br/>';
				// }

				// Mcu::orderBy('id')->chunk(1000, function ($users) {
				// 	foreach ($users as $user) {
				// 		echo $user->nama_pasien; echo '<br/>';
				// 	}
				// 	return false;
				// });


				// DB::table('mcu')->where('published', 'Y')
				// ->chunkById(100, function ($users) {
				// 	foreach ($users as $user) {
				// 		DB::table('mcu')
				// 			->where('id', $user->id)
				// 			->update(['published' => 'N']);
				// 	}
				// });

				// $price = DB::table('work_healths')->avg('sequence');
				// echo $price;

				// $g = DB::table('work_healths')->where('id', 11)->exists();
				// $b = DB::table('diagnoses')->select('mcu_id')->where('deleted',0)->distinct()->get();
                
				// echo $b->count();


				//$query = DB::table('mcu')->select('nama_pasien');
 
				// $users = $query->addSelect(['age'=>function($g){
				// 	return $g->select(DB::raw('"" as "kaprok"'));
				// }])->get();
				// $users = $query->addSelect(DB::raw('tes'));
				// foreach($users as $rt)
				// {
				// 	print_r($rt);
				// }

				// $users = DB::table('diagnoses')
                //      ->select(DB::raw('count(*) as mcu_id, deleted'))
                //      ->where('deleted', 0)
                //      ->groupBy('mcu_id','deleted')
                //      ->get();
				// echo $users->count();


	}
//async_send_message
	public function sendWA()
	{
		/*$key='9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4'; //this is demo key please change with your own key
		$url='http://116.203.191.58/api/async_send_message';
		$nowa = ['08138381906212','08138381906211'];
		foreach($nowa as $no)
		{
			$data = array(
				"phone_no"  => $no,
				"key"       => $key,
				"message"   => 'KAPROK--'.rand(10,1000),
				"skip_link" => true, // This optional for skip snapshot of link in message
				"flag_retry"  => "on", // This optional for retry on failed send message
				"pendingTime" => 3 // This optional for delay before send message
			);
			$data_string = json_encode($data);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 360);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
			);
			echo $res=curl_exec($ch); echo '<br/>';
			curl_close($ch);
		}*/

		//Send Message Delivery Status Sync
		$key='9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4'; //this is demo key please change with your own key
		$url='http://116.203.191.58/api/send_message';
		$data = array(
		"phone_no"  => '081383819062',//'085156718447',
		"key"       => $key,
		"message"   => 'DEMO AKUN WOOWA. tes woowa api v3.0 mohon di abaikan',
		"deliveryFlag" => True, // This optional for get status in message use api `check_delivery_status`
		);
		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
		);
		echo $res=curl_exec($ch);
		curl_close($ch);
		


		/*
		$message_id = '17205343858168';
		$key='9d251b49c15c3b7b77a5291e87f033f1f94f886eabbb28f4'; //this is demo key please change with your own key
		$url='http://116.203.191.58/api/status_msg_id';
		$data = array(
		"msg_id" =>$message_id,
		"key"    =>$key
		);
		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
		);
		echo $res=curl_exec($ch);
		curl_close($ch);

		*/
		
	}
	
	

}