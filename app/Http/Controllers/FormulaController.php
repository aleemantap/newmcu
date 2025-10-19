<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\FormulaDetail;
use App\Models\Parameter;
use App\Models\Rumus;
use App\Models\RumusDetail;
use App\Models\Recommendation;
use App\Models\Diagnosis;
use App\Models\WorkHealth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FormulaController extends Controller
{
   
	public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function index()
    {
        //$parameters = Parameter::all();
        $parameters = Parameter::where("index_of_colom_excel","<>",0)->get();
		return $this->view('pages.formula.index','Icd 10','Icd 10',[ 'parameters' => $parameters]);
    }
	
	public function form()
	{
		 //$parameters = Parameter::all();
		 $parameters = Parameter::where("index_of_colom_excel","<>",0)->get();
			return $this->view('pages.formula.form-formula','Formula','Formula', [
            'parameters' => $parameters,
			'parameter_id' => ""
			//
        ]);
		
	}
	
	public function formEdit($id)
	{
		$parameters = Parameter::all();
			return $this->view('pages.formula.form-formula','Formula','Formula', [
            'parameters' => $parameters,
			'parameter_id' => $id
         ]);
	}
	public function get_json_edit_form(Request $request)
	{
				$paramId = $request->parameter_id;
			    //echo $paramId;
		        $results2 = DB::table('formula_details as a')
					->select('b.id',
							  'b.parameter_id',
							  'd.name as nama_parameter',
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
							  'c.id as recommendation_id',
							  'e.name as name_icd',
							  'e.code as code_icd',
							  'e.id as id_icd',
							  'f.id as id_wh',
							  'f.name as name_wh',
							  'a.baris_kondisi_ke')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->leftJoin('recommendations as c', 'a.id', '=', 'c.formula_detail_id')
					->leftJoin('parameters as d', 'b.parameter_id', '=', 'd.id')
					->leftJoin('icd10s as e', 'e.id', '=', 'c.icd10_id')
					->leftJoin('work_healths as f', 'f.id', '=', 'c.work_health_id')
					//left join icd10s  e on e.id =c.icd10_id
					//left join work_healths  f on f.id =c.work_health_id
					->where('b.parameter_id', $paramId)
					//->where('a.baris_kondisi_ke', 1)
					->orderBy('a.id')
					->get();
					//foreach ($results2 as $r) {
					echo 	json_encode($results2);
					//}	
		
	}


	/*public function updateformula(Request $request,FormulaDetail $fd,Recommendation $rekom)
	{
		//$pa  = $request->parameter;
		$dat = $request->data_form;
		//$arr_kolom = $request->arr_kolom;
		
		try{
			DB::beginTransaction();
			    
				$j = 1;
				$x = 0;
				$f = $dat;
				for($d=1; $d<=count($dat); $d++)
				{
					$idx = 1;
					$n = 0;
					for($k = 0; $k < count($arr_idformula); $k++)
					{
						 
						 $c = $fd->find($f[$x]['id_detail_formula'][$n]);
						
						 //$c->formula_id = $arr_idformula[$idx];
						 $c->nilai_kolom = ($f[$x]['nilai_kolom'][$n]=="") ? "" : $f[$x]['nilai_kolom'][$n];
						 $c->ket_or_satuan = ($f[$x]['satuan'][$n]=="") ? "" : $f[$x]['satuan'][$n];
						 //$c->type_inputan_nilai_kolom = $f[$x]['ji'][$n];
						 $c->jenis_kolom_atau_operator = $f[$x]['operator'][$n];
						 $c->baris_kondisi_ke = $j;
						 $c->save();
						 $insertedIdFD = $c->id;
						 
						 if($idx == count($arr_idformula))
						 {	 
							 $id_ro = $f[$x]['recommendation_id'];
							 if( $f[$x]['yt_r']==1 and $id_ro == "") //insert new rekom
							 {
								 $r = new Recommendation();
								 $r->formula_detail_id = $insertedIdFD;
								 $r->icd10_id = $f[$x]['icdx'];
								 $r->work_health_id = $f[$x]['diagnosis'];
								 $r->recommendation = $f[$x]['recommendation'];
								 $r->active = 1;
								 $r->save();
							 }
							 else if($f[$x]['yt_r']==1 and $id_ro !== "") //update
							 {
								 $c = $rekom->find($f[$x]['recommendation_id']);
								 $r->icd10_id = $f[$x]['icdx'];
								 $r->work_health_id = $f[$x]['diagnosis'];
								 $r->recommendation = $f[$x]['recommendation'];
								 $r->active = 1;
								 $r->save();
								 
							 }
							 else if($f[$x]['yt_r']==0 and $id_ro !== "") //in active
							 {
								 $c = $rekom->find($f[$x]['recommendation_id']);
								 //$r->icd10_id = $f[$x]['icdx'];
								 //$r->work_health_id = $f[$x]['diagnosis'];
								 //$r->recommendation = $f[$x]['recommendation'];
								 $r->active = 0;
								 $r->save();
							 }
						}
						 
					  $n++;;	
					  $idx++;	
					}	
					$j++;
					$x++;
				}
									
			
			DB::commit();
			return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Data Berhasil Diubah']);
		}catch(\Exception $e){
			DB::rollback();
			return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat mengubah. Please refresh page and try again \n '.$e ]);
		}
		
		
	}*/
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
        $d = new Formula();
        $d->name = $request->name;
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add formula. Please try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Formula group has been added successfully']);
    }
    
    public function storeDetail(Request $request) 
    {
        $d = new FormulaDetail();
        $d->formula_id = $request->formulaId;
        $d->parameter_type = $request->parameterType;
        $d->parameter_id = $request->parameter;
        $d->sex = $request->sex;
        $d->operator = $request->operator;
        $d->value_type = $request->valueType;
        $d->value_bottom = $request->valueBottom;
        $d->value_top = $request->valueTop;
        $d->icd10_id = $request->icd;
        $d->work_health_id = $request->diagnosis;
        $d->recommendation = $request->recommendation;
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add formula. Please try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Formula has been added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function show(Rumus $formula, $id)
    {
        return $formula->find($id);
    }
    
	public function add_rumus_detail($id)
	{
		$results = DB::table('formula_details as a')
					->select('b.nama_kolom','b.urutan','a.formula_id','b.rumus_id')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->leftJoin('rumuses as c', 'c.id', '=', 'b.rumus_id')
					->where('b.rumus_id', $id)
					->orderBy('b.urutan')
					->groupBy('b.nama_kolom','b.urutan','a.formula_id','b.rumus_id')
					->get();
		$da = array();
		
		$a=1;
		foreach ($results as $r) {
			
			$data =  array (
			  'rumus_id' =>  $r->rumus_id,
			  'formula_id' => $r->formula_id,
			  'nama_kolom' => $r->nama_kolom,
			);
			$da[$a] = $data; 
			//break;
		$a++;	
		}	
		return response()->json($da);
	
	}
	
	
	public function insert_rumus_detail_c(Request $req)
	{
		
		$dt_f = DB::table('formulas')->select('id','jenis_kolom','rumus_id')->where('rumus_id',$req->rumus_id_c)->get();
		
		$rf = array();
		$c = 1;
		foreach($dt_f as $f)
		{
			 $rf[] = $f->id;
			 
			 //if($c>1)
			 //{
				 //$ck =	 FormulaDetail::where('jenis_kolom_atau_operator', 'contain')->where('formula_id',$f->id);
		     
				 //if($ck->count() > 0)
				 //{
				 //	 	return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat menambah. Hanya boleh aad 1 kondisi contain dalama satu rumus \n '.$e ]);
			
				 //} 	
			 //} 	 
		      
		 $c++;
		}
		$max = max($rf);
		$min = min($rf);
		$max = FormulaDetail::whereBetween('formula_id', array($min, $max))->max('baris_kondisi_ke');	
			try{
				DB::beginTransaction();
				
				$j = $max + 1;
				$i = 1;
				foreach($dt_f as $r)
				{
					
					
					if($i==1)
					{
						$c = new FormulaDetail();
						$c->formula_id = $r->id;
						$c->nilai_kolom = 'contain';
						$c->ket_or_satuan  = '';
						$c->type_inputan_nilai_kolom = "string";
						$c->jenis_kolom_atau_operator = 'contain';
						$c->baris_kondisi_ke = $j;
						$c->save(); 
					
					
					}
					else
					{
						$c = new FormulaDetail();
						$c->formula_id = $r->id;
						$c->nilai_kolom = 'abnormal';
						$c->ket_or_satuan  = '';
						$c->type_inputan_nilai_kolom = "string";
						$c->jenis_kolom_atau_operator = 'hasil';
						$c->baris_kondisi_ke = $j;
						$c->save();
						$insertedIdFD = $c->id;  
					
					
						$f = $req->rekom;
						//$x = 0;
						foreach($f as $r)
						{
							 //echo $r['name_kondisi'];
							 $rs = new Recommendation();
							 $rs->formula_detail_id = $insertedIdFD;
							 $rs->icd10_id =  isset($r['icdx_name']) ? $r['icdx_id'] : null;  
							 $rs->work_health_id = $r['diagnosis'];
							 $rs->recommendation = $r['recommendation'];
							 $rs->active = 1;
							 $rs->deleted = isset($r['icdx_name']) ? '0' : '1';
							 $rs->note = $r['name_kondisi'];
							 $rs->save();
							 //$x++; 
						}
						
					}	
						
					
					$i++;
					//$j++;
				}
				
				
				
				DB::commit();
				return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);

				
			}catch(\Exception $e){
				
				DB::rollback();
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat menambah. Please refresh page and try again \n '.$e ]);
			}	 
	}	
	
	public function insert_rumus_detail(Request $req)
	{
		
		$rf = array();
		//$rf2 = array();
		foreach($req->rv as $r)
		{
		  $rf[] = $r['formula_id'];
		  //$rf2[] = $r['nilai_kolom'];
		}
		
		$max = max($rf);
		$min = min($rf);
		
		$max = FormulaDetail::whereBetween('formula_id', array($min, $max))->max('baris_kondisi_ke');	
	
		try{
			   
			
			DB::beginTransaction();
			$j = $max + 1;
			foreach($req->rv as $r)
			{
				
				$c = new FormulaDetail();
				$c->formula_id = $r['formula_id'];
				$c->nilai_kolom = $r['nilai_kolom'];
				$c->ket_or_satuan  = $r['satuan'];
				$c->type_inputan_nilai_kolom = "string";
				$c->jenis_kolom_atau_operator = $r['operator'];
				$c->baris_kondisi_ke = $j;
				$c->save();
				$insertedIdFD = $c->id;
				
				
				if(strtolower($r['operator']) == 'hasil' )
				{	
					$f = $req->recom;
					//if($f[0]['ya_tidak']==1)
					//if(isset($f[0]['icdx_name2']))
					//{
						 
						 $rs = new Recommendation();
						 $rs->formula_detail_id = $insertedIdFD;
						 $rs->icd10_id =  isset($f[0]['icdx_name2']) ? $f[0]['icdx_id'] : null;  //$f[0]['icdx_id'];
						 $rs->work_health_id = $f[0]['diagnosis'];
						 $rs->recommendation = $f[0]['recommendation'];
						 $rs->active = 1;
						 $rs->deleted = isset($f[0]['icdx_name2']) ? '0' : '1';
						 $rs->save();
						 
						 
						 
						//if(!$rs->save()) {
						//		return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
						//}
						 
					//}
				}
				
					
			}
			 
			 
			 
			//if(!$c->save()) {
			//	return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			//}
        
  		
			DB::commit();
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);

				
		}catch(\Exception $e){
			DB::rollback();
			return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat menambah. Please refresh page and try again \n '.$e ]);
		}
				
	}
	
	public function detail2($id){
		
		
		
	}
	
    public function detail($id)
    {
		
		
		$results = DB::table('formula_details as a')
					->select('a.baris_kondisi_ke','b.jenis_kolom','a.jenis_kolom_atau_operator')
					->leftJoin('formulas as b', 'a.formula_id', '=', 'b.id')
					->where('b.rumus_id', $id)
					->where('a.jenis_kolom_atau_operator','<>', 'contain')
					->where('b.jenis_kolom', '<>', 'kesimpulan')
					->orderBy('a.baris_kondisi_ke')  
					->get();	
		$da = array();
		$da3 = array();
		//$da1 = array();
		$a=1;
		foreach ($results as $row) {
				
				//array_push($da,array('br'=>$row->baris_kondisi_ke,'ope'=>$row->jenis_kolom_atau_operator));
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
							->get();
							
						$f= 1;
						foreach($rumus_detail as $r)
						{
								$data =  array (
								  'rumus_id' =>  $r->rumus_id,
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
								  'deleted' => $r->deleted
								);
							
							
							$da1[$f] = $data; 
							
							
						$f++;
						}
			    
			    $da3[$row->baris_kondisi_ke] = ['oper'=> $row->jenis_kolom_atau_operator, 'data'=>$da1, "kel"=> $this->cek_count_kolomkondisi_formula_tabel($id)]; 
			    
		$a++;
		
		}		
		
		//echo json_encode($da);
		return response()->json($da3);
    }
	
	public function cek_count_kolomkondisi_formula_tabel($rumus_id)
	{
		
		$xcv = DB::table('formulas as a')
							->select('a.id')
							->where('a.rumus_id',$rumus_id)
							->get();
		return count($xcv);
		
	}
	
	public function workHealths()
    {
        
        $workDiagnosis = WorkHealth::all();
        echo json_encode($workDiagnosis);
    }
	
	public function del22(Request $request,Recommendation $recommendation){
		
		
		$ids = intval($request->recommendation_id);
		$d = Recommendation::where('id', $ids);
		if($d->count() > 0)
		{	
		
			$d  = Recommendation::find($ids);
			$d->deleted = 1;
			
			if(!$d->save()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			}
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);
		}
		
	}
	public function updatedetailformula(Request $request,FormulaDetail $formulaDetail)
	{
		
		$satuan =  $request->satuan;
		$nilaikolom = $request->nilaikolom;
		$operator = $request->operator;
		$id = $request->id;
		
		$d = $formulaDetail->find($id);
        $d->nilai_kolom = $nilaikolom;
        $d->ket_or_satuan = $satuan;
        $d->jenis_kolom_atau_operator = $operator;
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);
  
		
		
	}
	public function updatedetailformula2(Request $request,Recommendation $recommendation)
	{
		
		$wh =  $request->wh;
		$icdx_id = $request->icdx_id2;
		$icdx_name2 = $request->icdx_name2;
		$detail_formula_id = $request->detail_formula_id;
		$recommendation = $request->recommendation;
		$note = $request->note;
		$ids = intval($request->recommendation_id);
		//recommendation_id recommendation_id
		//$d  = Recommendation::find($ids);
		//$d = $recommendation->find($ids);
		
		$d = Recommendation::where('id', $ids);
		
		if($d->count() > 0)
		{	
		
			$d  = Recommendation::find($ids);
			//$d->icd10_id = $icdx_id;
			$d->icd10_id =  isset($icdx_name2) ? $icdx_id : null;
			$d->work_health_id	 = $wh;
			$d->recommendation	 = $recommendation;
			$d->active = 1;
			$d->deleted = isset($icdx_name2) ? '0' : '1';
			//$d->note = $note;
			
			if(!$d->save()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			}
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);
		}
		else
		 {
			//echo "kaprok";
			$d  = new Recommendation();
			$d->formula_detail_id = $detail_formula_id;
			$d->icd10_id = isset($icdx_name2) ? $icdx_id : null;
			$d->work_health_id	 = $wh;
			$d->recommendation	 = $recommendation;
			$d->active = 1;
			$d->deleted = isset($icdx_name2) ? '0' : '1';
			//$d->note = $note;
			
			if(!$d->save()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			}
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);

		
		}	 
		
		
	}
	
	public function updatedetailformula3(Request $request,Recommendation $recommendation)
	{
		
		$wh =  $request->wh;
		$icdx_id = $request->icdx_id2;
		$icdx_name2 = $request->icdx_name2;
		$detail_formula_id = $request->detail_formula_id;
		$recommendation = $request->recommendation;
		$note = $request->note;
		$ids = intval($request->recommendation_id);
		
		$d = Recommendation::where('id', $ids);
		
		if($d->count() > 0)
		{	
		
			$d  = Recommendation::find($ids);
			//$d->icd10_id = $icdx_id;
			$d->icd10_id =  isset($icdx_name2) ? $icdx_id : null;
			$d->work_health_id	 = $wh;
			$d->recommendation	 = $recommendation;
			$d->active = 1;
			$d->note = isset($note) ? $note : ' ';
			$d->deleted = isset($icdx_name2) ? '0' : '1';
			
			if(!$d->save()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			}
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);
		}
		else
		 {
			
			$d  = new Recommendation();
			$d->formula_detail_id = $detail_formula_id;
			$d->icd10_id = isset($icdx_name2) ? $icdx_id : null;
			$d->work_health_id	 = $wh;
			$d->recommendation	 = $recommendation;
			$d->active = 1;
			$d->note =  isset($note) ? $note : ' ';
			$d->deleted = isset($icdx_name2) ? '0' : '1';
			
			if(!$d->save()) {
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapa mengubah. Silahkan coba lagi']);
			}
			
			return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Successfully']);

		
		}	 
	}
	/*public function inputformula(Request $request)
	{
		$data_parameter = array();
		$jenis_inputan  = $request->jenis_inputan;
		$nama_rumus  = $request->nama_rumus;
		
		try{
				$find =  Rumus::where('nama', '=', $nama_rumus)->get();
					  
				if($find->count() < 1)
				{
				 	 DB::beginTransaction();
				     $r = new Rumus();
					 $r->nama = $nama_rumus;
					 $r->save(); 
					 $inserted_ir = $r->id;
					  
					  $gu = 1;
					  foreach($data_parameter  as $t)
					  {
							  $d = new RumusDetail();
							  $d->rumus_id = $inserted_ir;
							  $d->parameter_id = $t['parameter_id'];
							  $d->urutan_grup_paramater = $t['urutan'];
							  $d->save();  
					  
					  $gu++;
					  }
					  
						$i=1; //urutan
						$in = 0; //index
						$arr_idformula =array();
						
						foreach($arr_kolom  as $t)
						{
							 
							  $nm = $t;
                              
							  $jk = ($nm =='kesimpulan') ? 'kesimpulan' : 'kolomkondisi'; 
							  
							  $d = new Formula();
							  $d->rumus_id = $inserted_ir;
							  $d->nama_kolom = $nm;
							  $d->jenis_kolom = $jk;
							  $d->urutan = $i;
							  $d->save(); 
							  
							  $insertedId = $d->id;
							  $arr_idformula[$i] = $insertedId; 
						$i++;
						$in++;
						}
						
						
						$j = 1;
						$x = 0;
						$f = $dat;
						for($d=1; $d<=count($dat); $d++)
						{
							$idx = 1;
							$n = 0;
							for($k = 0; $k < count($arr_idformula); $k++)
							{
								 //echo $arr_idformula[$k+1];
								 $c = new FormulaDetail();
								 $c->formula_id = $arr_idformula[$idx];
								 $c->nilai_kolom = ($f[$x]['nilai_kolom'][$n]=="") ? "" : $f[$x]['nilai_kolom'][$n];
								 $c->ket_or_satuan = ($f[$x]['satuan'][$n]=="") ? "" : $f[$x]['satuan'][$n];
								 $c->type_inputan_nilai_kolom = "string";//$f[$x]['ji'][$n];
								 $c->jenis_kolom_atau_operator = $f[$x]['operator'][$n];
								 $c->baris_kondisi_ke = $j;
								 $c->save();
								 $insertedIdFD = $c->id;
								 
								 if($idx == count($arr_idformula))
								 {	 
									 //if($f['yt_r']=='1')
									 if($f[$x]['yt_r']==1)
									 {
											$r = new Recommendation();
											 $r->formula_detail_id = $insertedIdFD;
											 $r->icd10_id = $f[$x]['icdx'];
											 $r->work_health_id = $f[$x]['diagnosis'];
											 $r->recommendation = $f[$x]['recommendation'];
											 $r->active = 1;
											 $r->save();
										 
									 }
								 }
								 
							  $n++;;	
							  $idx++;	
							}	
							
							$j++;
							$x++;
						}	  
					
						DB::commit();
						return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Data Berhasil Ditambahkan']);
		
					}
					else
					{
						return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Nama Rumus Sudah ada, gagal menyimpan']);

					}	
			}catch(\Exception $e){
				DB::rollback();
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat menambah. Please refresh page and try again \n '.$e ]);
			}
	} */
	
	public function inputformula_X(Request $request)
	{
		print_r($request->data_parameter);
		print_r($request->arr_kolom);
		print_r($request->logika);
		print_r($request->data_form);
		print_r($request->nama_rumus);
	}
	
	public function inputformula(Request $request)
	{
		$data_parameter = array();
		$dat = array();
		$arr_kolom = array();

		$pa  = $request->parameter;
		$data_parameter  = $request->data_parameter;
		$nama_rumus  = $request->nama_rumus;
		$logika  = $request->logika;
		$dat = $request->data_form;
		$arr_kolom = $request->arr_kolom;
		//$arr_kolom_kondisi = $request->arr_kolom_kondisi;

		
	   if(empty($nama_rumus))
        {
		    return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Nama Rumus masih kosong, gagal menyimpan']);
		}	
		else if(empty($pa))
        {
		  return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Parameter Kosong, gagal menyimpan']);

		}
        else if(!is_array($data_parameter) or count($data_parameter) == 0 )
        {
		    return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Data belum Add Paramater, gagal menyimpan']);

		} 
		
        else if(!is_array($dat) or count($dat) == 0 )
        {
		    return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Belum Mengisi Detail Form, gagal menyimpan']);

		}
        else if( !is_array($arr_kolom) or count($arr_kolom) == 0 )
        {
		    return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Belum kolom kondisi, gagal menyimpan']);

		}
        else 
        { 

			try{
				   
				
					$find =  Rumus::where('nama', '=', $nama_rumus)->get();
					  
					if($find->count() < 1)
					{
						DB::beginTransaction();
				 
					
					  $r = new Rumus();
					  
					  
					  $r->nama = $nama_rumus;
					  $r->logika_antar_param = $logika;
					  $r->save(); 
					  $inserted_ir = $r->id;
					  
					  $gu = 1;
					  foreach($data_parameter  as $t)
					  {
							  $d = new RumusDetail();
							  $d->rumus_id = $inserted_ir;
							  $d->parameter_id = $t['parameter_id'];
							  $d->urutan_grup_paramater = $t['urutan'];
							  $d->save();  
					  
					  $gu++;
					  }
					  
						$i=1; //urutan
						$in = 0; //index
						$arr_idformula =array();
						
						foreach($arr_kolom  as $t)
						{
							 
							  $nm = $t;
                              
							  $jk = ($nm =='kesimpulan') ? 'kesimpulan' : 'kolomkondisi'; 
							  
							  $d = new Formula();
							  $d->rumus_id = $inserted_ir;
							  $d->nama_kolom = $nm;
							  $d->jenis_kolom = $jk;
							  $d->urutan = $i;
							  $d->save(); 
							  
							  $insertedId = $d->id;
							  $arr_idformula[$i] = $insertedId; 
						$i++;
						$in++;
						}
						
						
						$j = 1;
						$x = 0;
						$f = $dat;
						for($d=1; $d<=count($dat); $d++)
						{
							$idx = 1;
							$n = 0;
							for($k = 0; $k < count($arr_idformula); $k++)
							{
								 //echo $arr_idformula[$k+1];
								 $c = new FormulaDetail();
								 $c->formula_id = $arr_idformula[$idx];
								 $c->nilai_kolom = ($f[$x]['nilai_kolom'][$n]=="") ? "" : $f[$x]['nilai_kolom'][$n];
								 $c->ket_or_satuan = ($f[$x]['satuan'][$n]=="") ? "" : $f[$x]['satuan'][$n];
								 $c->type_inputan_nilai_kolom = "string";//$f[$x]['ji'][$n];
								 $c->jenis_kolom_atau_operator = $f[$x]['operator'][$n];
								 $c->baris_kondisi_ke = $j;
								 $c->save();
								 $insertedIdFD = $c->id;
								 
								 if($idx == count($arr_idformula))
								 {	 
									 //if($f['yt_r']=='1')
									 if($f[$x]['yt_r']==1)
									 {
											$r = new Recommendation();
											 $r->formula_detail_id = $insertedIdFD;
											 $r->icd10_id = $f[$x]['icdx'];
											 $r->work_health_id = $f[$x]['diagnosis'];
											 $r->recommendation = $f[$x]['recommendation'];
											 $r->active = 1;
											 $r->save();
										 
									 }
								 }
								 
							  $n++;;	
							  $idx++;	
							}	
							
							$j++;
							$x++;
						}	  
					
						DB::commit();
						return response()->json(['responseCode' => 200, 'responseStatus' => 'Success', 'responseMessage' => 'Data Berhasil Ditambahkan']);
		
					}
					else
					{
						return response()->json(['responseCode' => 201, 'responseStatus' => 'Failed', 'responseMessage' => 'Nama Rumus Sudah ada, gagal menyimpan']);

					}	
			}catch(\Exception $e){
				DB::rollback();
				return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Tidak dapat menambah. Please refresh page and try again \n '.$e ]);
			}
			
		}
		
	} 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function edit(Formula $formula)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rumus $rumus)
    {
        $d = $rumus->find($request->id);
        $d->nama = $request->name;
        $d->active = $request->status;
        
        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t update formula group. Please try again']);
        }
        
        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Formula group has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formula $formula)
    {
        //
    }
	
	public function delete_rekomendasi($id)
	{
		//diagnoses
		
		//$fs = Diagnosis::where('recommendation_id',$id);
		
		//if($fs->count() > 0) {
		//  return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data has been used']);

		//}
		//else
		//{	
			$f = DB::table('recommendations')
              ->where('id', $id)
              ->update(['deleted' => 1]);
			$fs = DB::table('diagnoses')
              ->where('recommendation_id', $id)
              ->update(['deleted' => 1]);
			
			//if($f)
			//{
				return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Recomendation, work Diagnosis & ICD X has been deleted successfully']);
			//}	
			//else
			//{
			//	return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'can t  delete']);

			//}	
		//}
        	
	}	
	
	public function delete_detail_formula2($id_detail,$id_rumus)
	{
		//$f = Recommendation::where('formula_detail_id',$id_detail);
		//if($f->count() > 0) {
			
			 //update recomedasi jadi delete
		     //Recommendation::where('formula_detail_id', $id_detail)
			 //->update(['deleted' => 1]);
			 // update diagnosa jadi delete
			 //Diagnosis::
			 // update formula detail jadi delete 	
			 //$id_re = $f->first()->id;
			 //$fs = Diagnosis::where('recommendation_id',$id_re)->where('deleted',0);
			 //if($fs->count() > 0) {
			 // return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data has been used']);
			 //}
		//}
			

		
	}	
	
	
	
	public function delete_detail_formula($id_detail,$id_rumus)
	{
		try
		{
	  	    //DB::table('diagnoses')->where('id', 1)->delete();
			//DB::beginTransaction(); 
			
			$f = Recommendation::where('formula_detail_id',$id_detail);
			if($f->count() > 0) {
				//cek dipake diagnose
				$id_re = $f->first()->id;
				$fs = Diagnosis::where('recommendation_id',$id_re);//->where('deleted',0);
				
				if($fs->count() > 0) {
				  //echo "Tidak bisa didelete";
				  
				  return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data has been used']);

				}
				else
				{
					//echo 'bisa di delete';
					//delete pada tabel formula detail
					//FormulaDetail
					//ambil baris_kondisi_ke
					$rr = FormulaDetail::where('id',$id_detail);
					$br = $rr->first()->baris_kondisi_ke;
					$g  = Formula::where('rumus_id',$id_rumus); 
					$whereArray = array();
					foreach($g->get() as $h)
					{
						$formula_id = $h->id; 
						//$gs = FormulaDetail::where('formula_id',$id_detail)->where('baris_kondisi_ke',$br);
						//$idd = $gs->first()->id;
						//echo $idd;
						//FormulaDetail::find($idd)->delete();
						DB::table('formula_details')->where('formula_id', $formula_id)->where('baris_kondisi_ke', $br)->delete();

						//if(!$g2)
						//{
						//	return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data']);

						//}	
						//array_push($whereArray,array("formula_id"=>$formula_id,"baris_kondisi_ke"=>$br));
						//echo $formula_id;
						//$res=FormulaDetail::where('formula_id',$formula_id)->where('baris_kondisi_ke',$br)->delete();
					}
					DB::table('recommendations')->where('id', $f->first()->id)->delete();
					

					//$g2 = FormulaDetail::whereArray($whereArray)->delete();
					//if(!$g2)
					//{
					
					//	return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data']);

					//}	
					return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Formula has been deleted successfully']);
				   //echo 'kl2';
				}				
				
			}
			else
			{
				//delete pada tabel formula detail
				//echo 'tidak ada';
				$rr = FormulaDetail::where('id',$id_detail);
				$br = $rr->first()->baris_kondisi_ke;
				$g  = Formula::where('rumus_id',$id_rumus); 
				$whereArray = array();
				foreach($g->get() as $h)
				{
					
					$formula_id = $h->id; 
					
					//$nrd = DB::delete('DELETE FROM table_name WHERE condition;');
					
					//$gs = FormulaDetail::where('formula_id',$id_detail)->where('baris_kondisi_ke',$br);
					//$idd = $gs->first()->id;
					//echo $idd;
					//FormulaDetail::find($idd)->delete();
					//$formula_id = $h->id; 
					DB::table('formula_details')->where('formula_id', $formula_id)->where('baris_kondisi_ke', $br)->delete();

					//array_push($whereArray,array("formula_id"=>$formula_id,"baris_kondisi_ke"=>$br));
					//echo $formula_id;
					//$res=FormulaDetail::where('formula_id',$formula_id)->where('baris_kondisi_ke',$br)->delete();
				}
				
				//$g2 = FormulaDetail::whereArray($whereArray)->delete();
				//if(!$g2)
				//{
				// return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t delete this data']);
	
				//}
				return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'Formula has been deleted successfully']);
				//echo 'kl';
			}
			//DB::commit();	
		}
		catch(\Exception $e){
			     DB::rollback();
				  return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'can not  delete']);
		}	
        
	}
    
    public function datatables()
    {
    	$formulas = Rumus::all();//where('active',1);
		
        return datatables($formulas)
           
		   	->addColumn('active', function($formulas) {
				return ($formulas->active==1) ? "active" : "non active";
			})	
		   
			->addColumn('action', function($formulas) {
               // return '<a href="/database/formula/detail/'.$formulas->id.'" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Add Formula</a> &nbsp; <button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$formulas->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$formulas->id.'><i class="fa fa-trash"></i></button>';
                $g = $formulas->id;
				return '<button type="button" id="btn-detail'.$g.'"  class="btn btn-success btn-flat btn-xs btn-detail" data-id='.$formulas->id.'>
							<i class="fa fa-search"></i>
						</button> &nbsp;
						<button type="button" class="btn btn-primary btn-xs btn-flat btn-add" data-id='.$formulas->id.'>
							<i class="fa fa-plus"></i></button>&nbsp;
						
						<button type="button" class="btn btn-warning btn-xs btn-flat btn-edit" data-id='.$formulas->id.'>
							<i class="fa fa-pencil"></i>
						</button>&nbsp;';
            })
		// <button type="button" class="btn btn-primary btn-xs btn-add-c" data-id='.$formulas->id.'>
						// 	<i class="fa fa-plus-square"></i></button>&nbsp;
            ->rawColumns(['action', 'active'])
            ->addIndexColumn()
			//->skipPaging()
            ->toJson();
    }
    
    public function detailDatatables($id)
    {
        $formulas =  FormulaDetail::where('formula_id', $id)->with(['parameter','icd10','workHealth']);
        
        return datatables($formulas)
            ->addColumn('action', function($formulas) {
                return '<button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$formulas->id.'><i class="fa fa-pencil"></i></button>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete" data-id='.$formulas->id.'><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('parameterType', function($formulas) {
                return $formulas->paramter_type == 1?'Single':'Multiple';
            })
            ->addColumn('valueType', function($formulas) {
                return $formulas->value_type == 1?'Fixed':'Range';
            })
            ->addColumn('gender', function($formulas) {
                if($formulas->sex == 0) {
                    return 'Unisex';
                } else if($formulas->sex == 1) {
                    return 'Male';
                } else if($formulas->sex == 2) {
                    return 'Female';
                }
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
