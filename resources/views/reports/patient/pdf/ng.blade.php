<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<style>
 
		* {
		  font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 	
		 
		}
		
		@page {
			size: A4;
			margin-top: 1cm;
			margin-left: 1cm;
			margin-right: 1cm;
			margin-bottom: 0cm;
		}

		/** Define now the real margins of every page in the PDF **/
		body {
			
			

		}
		
			 
		p { page-break-after: always;  } 
		p:last-child { page-break-after: never; }
		
		
		* {
		  box-sizing: border-box;
		}

		/* Create two equal columns that floats next to each other */
		/*.column1 {
		  float: left;
		  width: 50%;
		  padding: 10px;
		 
		}
		
		.column2 {
		  float: left;
		  width: 50%;
		  padding: 10px;
		  font-size: 11pt;
		 
		  }
		*/  

		/* Clear floats after the columns 
		/*.row:after {
		  content: "";
		  display: table;
		  clear: both;
		}*/
			
			table  tr td,
			table tr th{
				font-size: 9pt;
				
				
			}
			
			table.table1{
			   width : 100%;
				
				
			}
			
			.table2 {
				
				width : 100%;
				
				cellspacing : 0;
				margin-left : 10px;
				margin-right : 10px;
				
			}
			.table2 td {
						  border-width: 1px;
						  padding: 8px;
						}
			
			
			table.tb_he {
				padding-left: 80px;
				border-spacing: 0px;
				
				
			}
			.tb_he td .td_1{
				padding-left: 30px;
				font-style:bold;
				
			}
			
			.title_head {
				margin-top:70px;
				text-align :center;
			}
			.title_head span {
				font-weight: bold;
				font-size : 14pt;
			}
			.title_page {
				
				text-align :right;
				border-bottom : 1px solid #acacac;
				
			}
			.title_page span{
				background:#ACACAC;
				border: 1px solid #ACACAC;
				border-top-left-radius: 50px 20px;
				padding : 2px;
			}
			
			.fieldset1
			{
				border-style: solid;
				border-width: thin;
				border-color :  #acacac;
				
				
			
			}
			.legend1
			{
				margin-bottom: 0px;
				margin-left: 16px;
				font-size: 12px;
				font-weight: bold;
				
				border-bottom: 0px;
				padding-left: 5px;
				padding-right: 5px;
				width: auto;
			 
			}
		   .fieldset1 .box-kp{
			   
			   
				width : 13px;
				height : 13px;
				border-style: solid;
				border-width: thin;
				padding :1px;
				align-items: center;
				justify-content: center
				
		   }
		   .box-kp span{
				font-family: "DejaVu Sans Mono", monospace;
				font-size :19px;
				display: block;
				margin-top : -11px;
				margin-left: auto;
				margin-right: auto
		   }
			
           
			.fild2
			{
			    border-style: solid;
				border-width: thin;
				
			
			}
			.fild2 .legend2
			{
			  margin-bottom:0px;
			  margin-left:16px;
			  font-size:12px;
			  font-weight : 200; 
			 
			}
			.fieldset1 .box-v{
			    width : 13px;
			    height : 13px;
			    border-style: solid;
				border-width: thin;
				padding :1px;
			    align-items: center;
			    justify-content: center
				
		    }
			.box-v {
				font-family: "DejaVu Sans Mono", monospace;
			    font-size :19px;
				display: block;
				margin-top : 0px;
				margin-left: auto;
				margin-right: auto
			}			
			
			#hidden-print-div {
				display: none;
			}	
			
		</style>
	</head>
	<body>
	<main id="mains" style="margin:1em 10em 0 10em; background : #fff; padding-left : 2em; padding-right:2em; ">
    
	@include('reports.patient.pdf.resume_medical_cup')
	<p class="title_page"><span></span></p>
	<br>
	
	@include('reports.patient.pdf.layout_print_pemeriksaan_fisik')
	<p class="title_page"><span></span></p>
	<br>
	
	@include('reports.patient.pdf.layout_print_pem_lab')
    <p class="title_page"><span></span></p>	
	
	@if($data->rontgenDetail->count() > 0)
	
	@include('reports.patient.pdf.layout_print_radiologi') 
	<p class="title_page"><span></span></p>
	@endif
	@if($data->ekg)
	
    @include('reports.patient.pdf.layout_print_elektrokardiografi')
	<p class="title_page"><span></span></p>
	@endif
	@if($data->treadmill)
	
    @include('reports.patient.pdf.layout_print_treadmiil')
	<p class="title_page"><span></span></p>
	@endif
	@if($data->feses)
	
    @include('reports.patient.pdf.layout_print_feses')
	<p class="title_page"><span></span></p>
	@endif
	@if($data->audiometriDetail->count() > 0)
	
    @include('reports.patient.pdf.layout_print_audiometri')
	<p class="title_page"><span></span></p>
    @endif
	@if($data->spirometri != "")
	
    @include('reports.patient.pdf.layout_print_spirometri')	
	<p class="title_page"><span></span></p>
    @endif
	@if($data->papSmear)
	
    @include('reports.patient.pdf.layout_print_papsmear')	
    <p class="title_page"><span></span></p>	
    @endif
	
	@if($data->rectalSwab)
	
    @include('reports.patient.pdf.layout_print_rectalswab')	 
	<p class="title_page"><span></span></p>
	@endif
	
	@if($data->drugScreeningDetail->count() > 0)
	
    @include('reports.patient.pdf.layout_print_drugsreening')
    <p class="title_page"><span></span></p>	
	@endif
</main>

	</body>
</html>