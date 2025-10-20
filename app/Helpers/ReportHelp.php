<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ReportHelp { //ReportHelper

	public static function getWh($id)
    {
    	$rf = DB::table('work_healths')->where('id',$id)->get();
    	return $rf[0]->name;
    }
    public static function get_header($param) {
       
	    $header = '
			<div class="row">
			  <div class="column1">
				<img style="padding-left:20px;" src="'.public_path('img/logo1.png').'" >
			  </div>
			  <div class="column2" style="">
				<div class="table">
				   <div class="row">
					  <div class="cell cell_att">
						 Medical ID#
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 20190801002700004026
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						 Nama
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 xxxxxxxx
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						 Tanggal Lahir
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 xxxxxxxx
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						 NIP
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 xxxxxxxx
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						 Bagian
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 xxxxxxxx
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						 Perusahaan
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						  xxxxxxxx
					  </div>
				   </div>
				   <div class="row">
					  <div class="cell cell_att">
						Paket MCU
					  </div>
					  <div class="cell">
					  </div>
					  <div class="cell">
						 xxxxxxxx
					  </div>
				   </div>
				</div>
			  </div>
			</div>
		';
	   
        return $header;
    }

    
    // public static function setDouble($double) {

    // 	if(empty($double)) {
    //         return NULL;
    //     }

    //     if(is_string($double)) {
    //         return str_replace(",", ".", $double);
    //     }

    //     return $double;
       
    // }
    public static function GDS($param) {

    	
    	if($param!="")
    	{
    		if($param<60 or $param>200)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function GDP($param) {

    	if($param!="")
    	{
    		if($param<60 or $param>125)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}
    }

    public static function duaJamPP($param) {
    	if($param!="")
    	{
    		if($param<60 or $param>140)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}
    
    }

    public static function HbA1c($param) {
    	if($param!="")
    	{
    		//if($param<4 or $param>8)
			if($param > 6.5)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}
    
    }

    public static function Ureum($param) {

    	if($param!="")
    	{
    		if($param<15 or $param>39)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    
    }

    public static function Kreatinin($param,$param2) {
    	//(L:0,62-1,1 | P:0,45-0,7)
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param<0.45 or $param>0.7)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param<0.62 or $param>1.1)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}
	    	

    
    }

    public static function  AsamUrat($param,$param2) {

    	// L:3,5 - 7,2 | P:2,6-6,0)
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param<2.6 or $param>6.0)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param<3.5 or $param>7.2)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}
    
    }

    public static function  Trigliserida($param) {

    	if($param!="")
    	{
    		if($param>200)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    
    }

    public static function  KolesterolTotal($param) {

    	if($param!="")
    	{
    		if($param>200)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    
    }

    public static function  HDL($param, $param2) {
		
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param<45 or $param>65)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param<35 or $param>55)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}
    
    }

    public static function  LDL($param) {

    	if($param!="")
    	{
    		if($param>150)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}


    
    }

    public static function HBSAg($param)
    {
    	if($param!="")
    	{
    		if(strtolower($param) !='non reaktif')
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function AntiHBS($param)
    {
    	if($param!="")
    	{
    		if(strtolower($param) !='non reaktif')
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}
    }

    
    public static function BilirubinTotal($param)
    {
    	if($param!="")
    	{
    		if($param<0 or $param>1)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function BilirubinDirek($param)
    {
    	if($param!="")
    	{
    		if($param<0 or $param>0.25)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function BilirubinInDirek($param)
    {
    	if($param!="")
    	{
    		if($param<0 or $param>0.75)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }


    public static function SGOT($param)
    {
    	if($param!="")
    	{
    		if($param<15 or $param>34)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

       
    public static function SGPT($param)
    {
    	if($param!="")
    	{
    		if($param<15 or $param>60)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    } 

    public static function Protein($param)
    {
    	if($param!="")
    	{
    		if($param<6.2 or $param>8.4)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    } 

    public static function Albumin($param)
    {
    	if($param!="")
    	{
    		if($param<3.5 or $param>5.5)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  Alkalinefosfatase($param)
    {
    	if($param!="")
    	{
    		if($param<45 or $param>190)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  CholineEsterase($param)
    {
    	if($param!="")
    	{
    		if($param<4300 or $param>10500)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  gammaGt($param)
    {
    	if($param!="")
    	{
    		if($param<0 or $param>51)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  CK($param, $param2)
    {
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param<25 or $param>150)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param<30 or $param>180)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}

    }
   
    public static function  CKMB($param)
    {
    	if($param!="")
    	{
	    	
	    		if($param>10)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  SputumBTA1($param)
    {
    	if($param!="")
    	{
	    	
	    		if(strtolower($param)!="negatif")
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  SputumBTA2($param)
    {
    	if($param!="")
    	{
	    	
	    		if(strtolower($param)!="negatif")
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	
	    		
    	}
    	else
    	{
    		return '';
    	}

    }
    
    public static function  SputumBTA3($param)
    {
    	if($param!="")
    	{
	    	
    		if(strtolower($param)!="negatif")
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
	    		
    	}
    	else
    	{
    		return '';
    	}

    }
    /* hemoglobin */
    public static function  Hemoglobin($param, $param2)
    {
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param>16.5 or $param<11.5)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param>18 or $param<13)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  Hematokrit($param, $param2) 
    {
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param>43 or $param<37)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param>50 or $param<40)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  Eritrosit($param, $param2)
    {
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param>5 or $param<4)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param>5.5 or $param<4.5)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  Leukosit($param)
    {
    	if($param!="")
    	{
	    	
    		if($param>11000 or $param<4000)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}

    }

    public static function  Trombosit($param)
    {
    	if($param!="")
    	{
	    	
    		if($param>400 or $param<150)
    		{
    			return '<span style="color:red;">'.$param.'</span>';
    		}
    		else
    		{
    			return  '<span>'.$param.'</span>';
    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}

    }
    
    
    public static function LED($param,$param2){
    	
    	if($param!="")
    	{
	    	if($param2=="P") //CEWE
	    	{

	    		if($param<0 or $param>15)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}

	    	}	
	    	else // COWO
	    	{
	    		if($param<0 or $param>10)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	}
	    		
    	}
    	else
    	{
    		return '';
    	}
    }

     public  static function Basofil($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<0 or $param>1)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public  static function MCV($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<82 or $param>92)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function Eosinofil($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<1 or $param>3)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function MCH($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<27 or $param>31)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function Neutrofil_batang($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<2 or $param>5)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function Mchc($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<32 or $param>37)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
   public static function Neutrofil_segment($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<50 or $param>70)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function limfosit($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<20 or $param>40)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function Monosit($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<2 or $param>6)
	    		{
	    			//return '<span style="color:red;">'.$param.'</span>';
	    			return '<span>'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }
    public static function Urobilinogen($param){
    	
    	if($param!="")
    	{
	    	
	    		if($param<0.2 or $param>0.2)
	    		{
	    			return '<span style="color:red;">'.$param.'</span>';
	    		}
	    		else
	    		{
	    			return  '<span>'.$param.'</span>';
	    		}
	    	
	    		
    	}
    	else
    	{
    		return '';
    	}
    }

   
    
    
}