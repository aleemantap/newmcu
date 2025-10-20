<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style>
	.pie-chart {
		width: 900px;
		height: 500px;
		margin: 0 auto;
	}
</style>

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
	.header {
	         position: fixed;
			 top: 3px;

			 }

	footer {
			  position: fixed;
			  bottom: 3px;
    		  font-size: 8pt;
			  height: 270px;
			 }
	footer.foot_ttd{
				bottom:280px;
				display: block;

			}

	footer.foot{
		        margin-top: 20px;
				width: 100%;

				 text-align: center;
				 justify-content: center;
				 align-items: center;
				 display: block;

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


		.table_ttd {display:block;}
		.row_ttd { display:block;}
		.cell_ttd {display:inline-block;}

		table  tr td,
		table tr th{
			font-size: 9pt;
		}
		table.table1{

			width : 100%;

			margin-left : 10px;
			margin-right : 10px;
			border-spacing: 0px;


		}

		.box {
			padding-left:40px;
			margin-top:-70px;

		}

		table.table_adpf{
			width:800px;
		}
		.table_adpf . {
			background : #e6e6e6;
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
		.td_1{
			padding-left: 10px;

		}
		.tb_he {
			padding-left: 80px;
			border-spacing: 0px;

		}
	    .title_head {
			margin-top:180px;
		}
		 .img-sign {
		    position: absolute;
			margin-top: 9px;
			margin-right : 20px;
		  
	   }
	   
	   .mgA1 {
		  z-index: 1;
		   
		}
		.imgB1 {
		  z-index: 3;
		  
		   width : 200px;
		   
		}
    </style>
	<style>


.fieldset1
{
	border-style: solid;
	border-width: thin;


}
.legend1
{
  margin-bottom:0px;
  margin-left:16px;
  font-size:12px;
  font-weight: bold;


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
</style>

</head>
<body>
	  <main>
	    <div class="header" style="">
			<table class="table1">
			<tbody>
				<tr>
					<td width="50%">
						<div class="box" style="">
							<img width="100" src="{{$logo}}" >
							<!-- <img width="100" src="{{public_path('storage/vendor/'.$data->vendorCustomer->vendor->image)}}" > -->
						</div>
					</td>
					<td style="" width="50%">
						<table class="tb_he">
							<tbody>
								<tr>
									<td width="40%" valign="top">Medical ID#</td>
									<td width="60%" class="td_1" valign="top">{{$data['id']}}</td>
								</tr>
								<tr>
									<td valign="top">Nama</td>
									<td class="td_1" valign="top">{{$data['nama_pasien']}}</td>
								</tr>
								<tr>
									<td width="">Jenis Kelamin</td>
									<td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td>
								</tr>
								<tr>
									<td>Tanggal Lahir</td>
									<td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td>
								</tr>
								<tr>
									<td>NIP</td>
									<td class="td_1">{{$data['no_nip']}}</td>
								</tr>
								<tr>
									<td>Bagian</td>
									<td class="td_1">{{$data['bagian']}}</td>
								</tr>
								<tr>
									<td valign="top">Perusahaan</td>
									<td class="td_1" valign="top">
										{{ $data->vendorCustomer->customer->name }}
									</td>
								</tr>
								<tr>
									<td>Paket MCU</td>
									<td class="td_1">{{$data['paket_mcu']}}</td>
								</tr>
							</tbody>
						</table>
					</td>
					</tr>
				</tbody>
			</table>
		</div>
	    <div class="title_head" style="height: 620px;">
			<center>
				<h3>RESUME MEDICAL CHECK UP</h3>
			</center>
			<br/>
			<table class="table2"  cellspacing="0">
				<tbody>
					<tr style="">
						<td width="30%">
							<div style="font-style:bold;">
								Diagnosis Kesehatan Kerja
							</div>
						</td>
						<td style="text-align: center; vertical-align: middle;" width="30%">
							<div style="">
							@php
								$workHealthDiagnosis  = 'FIT ON JOB';
								if($data->diagnosis->count() > 0) {

									$arrDiagnosis = collect();
									foreach($data->diagnosis->where('deleted',0) as $d) {
										$arrDiagnosis->push([
										   'sequence' => $d->recommendation->workHealth->sequence,
										   'diagnosis' => $d->recommendation->workHealth->name
										]);
										
									}

									$getDiagnosis = collect($arrDiagnosis)->sortBy('sequence')->first();
									$workHealthDiagnosis = $getDiagnosis['diagnosis'];

								}
								$sts_diag = ($workHealthDiagnosis) ? strtoupper($workHealthDiagnosis) : 'Normal Condition';
							@endphp
							<b>{{ $sts_diag }}</b> 
							</div>
						</td>
						<td style="text-align: center; vertical-align: middle;" width="40%">
						 
						</td>
					</tr>
					<tr>
						<td colspan="3">
						<b>Catatan </b><p>{{$data['catatan']}}</p>
						</td>
						
					</tr>
					<tr>
						<td  colspan="3">
						<b>Saran</b><p>
						{{$data['saran']}}

						</p>
						</td>
					</tr>
					<tr>
						<td  colspan="3">
						<b>Diagnosis Kerja</b>
						</td>
					</tr>
					
					<tr>
						<td  colspan="4">
							<div style="font-style: italic bold;">Hasil resume ada di Lampiran</div>
						</td>
					</tr>
					

				</tbody>
				</table>
				
	    </div>

		<footer>
			<table style="width: 100%;">
			    <tr>
			     	<td style="text-align:left;">
					    <div class="" style="margin-left:-100px;font-size:10pt;">					    

							<div xclass="table_ttd">
							   <div xclass="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
									<div>Konsultasikan Hasil</div>
									<div>Medical Check Up Anda</div>
									<div>Kepada Dokter Konsultan Kami</div>
									
									<div>
										<img height="100" src="{{ public_path('img/qr-WAMCU.png') }}" >
									</div>
									<div>Whatsapp</div>
									<div style="font-weight:bold;">0811 9407 055</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
						  <br/>
						 
				    </td>
					<td xstyle="text-align:right;">
						<div class="" style="margin-right:-140px;font-size:10pt;">
						    

							<div class="table_ttd">
							   <div class="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
									<div>Dokter Pemeriksa Kesehatan Tenaga Kerja</div>
									<div>{{ $data->vendorCustomer->vendor->doctor_name}}</div>
									
									<div>
								    	<img height="100" src="{{$sign}}" >
										<!-- <img height="100" src="{{ public_path('storage/vendor/'.$data->vendorCustomer->vendor->sign) }}" > -->
									</div>
									<div>No Register PJK3 Kemenakertrans</div>
									<div>{{ $data->vendorCustomer->vendor->doctor_license}}</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
					</td>
				</tr>
				<tr>
					
					<td style="text-align: center;" colspan="2">
						<div class="footx" style="margin-top:-30px;">
							 <div>{{$data->vendorCustomer->vendor->name}} </div>
							 <div>{{$data->vendorCustomer->vendor->address1}} {{$data->vendorCustomer->vendor->zip_code}}</div>
							 <div>
								 @if($data->vendorCustomer->vendor->fax)
									Telp : {{$data->vendorCustomer->vendor->phone}} -  Fax :  {{$data->vendorCustomer->vendor->fax}}
								 @else
									Telp : {{$data->vendorCustomer->vendor->phone}}
								 @endif
							 </div>
							<div>Email : {{$data->vendorCustomer->vendor->email}} </div>
						</div>

					</td>
				</tr>
			</table>
	    </footer>
		
		<p></p>
		<div>
			<center>
				<h3>LAMPIRAN RESUME MEDICAL CHECK UP</h3>
			</center>
			<br/>
			<table class="table2"  cellspacing="0">
				<tbody>
					
					<tr>
						<td  width="25%">
							<b>Kategori Pemeriksaan</b>
						</td>
						<td style="text-align: justify; vertical-align: top;" width="35%">
							<b>ICD X</b>
						</td>
						<td style="text-align: justify; vertical-align: middle;" width="45%">
							<b>Saran</b>
						</td>
					</tr>
					    <?php $coun_char = 0; ?> 
						@if($data->diagnosis->where('deleted',0)->count() > 0)

							<?php
								$i=0;
								$temp_icd= "";
								$temp_kategori="";

							?>
							@foreach($data->diagnosis->where('deleted',0) as $d)

									<?php

										//if($temp_icd==$d->recommendation->icd10->name)
										//{
										//	continue;
										//}


										$icd_n = ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '';
										if($icd_n != "")
										{
											if($temp_icd==$d->recommendation->icd10->name)
											{
												continue;
											}
										}


									?>

									<tr>
									    <td style="text-align: justify; vertical-align: top;">{{ $d->recommendation->formulaDetail->formula->rumus->rumusDetail->parameter->kategori}}</td>
										<td style="text-align: justify; vertical-align: top;">{{  ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '' }}</td>
										<td valign="top" style="text-align: justify; vertical-align: top;">{{  ($d->recommendation->recommendation) ? $d->recommendation->recommendation : '' }}</td>
									</tr>

									<?php

										$w1 = $d->recommendation->formulaDetail->formula->rumus->rumusDetail->parameter->kategori;
										$w2 = ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '';
										$w3 = ($d->recommendation->recommendation) ? $d->recommendation->recommendation : '';
										//$w3 = $d->recommendation->recommendation;
										$coun_char = $w1."".$w2."".$w3."".$coun_char;
										$temp_icd=$w2;
										$temp_kategori=$d->recommendation->formulaDetail->formula->rumus->rumusDetail->parameter->kategori;

									?>
							<?php $i++; ?>
							@endforeach
						@else
							<tr style="">
								<td valign="top"></td>
								<td valign="top">Normal Condition</td>
								<td valign="top">Pertahankan pola hidup sehat, jaga pola makan dengan diet seimbang, olah raga teratur dan istirahat yang cukup karena saat ini anda dalam kondisi sehat</td>
							</tr>
						@endif

				</tbody>
				</table>
	    </div>
		@if($data->umum->nadi != null or $data->umum->suhu != null or $data->umum->respirasi != null)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<center class="title_head">
				<h3>ANAMNESIS DAN PEMERIKSAAN FISIK</h3>
		</center>
		<div style="font-size: 10pt;">Tanggal Pemeriksaan {{ date("d/m/Y", strtotime($data['tgl_input'])) }} </div>
		

		<fieldset  class="fieldset1">
			<legend class="legend1">Kebiasaan Dan Pekerjaan</legend>
			<table border="" cellspacing="0" class="table_adpf" style="margin : 5px 30px 10px 20px;">
					   <tbody>
							<tr class="">
								<td width="">Olahraga</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->olahraga == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div></td>
								<td style="" width="">Frekuensi Per Minggu</td>
								<td style="" width="">{{ $data->riwayat->frekuensi_per_minggu }}</td>
								<td style="" width="">x/minggu</td>
							</tr>
							<tr class="">
								<td width="">Merokok</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->merokok == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div></td>
								<td style="" width="">Bungkus Per Hari</td>
								<td style="" width="">{{ $data->riwayat->rokok_bungkus_per_hari }}</td>
								<td style="" width="">bungkus/hari</td>
							</tr>
							<tr class="">
								<td width="">Kopi</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->kopi == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div> </td>
								<td style="" width="">Gelas Per Hari</td>
								<td style="" width="">{{ $data->riwayat->kopi_gelas_per_hari }}</td>
								<td style="" width="">gelas/hari</td>
							</tr>
							<tr class="">
								<td width="">Alkohol</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->alkohol == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div></td>
								<td style="" width="">Sebanyak</td>
								<td style="" width="">{{ $data->riwayat->alkohol_sebanyak }}</td>
								<td style="" width="">gelas/hari</td>
							</tr>
							<tr class="">
								<td width="">Lama Tidur Perhari</td>
								<td style="" width="" align="">{{ $data->riwayat->lama_tidur_per_hari }}</td>
								<td style="" width="">Jam</td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr class="">
								<td width="">Rawat Inap</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->pernah_rawat_inap == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div> </td>
								<td style="" width="">Selama</td>
								<td style="" width="">{{ $data->riwayat->hari_lama_rawat_inap }}</td>
								<td style="" width="">hari</td>
							</tr>
							<tr class="">
								<td width="">Rawat inap karena penyakit</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->rawat_inap_penyakit == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr class="">
								<td width="">Pernah kecelakaan Kerja</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->pernah_kecelakaan_kerja == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div> </td>
								<td style="" width="">Pada Tahun</td>
								<td style="" width="">{{ $data->riwayat->tahun_kecelakaan_kerja }}</td>
								<td style="" width=""></td>
							</tr>
							<tr class="">
								<td width="">Tempat kerja berbahaya</td>
								<td style="" width=""><div class="box-kp"><span>{{ ($data->riwayat->tempat_kerja_berbahaya == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div> </td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
						<tbody>
				</table>
		</fieldset>
		<style>

			.fild2
			{
			    border-style: solid;
				border-width: thin;


			}
			.fild2 .legend2
			{
			  margin-bottom:0px;
			  margin-left:16px;
			  font-size:10px;
			  font-weight : bold;

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
				margin-top : -11px;
				margin-left: auto;
				margin-right: auto
			}
		</style>
		<div style=" border-radius:8px; margin :5px 0px 0 10px; padding-left:21px;">
			<table cellspacing="0" width="100%">
				<tr>
					<td width="60%">
						<table width="100%">
							<tr><td width="47%"><b>Keluhan utama</b></td> <td>{{ $data->riwayat->keluhan_utama }}</td></tr>
							<tr><td><b>Riwayat Alergi</b></td> <td>{{ $data->riwayat->riwayat_alergi }}</td></tr>
							<tr><td><b>Riwayat Penyakit Sekarang</b></td><td>{{ $data->riwayat->riwayat_penyakit_sekarang }}</td></tr>
							<tr><td><b>Riwayat Kesehatan Dahulu</b></td><td>{{ $data->riwayat->riwayat_kesehatan_dahulu }}</td></tr>
							<tr><td><b>Riwayat Kesehatan Keluarga</b></td><td>{{ $data->riwayat->riwayat_kesehatan_keluarga }}</td></tr>
							<tr><td><b>Riwayat Kesehatan Pribadi</b></td><td>{{ $data->riwayat->riwayat_kesehatan_pribadi }}</td></tr>
						</table>
					</td>
					<td width="40%">
						<fieldset style="" class="fild2">
							<legend class="legend2">Antropometri</legend>
							<table width="100%">
								<tr><td  width="47%"><b>Tinggi Badan</b></td><td>{{ $data->antrovisus->tinggi_badan }}</td><td>cm</td></tr>
								<tr><td><b>Berat Badan</b></td><td>{{ $data->antrovisus->berat_badan }}</td><td>Kg</td></tr>
								<tr><td><b>BMI</b></td><td  colspan="2">{{ $data->antrovisus->bmi }}</td></tr>
								<tr><td><b>Kategori BMI</b></td><td colspan="2">
								@if($data->antrovisus->bmi > 39.9)
											<span style="color:red;">Obese III</span>
								@elseif ($data->antrovisus->bmi > 34.9)
 											<span style="color:red;">Obese II</span>

								@elseif ($data->antrovisus->bmi > 29.9)
											<span style="color:red;">Obese I</span>
								@elseif($data->antrovisus->bmi > 24.9)
											<span style="color:black;">Overweight</span>

								@elseif($data->antrovisus->bmi > 18.5)
										Normal
								@else
										<span style="color:red;">Underweight</span>
								@endif

								</td></tr>
							</table>
						</fieldset>

					</td>
				</tr>
			</table>
		</div>
		<fieldset  class="fieldset1">
		<legend class="legend1">Tanda Vital</legend>
			<table border="" cellspacing="0" width="100%">
				<tbody>
						<tr class="">
							<td width="">Nadi</td>
							<td style="" width="">{{ $data->umum->nadi }}</td>
							<td style="" width="">x menit</td>
							<td style="" width="">Denyut Nadi</td>
							<td style="" width="">
                                @if($data->umum->nadi == null)
                                    <span></span>
                                @elseif($data->umum->nadi < 50)
                                    <span class="text-danger"><strong>Bradikardia</strong></span>
                                @elseif($data->umum->nadi > 100)
                                    <span class="text-danger"><strong>Takikardia</strong></span>
                                @else
                                    <span>Normokardia</span>
                                @endif
							</td>
						</tr>
						<tr>
							<td width="">Respirasi</td>
							<td style="" width="">{{$data->umum->respirasi}}</td>
							<td style="" width="">x/menit</td>
							<td style="" width="">Kategori JNC VII (Sistolik)</td>
							<td style="" width="">
                                @if($data->umum->sistolik == null)
                                    <span></span>
                                @elseif($data->umum->sistolik < 90)
                                    <span class="text-danger"><strong>Hypotension</strong></span>
                                @elseif($data->umum->sistolik >= 90 and $data->umum->sistolik <= 120)
                                    <span>Normotension</span>
                                @elseif($data->umum->sistolik > 120 and $data->umum->sistolik < 140)
                                    <span class="text-danger"><strong>PreHypertension</strong></span>
                                @elseif($data->umum->sistolik >= 140 and $data->umum->sistolik < 160)
                                    <span class="text-danger"><strong>Hypertension Grade 1 (Sistolik)</strong></span>
                                @else
                                    <span class="text-danger"><strong>Hypertension Grade 2 (Sistolik)</strong></span>
                                @endif
							</td>
						</tr>
						<tr class="">
							<td width="">Suhu Tubuh</td>
							<td style="" width="">{{ $data->umum->suhu }}</td>
                            <td style="" width=""></td>
                            <td style="" width="">Kategori JNC VII (Diastolik)</td>
							<td style="" width="">
                                @if($data->umum->diastolik == null)
                                    <span></span>
                                @elseif($data->umum->diastolik < 70)
                                    <span class="text-danger"><strong>Hypotension</strong></span>
                                @elseif($data->umum->diastolik >= 70 and $data->umum->diastolik <=80)
                                    <span>Normotension</span>
                                @elseif($data->umum->diastolik > 80 and $data->umum->diastolik < 90)
                                    <span class="text-danger"><strong>PreHypertension</strong></span>
                                @elseif($data->umum->diastolik >= 90 and $data->umum->diastolik < 100)
                                    <span class="text-danger"><strong>Hypertension Grade 1 (Diastolik)</strong></span>
                                @else
                                    <span class="text-danger"><strong>Hypertension Grade 2 (Diastolik)</strong></span>
                                @endif
							</td>
						</tr>
						<tr>
							<td width="">Tekanan Darah</td>
							<td style="" width="">{{ $data->umum->sistolik}} / {{$data->umum->diastolik}}</td>
							<td style="" width="">mmHg</td>
                            <td></td>
                            <td></td>
						</tr>
				<tbody>
			</table>
		</fieldset>
		<fieldset  class="fieldset1">
		    <legend class="legend1">Visus Dan Refraksi</legend>
			<table border="" cellspacing="0" width="100%">
				<tbody>
					<tr class="">
						<td width=""><b>Visus Kanan</b></td>
						<td style="" width="">{{ $data->antrovisus->visus_kanan }}</td>
						<td style=""><b>Spheris Kanan</b></td>
						<td style="" >{{ $data->antrovisus->spheris_kanan }}</td>
						<td style="" width=""><b>Spheris Kiri</b></td>
						<td style="" width="">{{ $data->antrovisus->spheris_kiri }}</td>
						<td style="" width=""><b>Pupil Distance</b></td>
						<td style="" width="">{{ $data->antrovisus->pupil_distance }}</td>
					</tr>
					<tr>
						<td width=""><b>Visus Kiri</b></td>
						<td style="" width="">{{ $data->antrovisus->visus_kiri }}</td>
						<td style=""><b>Cylinder Kanan</b></td>
						<td style="" >{{ $data->antrovisus->cylinder_kanan }}</td>
						<td style="" width=""><b>Cylinder Kiri</b></td>
						<td style="" width="">{{ $data->antrovisus->cylinder_kiri }}</td>
						<td style="" width=""><b>Rekomendasi  Kacamata</b></td>
						<td style="" width=""><div class="box-v"><span>{{ ($data->riwayat->rekomendasi_kacamatan == 'Y')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span></div></td>
					</tr>
					<tr class="">
						<td width=""></td>
						<td style="" width=""></td>
						<td style=""><b>Axis Kanan</b></td>
						<td style="" >{{ $data->antrovisus->axis_kanan }}</td>
						<td style="" width=""><b>Axis Kiri</b></td>
						<td style="" width="">{{ $data->antrovisus->axis_kiri }}</td>
						<td style="" width=""></td>
						<td style="" width=""></td>
					</tr>
					<tr class="">
						<td width=""></td>
						<td style="" width=""></td>
						<td style=""><b>Addition Kanan</b></td>
						<td style="" >{{ $data->antrovisus->addition_kanan }}</td>
						<td style="" width=""><b>Addition Kiri</b></td>
						<td style="" width="">{{ $data->antrovisus->addition_kiri }}</td>
						<td style="" width=""></td>
						<td style="" width=""></td>
					</tr>

				<tbody>
			</table>
		</fieldset>

		@if($data->fisik)
		<fieldset  class="fieldset1">
		    <legend class="legend1">Visus Dan Refraksi</legend>
			<table border="" cellspacing="0" width="100%">
				<tr>
					<td width="50%">

						<table border="" cellspacing="0" width="100%">
							<tbody>
								<tr class="">
									<td width="30%"><b>Kepala</b></td>
									<td style="text-align:left;" width="">{{ $data->fisik?$data->fisik->kepala:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Mata</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->mata:'' }}</td>
								</tr>
								<tr class="">
									<td width=""><b>Telinga</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->telinga:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Hidung</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->hidung:'' }}</td>
								</tr>
								<tr class="">
									<td width=""><b>Tenggorokan</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->tenggorokan:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Leher</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->leher:'' }}</td>
								</tr>


							</tbody>
						</table>

					</td>
					<td width="50%">
						<table border="" cellspacing="0" width="100%">
							<tbody>

								<tr class="">
									<td width=""><b>Mulut</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->mulut:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Gigi</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->gigi:'' }}</td>
								</tr>
								<tr class="">
									<td width=""><b>Dada</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->dada:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Abdomen</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->abdomen:'' }}</td>
								</tr>
								<tr class="">
									<td width=""><b>Extremitas</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->extremitas:'' }}</td>
								</tr>
								<tr>
									<td width=""><b>Anogenital</b></td>
									<td style="" width="">{{ $data->fisik?$data->fisik->anogenital:'' }}</td>
								</tr>
							</tbody>
						</table>

					</tr>
				</tr>
			</table>

			</table>
		</fieldset>
		@endif
		@endif
		
		@if($data->hematologi or $data->kimia or $data->urin)
	    <p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he" >
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="margin-top:-30px;">
			<center class="title_head">
				<h3>HASIL PEMERIKSAAN LABORATORIUM</h3>
			</center>
		</div>
		@if($data->hematologi)
		<div>
		<fieldset  class="fieldset1">
		    <legend class="legend1">Hematologi</legend>
		    <table cellspacing="0"  style="width:100%;margin-top:-1px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
					   <tbody>
							<tr style="">
								<td width="20%"><b>Hemoglobin (Hb)</b></td>
								<td style="" width="20%"><?php echo \App\Helpers\ReportHelp::Hemoglobin($data->hematologi?$data->hematologi->hemoglobin:'',$data['jenis_kelamin']);?></td>
								<td style="" width="60%" colspan="4">gr/dL (L:13-18 | P;11,5-16,5)</td>

							</tr>
							<tr >
								<td width=""><b>Hematokrit (Ht)</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Hematokrit($data->hematologi?$data->hematologi->hematokrit:'',$data['jenis_kelamin']);?></td>
								<td style="" width="60%" colspan="4">% (L:40-50 | P: 37-43)</td>

							</tr>
							<tr style="">
								<td width=""><b>Eritrosit (Eri)</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Eritrosit($data->hematologi?$data->hematologi->eritrosit:'',$data['jenis_kelamin']);?></td>
								<td style="" colspan="4">*10<sup>6</sup>/mm<sup>3</sup> (L:4,5-5,5 | P:4-5)</td> 

							</tr>
							<tr>
								<td width=""><b>Leukosit (Leu)</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Leukosit($data->hematologi?$data->hematologi->leukosit:'');?></td>
								<td style="" width="" colspan="4">/mm<sup>3</sup> (4.000 - 11.000)</td> 

							</tr>
							<tr style="">
								<td width=""><b>Trombosit (Trom)</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Trombosit($data->hematologi?$data->hematologi->trombosit:'');?></td>
								<td style="" width="" colspan="4">*10<sup>3</sup>/mm<sup>3</sup> (150 - 400)</td> 
							</tr>
							<tr>
								<td width=""><b>LED</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::LED($data->hematologi?$data->hematologi->laju_endap_darah:'',$data['jenis_kelamin']);?></td>
								<td style="" width="" colspan="4">mm/jam (L:0-10 | P:0-15)</td>

							</tr>
							<tr style="">
								<td width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr style="">
								<td width=""><b>Hitung Jenis</b></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr>
								<td width=""><b>Basofil</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Basofil($data->hematologi?$data->hematologi->basofil:'');?></td>
								<td style="" width="">% (0-1)</td>
								<td style="" width="">MCP</td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::MCV($data->hematologi?$data->hematologi->mcv:'');?></td>
								<td style="" width="">82-92 Femtoliter</td>
							</tr>
							<tr style="">
								<td width=""><b>Eosinofil</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Eosinofil($data->hematologi?$data->hematologi->eosinofil:'');?></td>
								<td style="" width="">% (1-3)</td>
								<td style="" width="">MCH</td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::MCH($data->hematologi?$data->hematologi->mch:'');?></td>
								<td style="" width="">27-31 Pgrams/sel</td>
							</tr>
							<tr>
								<td width=""><b>Neutrofil Batang</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Neutrofil_batang($data->hematologi?$data->hematologi->neutrofil_batang:'');?></td>
								<td style="" width="">% (2-5)</td>
								<td style="" width="">MCHC</td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Mchc($data->hematologi?$data->hematologi->mchc:'');?></td>
								<td style="" width="">32-37 gram / dL</td>
							</tr>
							<tr style="">
								<td width=""><b>Neutrofil Segmen</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Neutrofil_segment($data->hematologi?$data->hematologi->neutrofil_segment:'');?></td>
								<td style="" width="">% (50-70)	</td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr>
								<td width=""><b>Limfosit</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Limfosit($data->hematologi?$data->hematologi->limfosit:'');?></td>
								<td style="" width="">% (20-40)</td>
								<td style="" colspan="2">Golongan Darah (ABO)</td>
								<td style="">{{ $data->hematologi?$data->hematologi->golongan_darah_abo:'' }}</td>
							</tr>
							<tr style="">
								<td width=""><b>Monosit</b></td>
								<td style="" width=""><?php echo \App\Helpers\ReportHelp::Monosit($data->hematologi?$data->hematologi->monosit:'');?></td>
								<td style="" width="">% (2-6)</td>
								<td style="" width="" colspan="2">Golongan Darah (Rh)</td>
								<td style="" >{{ $data->hematologi?$data->hematologi->golongan_darah_rh:'' }}</td>

							</tr>

						<tbody>
			</table>
		</fieldset>
		</div>
		@endif  
		@if($data->urin)
		<div>
		<fieldset  class="fieldset1">
		    <legend class="legend1">Urinalisis</legend>
		    <table cellspacing="0"  style="width:100%;margin-top:2px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
				<tbody>
					<tr style="">
						<td width="15%">Warna</td>
						<td style="" width="">{{ $data->urin?$data->urin->warna_urin:'' }}</td>
						<td style="" width="">(Kuning)</td>
						<td style="" width="">Keton</td>
						<td style="" width="">{{ $data->urin?$data->urin->keton:'' }}</td>
						<td style="" width="">(Negatif)</td>
					</tr>
					<tr>
						<td width="15%">Kejernihan</td>
						<td style="" width="">{{ $data->urin?$data->urin->kejernihan:'' }}</td>
						<td style="" width="">(Jernih)</td>
						<td style="" width="">Leukosit Esterase</td>
						<td style="" width="">{{ $data->urin?$data->urin->leukosit_esterase:'' }}</td>
						<td style="" width="">(Negatif)</td>
					</tr>
					<tr style="">
						<td width="15%">Ph</td>
						<td style="" width="">{{ $data->urin?$data->urin->ph:'' }}</td>
						<td style="" width=""></td>
						<td style="" width="">Sedimen Leukosit</td>
						<td style="" width=""> {{ $data->urin?$data->urin->sedimen_leukosit:'' }}</td>
						<td style="" width="">per lpk</td>
					</tr>
					<tr>
						<td width="15%">Berat Jenis</td>
						<td style="" width="">{{ $data->urin?$data->urin->berat_jenis:'' }}</td>
						<td style="" width="">(Jernih)</td>
						<td style="" width="">Sedimen Eritrosit</td>
						<td style="" width="">{{ $data->urin?$data->urin->sedimen_eritrosit:'' }}</td>
						<td style="" width="">per lpk</td>
					</tr>
					<tr style="">
						<td width="15%">Protein Urin</td>
						<td style="" width="">{{ $data->urin?$data->urin->protein_urin:'' }}</td>
						<td style="" width="">(Negatif)</td>
						<td style="" width="">Epitel</td>
						<td style="" width="">{{ $data->urin?$data->urin->epitel:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
					<tr>
						<td width="15%">Reduksi</td>
						<td style="" width="">{{ $data->urin?$data->urin->reduksi:'' }}</td>
						<td style="" width="">(Negatif)</td>
						<td style="" width="">Silinder</td>
						<td style="" width="">{{ $data->urin?$data->urin->silinder:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
					<tr style="">
						<td width="15%">Nitrit</td>
						<td style="" width="">{{ $data->urin?$data->urin->nitrit:'' }}</td>
						<td style="" width="">(Negatif)</td>
						<td style="" width="">Kristal</td>
						<td style="" width="">{{ $data->urin?$data->urin->kristal:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
					<tr>
						<td width="15%">Bilirubin</td>
						<td style="" width="">{{ $data->urin?$data->urin->bilirubin:'' }}</td>
						<td style="" width="">(Negatif)</td>
						<td style="" width="">Bakteri</td>
						<td style="" width="">{{ $data->urin?$data->urin->bakteri:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
					<tr style="">
						<td width="15%">Darah</td>
						<td style="" width="">{{ $data->urin?$data->urin->darah_urin:'' }}</td>
						<td style="" width="">(Negatif)</td>
						<td style="" width="">Jamur</td>
						<td style="" width="">{{ $data->urin?$data->urin->jamur:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
					<tr>
						<td width="15%">Urobilinogen</td>
						<td style="" width=""><?php echo \App\Helpers\ReportHelp::Urobilinogen($data->hematologi?$data->hematologi->urobilinogen:'');?></td>
						<td style="" width="">mg/dL (0,2)</td>
						<td style="" width="">HCG</td>
						<td style="" width="">{{ $data->urin?$data->urin->hcg:'' }}</td>
						<td style="" width="">per lpb</td>
					</tr>
				</tbody>

			</table>
		</fieldset>
		@endif
        @if($data->kimia)
		<div>
			<fieldset  class="fieldset1">
		    <legend class="legend1">Kimia Darah Dan Sputum</legend>
				<table cellspacing="0"  style="width:100%;margin-top:2px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
					<tbody>
						<tr style="">
							<td width="10%">GDS</td>
							<td width="10%"><?php echo \App\Helpers\ReportHelp::GDS($data->kimia?$data->kimia->gds:'');?></td>
							<td width="25%">mg/dL (60 - 200)</td>
							<td style="" width="">Bilirubin Total</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::BilirubinTotal($data->kimia?$data->kimia->bilirubin_total:'');?></td>
							<td width="25%">mg/dL (0-1)</td>
						</tr> 
						<tr>
							<td width="15%">GDP</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::GDP($data->kimia?$data->kimia->gdp:'');?></td>
							<td style="" width="">mg/dL (60 - 125)</td>
							<td style="" width="">Bilirubin Direk</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::BilirubinDirek($data->kimia?$data->kimia->bilirubin_direk:'');?></td>
							<td style="" width="">mg/dL (0 - 0,25)</td>
						</tr>
						<tr style="">
							<td width="15%">2 Jam PP</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::duaJamPP($data->kimia?$data->kimia->dua_jam_pp:'');?></td>
							<td style="" width="">mg/dL (60 - 140)</td>
							<td style="" width="">Bilirubin Indirek</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::BilirubinInDirek($data->kimia?$data->kimia->bilirubin_indirek:'');?></td>
							<td style="" width="">mg/dL (0-0,75)</td>
						</tr>
						<tr>
							<td width="15%">HbA1c</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::HbA1c($data->kimia?$data->kimia->hba1c:'');?></td>
							<td style="" width=""><span>&#37;</span> (&#x3c; 6,5)</td>
							<td style="" width="">SGOT</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::SGOT($data->kimia?$data->kimia->sgot:'');?></td>
							<td style="" width="">mg/dL (15-34)</td>
						</tr>
						<tr style="">
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">SGPT</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::SGPT($data->kimia?$data->kimia->sgpt:'');?></td>
							<td style="" width="">mg/dL (15-60)</td>
						</tr>
						<tr>
							<td width="15%">Ureum</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Ureum($data->kimia?$data->kimia->ureum:'');?></td>
							<td style="" width="">mg/dL (15-39)</td>
							<td style="" width="">Protein</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Protein($data->kimia?$data->kimia->protein:'');?></td>
							<td style="" width="">mg/dL (6,2 - 8,4)</td>
						</tr>
						<tr style="">
							<td width="15%">Kreatinin</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Kreatinin($data->kimia?$data->kimia->kreatinin:'',$data['jenis_kelamin']);?></td>
							<td style="" width="">mg/dL (L:0,62-1,1 | P:0,45-0,7)</td>
							<td style="" width="">Albumin</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Albumin($data->kimia?$data->kimia->albumin:'');?></td>
							<td style="" width="">mg/dL (3,5 - 5,5)</td>
						</tr>
						<tr>
							<td width="15%">Asam Urat</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::AsamUrat($data->kimia?$data->kimia->asam_urat:'',$data['jenis_kelamin']);?></td>
							<td style="" width="">mg/dL (L:3,5 - 7,2 | P:2,6-6,0)</td>
							<td style="" width="">Alkaline fosfatase</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Alkalinefosfatase($data->kimia?$data->kimia->alkaline_fosfatase:'');?></td>
							<td style="" width="">mg/dL (45 - 190)</td> 
						</tr>
						<tr style="">
							<td width="15%">Trigliserida</td> 
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::Trigliserida($data->kimia?$data->kimia->trigliserida:'');?></td>
							<td style="" width="">mg/dL (&#60; 200)</td>
							<td style="" width="">Choline Esterase</td> 
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::CholineEsterase($data->kimia?$data->kimia->choline_esterase:'');?></td>
							<td style="" width="">U/L (4300-10500)</td> 
						</tr>
						<tr>
							<td width="15%">Kolesterol Total</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::KolesterolTotal($data->kimia?$data->kimia->kolesterol_total:'');?></td>
							<td style="" width="">mg/dL (&#60; 200)</td>
							<td style="" width="">Gamma GT</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::gammaGt($data->kimia?$data->kimia->gamma_gt:'');?></td>
							<td style="" width="">IU/L (0-51)</td> 
						</tr>
						<tr style="">
							<td width="15%">HDL</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::HDL($data->kimia?$data->kimia->hdl:'',$data['jenis_kelamin']);?></td>
							<td style="" width="">mg/dL (L:35-55 | P:45-65)</td>
							<td style="" width="">CK</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::CK($data->kimia?$data->kimia->ck:'',$data['jenis_kelamin']);?></td>
							<td style="" width="">mg/dL (L:30-180 | P:25-150)</td> 
						</tr>
						<tr>
							<td width="15%">LDL</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::LDL($data->kimia?$data->kimia->ldl_direk:'');?></td>
							<td style="" width="">mg/dL (&#60;150)</td>
							<td style="" width="">CKMB</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::CKMB($data->kimia?$data->kimia->ckmb:'');?></td>
							<td style="" width="">mg/dL (&#60;10 U/L)</td>
						</tr>
						<!-- <tr style="">
							<td width="15%">LDL indirek</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ldl_indirek:'' }}</td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
						</tr> -->
						<tr>
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">Troponin I</td>
							<td style="" width=""></td>
							<td style="" width=""></td>
						</tr>
						<tr style="">
							<td width="15%">HBSAg</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::HBSAg($data->serologi?$data->serologi->hbsag:'');?></td>
							<td style="" width="">(Non Reaktif)</td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
						</tr>
						<tr>
							<td width="15%">Anti HBS</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::AntiHBS($data->serologi?$data->serologi->anti_hbs:'');?></td>
							<td style="" width="">(Non Reaktif)</td>
							<td style="" width="">Sputum BTA 1</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::SputumBTA1($data->kimia?$data->kimia->spuktum_bta1:'');?></td>
							<td style="" width="">(Negatif)</td>
						</tr>
						<tr style="">
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">Sputum BTA 2</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::SputumBTA2($data->kimia?$data->kimia->spuktum_bta2:'');?></td>
							<td style="" width="">(Negatif)</td>
						</tr>
						<tr>
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">Sputum BTA 3</td>
							<td style="" width=""><?php echo \App\Helpers\ReportHelp::SputumBTA3($data->kimia?$data->kimia->spuktum_bta3:'');?></td>
							<td style="" width="">(Negatif)</td>
						</tr>
					</tbody>


				</table>
			</fieldset>
		</div>
		@endif
		
		@endif
		




	    @if($data->rontgenDetail->count() > 0)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN RADIOLOGI</h3>
			</center>
		</div>
		<br/>
		<table cellpadding="10"  style="width:100%;margin-top:2px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
			<tbody>
				<tr><td width="100%" valign="top" style="padding-left:10px;"><b>Pemeriksaan Radiologi :</b></td></tr>
				<tr>
					<td width="100%" valign="top" >
						<table style="width:90%;"  style="margin-left:32px;">

							<tbody>
								<?php $i=0; ?>
								<?php $temp_jf = ""; ?>
								@foreach($data->rontgenDetail as $r)


										<tr style="background:#fff;">
											 <td style="padding:10px;">{{ ($r->jenis_foto == $temp_jf) ? "" : $r->jenis_foto }}</td>
											 <td style="padding:10px;">{{ $r->parameter }}</td>
											 <td style="padding:10px;">{{ $r->temuan }}</td>
										</tr>

								 <?php $temp_jf = $r->jenis_foto; ?>
								 <?php $i++; ?>
								@endforeach

							</tbody>
						</table>
					</td>

				</tr>
				<tr><td width="100%" valign="top" style="padding-left:10px;"><b>Kesan Rontgen :</b> <i>{{ $data->rontgen?$data->rontgen->kesan_rontgen:'' }}</i></td></tr>
				<tr>
					<td width="100%" valign="top" style="padding-left:10px;" align="center">
						<img style="width:60%;object-fit: cover;" src="{{$data->rontgen->foto?'https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/rontgen/'.$data->rontgen->foto:''}}" />
				    </td>
				</tr>
			</tbody>
		</table>
		@if($ttd_r)
        <footer>
			<table style="width: 100%;">
			    <tr>
			     	<td style="text-align:left;">
					    <div class="" style="font-size:10pt;">					    

							<div xclass="table_ttd">
							   <div xclass="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
								
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
						  <br/>
						 
				    </td>
					<td xstyle="text-align:right;">
						<div class="" style="font-size:11pt;float:right;margin-right:100px;">
						    

							<div class="table_ttd">
							   <div class="row_ttd">
								  <div class="cell_ttd" style="text-align: center;" >
									<div>Tangerang, {{$tglTTD}}</div>
									<div>Radiologi</div>
									
									<div style="margin-right:-20px;">
										<img height="162" width="311" src="{{$ttd_r}}" >
									</div>
									
									<div>{{$nama_r}}</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
					</td>
				</tr>
				
			</table>
	    </footer>
		@endif
	    @endif

		@if($data->ekg)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN ELEKTROKARDIOGRAFI</h3>
			</center>
		</div>
		<br/>
		<div style="margin-left:10px;margin-right:10px;">
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:0px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr ><td width="60%" valign="top" class=""><b>Hasil EKG :</b></td><td></td></tr>
					<tr><td width="100%" valign="top" colspan="2" style="padding-left:20px;">{{ $data->ekg?$data->ekg->hasil_ekg:'' }}</td></tr>
					<tr ><td width="60%" valign="top" class=""><b>Kesimpulan EKG :</b></td><td></td></tr>
					<tr><td width="100%" valign="top" colspan="2"  style="padding-left:20px;">{{ $data->ekg?$data->ekg->kesimpulan_ekg:'' }}</td></tr>
					<tr>
						<td width="100%" valign="top" colspan="2"  style="padding-left:20px;">
						   
						   <img style="width:80%;" src="{{$data->ekg->foto?'https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/ekg/'.$data->ekg->foto:''}}" />

					    </td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/><br/>
		@if($ttd_e)
		<footer>
			<table style="width: 100%;">
			    <tr>
			     	<td style="text-align:left;">
					    <div class="" style="font-size:10pt;">					    

							<div xclass="table_ttd">
							   <div xclass="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
								
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
						  <br/>
						 
				    </td>
					<td xstyle="text-align:right;">
						<div class="" style="font-size:11pt;float:right;margin-right:100px;">
						    

							<div class="table_ttd">
							   <div class="row_ttd">
								  <div class="cell_ttd" style="text-align: center;" >
									<div>Tangerang, 14 {{$tglTTD}}</div>
									<div>Elektrokardiografi</div>
									
									<div style="margin-right:-20px;">
										<img height="162" width="311" src="{{$ttd_e}}" >
									</div>
									
									<div>{{$nama_e}}</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
					</td>
				</tr>
				
			</table>
	    </footer>
		@endif
		@endif
		

		@if($data->oae)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN OTOACOUSTIC EMISSIONS</h3>
			</center>
		</div>
		<br/>
		<div style="margin-left:10px;margin-right:10px;">
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td width="20%"><b>Grafik OAE<b></td></tr>
					</tbody>
			</table>
			<div>grafik disini</div>
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td width="20%"><b>Hasil OAE Ki<b></td><td valign="top">{{ $data->oae?$data->oae->hasil_oae_ki:'' }}</td></tr>
					<tr><td width="20%"><b>Hasil OAE Ka<b></td><td valign="top">{{ $data->oae?$data->oae->hasil_oae_ka:'' }}</td></tr>
					<tr><td width="20%"><b>Kesmipulan OAE<b></td><td valign="top">{{ $data->oae?$data->oae->kesimpulan_oae:'' }}</td></tr>
				</tbody>
			</table>
		</div>
		<div style="position:fixed;bottom:35px;margin-left:10px;font-size:8pt;">
		 13 February 2021 (tanggal Apa)
		</div>
        @endif


		@if($data->treadmill)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN TREADMILL</h3>
			</center>
		</div>
		<br/>
		<div style="margin-left:10px;margin-right:10px;">
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td width="30%">Treadmill</td><td>DIPERIKSA</td></tr>
					<tr><td width="30%">EKG Saat Istirahat</td><td> {{  $data->treadmill?$data->treadmill->	resting_ekg:'' }}</td></tr>
				</tbody>
			</table>

			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td><b>Treadmill Exercise Test (Uji Latih Jantung Dengan Beban)<b></td></tr>
					<tr><td>Digunakan protocol BRUCE, dengan target denyut jantung maksimal   <b>{{  $data->treadmill?$data->treadmill->bruce_heart_beat:'' }} <b></td></tr>
					<tr><td>Tercapai <b>{{  $data->treadmill?$data->treadmill->capaian_heart_beat:'' }} </b> dari target denyut jantung maksimal</td></tr>
				</tbody>
			</table>
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td width="40%">Test diakhiri pada menit ke {{  $data->treadmill?$data->treadmill->capaian_menit:'' }} </td><td width="15%">Aritmia</td><td>{{  $data->treadmill?$data->treadmill->aritmia:'' }}</td></tr>
					<tr><td width="40%">Respon Denyut Jantung {{  $data->treadmill?$data->treadmill->respon_diastol:'' }} x/menit </td><td width="15%">Nyeri Dada</td><td>{{  $data->treadmill?$data->treadmill->nyeri_dada:'' }}</td></tr>
					<tr><td width="40%">Respon Tekanan Darah {{  $data->treadmill?$data->treadmill->respon_sistol:'' }}</td><td width="15%">Gejala Lain</td><td>{{  $data->treadmill?$data->treadmill->	gejala_lain:'' }}</td></tr>
				</tbody>
			</table>
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td><b>Perubahan Pada Segment ST<b></td></tr>
					<tr>
						<td>Selama / Setelah Ujian Latih {{  $data->treadmill?$data->treadmill->perubahan_segmen_st:'' }}  mm, Lead {{  $data->treadmill?$data->treadmill->lead:'' }} Pada Menit ke {{  $data->treadmill?$data->treadmill->lead_pada_menit_ke:'' }} Normalisasi Setelah {{  $data->treadmill?$data->treadmill->normalisasi_setelah:'' }} </td>
					</tr>
				</tbody>
			</table>
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td colspan="2"><b>Perubahan Pada Segment ST<b></td></tr>
					<tr><td width="20%">Functional Class</td> <td>{{  $data->treadmill?$data->treadmill->functional_class:'' }}<td></tr>
					<tr><td width="20%">Kapasitas Aerobik</td> <td>{{  $data->treadmill?$data->treadmill->kapasitas_aerobik:'' }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mets<td></tr>
					<tr><td width="20%">Tingkat Kesegaran</td> <td>{{  $data->treadmill?$data->treadmill->tingkat_kesegaran:'' }}<td></tr>
				</tbody>
			</table>
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr><td><b>Kesimpulan Treadmill<b></td></tr>
					<tr><td>{{  $data->treadmill?$data->treadmill->kesimpulan_treadmill:'' }}</td></tr>
				</tbody>
			</table>


		</div>
		<div style="position:fixed;bottom:35px;margin-left:10px;font-size:8pt;">
		 13 February 2021 (tanggal Apa)
		</div>
        @endif

		@if($data->feses or $data->serologi)
		@if($data->serologi->hbsag 
				or $data->serologi->anti_hbs 
				or $data->serologi->igm_salmonella  
				or $data->serologi->igg_salmonella   
				or $data->serologi->salmonela_typhi_o   
				or $data->serologi->salmonela_typhi_h    
				or $data->serologi->salmonela_parathypi_a_o    
				or $data->serologi->salmonela_parathypi_a_h    
				or $data->serologi->salmonela_parathypi_b_o    
				or $data->serologi->salmonela_parathypi_b_h    
				or $data->serologi->salmonela_parathypi_c_o    
				or $data->serologi->salmonela_parathypi_c_h    
				or $data->serologi->hcg     
				or $data->serologi->psa      
				or $data->serologi->afp      
				or $data->serologi->cea      
				or $data->serologi->igm_toxo       
				or $data->serologi->igg_toxo       
				or $data->serologi->ckmb_serologi       
				or $data->serologi->myoglobin        
				or $data->serologi->troponin_i   
				)
		<p></p>
	    <div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		@endif

		@if($data->serologi)
			@if($data->serologi->hbsag 
				or $data->serologi->anti_hbs 
				or $data->serologi->igm_salmonella  
				or $data->serologi->igg_salmonella   
				or $data->serologi->salmonela_typhi_o   
				or $data->serologi->salmonela_typhi_h    
				or $data->serologi->salmonela_parathypi_a_o    
				or $data->serologi->salmonela_parathypi_a_h    
				or $data->serologi->salmonela_parathypi_b_o    
				or $data->serologi->salmonela_parathypi_b_h    
				or $data->serologi->salmonela_parathypi_c_o    
				or $data->serologi->salmonela_parathypi_c_h    
				or $data->serologi->hcg     
				or $data->serologi->psa      
				or $data->serologi->afp      
				or $data->serologi->cea      
				or $data->serologi->igm_toxo       
				or $data->serologi->igg_toxo       
				or $data->serologi->ckmb_serologi       
				or $data->serologi->myoglobin        
				or $data->serologi->troponin_i   
				)
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN SEROLOGI</h3>
			</center>
		</div>
		<div style="margin-left:10px;margin-right:10px;">
			<table cellpadding="7" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr>
						<td width="50%">
							<table cellpadding="7" cellspacing="0" style="width:100%">
								<tbody>
									<tr>
										<td colspan="3"><span style="font-style:bold;color:red;">HEPATITIS MARKER</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">HBSAg</span></td>
										<td align="center">{{ $data->serologi?$data->serologi->hbsag	:'' }}</td>
										<td><span style="font-style:bold;">(Non Reaktif)</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">Anti HBS</span></td>
										<td align="center">{{ $data->serologi?$data->serologi->anti_hbs	:'' }}</td>
										<td><span style="font-style:bold;">(Non Reaktif)</span></td>
									</tr>
									<tr>
										<td colspan="3"><span style="font-style:bold;color:red;">TUBERCULOSIS</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">Tubeculosis</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->tubeculosis	:'' }})</span></td>
									</tr>
									<tr>
										<td colspan="3"><span style="font-style:bold;color:red;">TUMOR MARKER</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">HCG</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->hcg	:'' }})</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">PSA</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->psa	:'' }})</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">AFP</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->afp	:'' }})</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">CEA</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->cea :'' }})</span></td>
									</tr>
									<tr>
										<td colspan="3"><span style="font-style:bold;color:red;">CARDIAC MARKER</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">CKMB</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->ckmb_serologi	:'' }})</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">Myoglobin</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->myoglobin	:'' }})</span></td>
									</tr>
									<tr>
										<td width="40%" valign="top" ><span style="font-style:bold;">Troponin</span></td>
										<td align="center"></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->troponin_i	:'' }})</span></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td width="50%" valign="top">
							<table cellpadding="7" cellspacing="0" style="width:100%">
								<tbody>
									<tr>
										<td colspan="2"><span style="font-style:bold;color:red;">TOXOPLASMA</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">IgM Toxoplasma</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->igm_toxo	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">IgG Toxoplasma</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->igg_toxo	:'' }})</span></td>
									</tr>
									<tr>
										<td colspan="2"><span style="font-style:bold;color:red;">SALMONELA</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Typhio O</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_o	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Typhio H</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_h	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia A-O</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_a_o	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia A-H</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_a_h	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia B-O</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_b_o	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia B-H</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_b_h	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia C-O</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_c_o	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">Salmonela Paratyphia C-H</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->salmonela_parathypi_c_h	:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">IgM Salmonella</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->igm_salmonella:'' }})</span></td>
									</tr>
									<tr>
										<td width="60%" valign="top"><span style="font-style:bold;">IgG Salmonella</span></td>
										<td><span style="font-style:bold;">({{ $data->serologi?$data->serologi->igg_salmonella:'' }})</span></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
			</table>
		</div>
		@endif
		@endif
		
		@if($data->feses)
		<div style="margin-top:10px;">
			<center>
				<h3>HASIL PEMERIKSAAN FESES</h3>
			</center>
		</div>
		<div style="margin-left:10px;margin-right:10px;">
			<table cellpadding="7" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Warna</span></td>
						<td>{{ $data->feses?$data->feses->warna_feses:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->warna_feses:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Kista Feses</span></td>
						<td>{{ $data->feses?$data->feses->kista:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->kista:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Konsistensi</span></td>
						<td>{{ $data->feses?$data->feses->konsistensi:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->konsistensi:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Ascaris</span></td>
						<td>{{ $data->feses?$data->feses->ascaris:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->ascaris:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Darah Feses</span></td>
						<td>{{ $data->feses?$data->feses->darah_feses:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->darah_feses:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Oxyuris</span></td>
						<td>{{ $data->feses?$data->feses->oxyuris:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->oxyuris:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Lendir Feses</span></td>
						<td>{{ $data->feses?$data->feses->lendir:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->lendir:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Serat Feses</span></td>
						<td>{{ $data->feses?$data->feses->serat:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->serat:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Eritrosit Feses</span></td>
						<td>{{ $data->feses?$data->feses->eritrosit:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->eritrosit:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Lemak Feses</span></td>
						<td>{{ $data->feses?$data->feses->lemak:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->lemak:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Leukosit Feses</span></td>
						<td>{{ $data->feses?$data->feses->leukosit:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->leukosit:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Karbohidrat Feses</span></td>
						<td>{{ $data->feses?$data->feses->karbohidrat:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->karbohidrat:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Amoeba</span></td>
						<td>{{ $data->feses?$data->feses->amoeba:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->amoeba:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Benzidine</span></td>
						<td>{{ $data->feses?$data->feses->benzidine:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->benzidine:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">Amoeba</span></td>
						<td>{{ $data->feses?$data->feses->amoeba:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->amoeba:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Benzidine</span></td>
						<td>{{ $data->feses?$data->feses->benzidine:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->benzidine:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">E Hystolitica</span></td>
						<td>{{ $data->feses?$data->feses->e_hystolitica:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->e_hystolitica:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;">Lain-lain</span></td>
						<td>{{ $data->feses?$data->feses->lain_lain:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->lain_lain:'' }}</span></td>
					</tr>
					<tr>
						<td width="20%" valign="top" ><span style="font-style:bold;">E Coli</span></td>
						<td>{{ $data->feses?$data->feses->e_coli:'' }}</td>
						<td><span style="font-style:bold;">{{ $data->feses?$data->feses->e_coli:'' }}</span></td>
						<td width="20%" valign="top"><span style="font-style:bold;"></span></td>
						<td></td>
						<td><span style="font-style:bold;"></span></td>
					</tr>

				</tbody>
			</table>
		</div>
		<div style="position:fixed;bottom:35px;margin-left:10px;font-size:8pt;">
		 13 February 2021 (tanggal Apa)
		</div>
        @endif
        @endif


		@if($data->audiometriDetail->count() > 0)
		<p></p>
	    <div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="margin-top:170px;margin-bottom:30px;">
			<center>
				<h3>HASIL PEMERIKSAAN AUDIOMETRI</h3>
			</center>
		</div>
        <div>
             <div style="height:13px;width: 100%;background: #fff;position: absolute;"></div>
           	 <img src="{{ $audiometriChart }}" width="100%" />
		   
		</div>
		<br/>
		<table style="width:100%;
				    margin-top:2px;
					margin-left:5px;
					margin-right:5px;
					margin-bottom:5px;
					border-collapse: separate;
					border-spacing: 10px;">
			<tbody>
				<tr ><td><span style="font-size:14;font-weight:bold;">Hasil Audiometri</span> </td></tr>
				<!-- <tr><td style="padding-left:20px;">{{ $data->audiometri?$data->audiometri->hasil_telinga_kiri:'' }} dan {{ $data->audiometri?$data->audiometri->hasil_telinga_kanan:'' }} (Metode Air Condution)</td></tr> -->
				<tr><td style="padding-left:20px;">{{ $data->audiometri?$data->audiometri->hasil_audiometri:'' }}</td></tr>
				<tr ><td><span style="font-size:14;font-weight:bold;">Kesimpulan Audiometri</span></td></tr>
				<tr><td style="padding-left:20px;">{{ $data->audiometri?$data->audiometri->kesimpulan_audiometri:'' }}</td></tr>
			</tbody>
		</table>
		</div>
		<br/><br/>
		
		@if($ttd_a)
		<footer>
			<table style="width: 100%;">
			    <tr>
			     	<td style="text-align:left;">
					    <div class="" style="font-size:10pt;">					    

							<div xclass="table_ttd">
							   <div xclass="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
								
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
						  <br/>
						 
				    </td>
					<td xstyle="text-align:right;">
						<div class="" style="font-size:11pt;float:right;margin-right:100px;">
						    

							<div class="table_ttd">
							   <div class="row_ttd">
								  <div class="cell_ttd" style="text-align: center;" >
									<div>Tangerang, {{$tglTTD}}</div>
									<div>Otolaringologis</div>
									
									<div style="margin-right:-20px;">
										<img height="162" width="311" src="{{$ttd_a}}" >
									</div>
									
									<div>{{$nama_a}}</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
					</td>
				</tr>
				
			</table>
	    </footer>
		@endif
		@endif
		@if($data->spirometri)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN SPIROMETRI</h3>
			</center>
		</div>
		<br/>

		<fieldset  class="fieldset1" style="width:70%">
			<legend class="legend1">Hasil Value Methode</legend>
			<table width="100%" cellspacing="0" class="stable_adpf" style="margin : 5px 30px 10px 20px;">
			   <tbody>
					<tr class="">
						<td width="" align="center">FVC</td>
						<td width=""><div style=" width:100%;background:#000;font-size:14pt; border : 1px solid #fff; color:#fff; text-align:center; font-weight:300;">
						{{ $data->spirometri?$data->spirometri->fvc:'' }}</div></td>
						<td width="" align="center">FEV1</td>
						<td width=""><div style=" width:100%;background:#000;font-size:14pt; border : 1px solid #fff; color:#fff; text-align:center; font-weight:300;">
						{{ $data->spirometri?$data->spirometri->fev:'' }}</div></td>
						<td width="" align="center">PEFR</td>
						<td width=""><div style=" width:100%;background:#000;font-size:14pt; border : 1px solid #fff; color:#fff; text-align:center; font-weight:300;">
						{{ $data->spirometri?$data->spirometri->pef:'' }}</div></td>
					</tr>
				<tbody/>
			</table>
		</fieldset>
		<h5 style="margin-left:15px;"><i>Grafik Spirometri :</i></h5>

		<div id="azzz" style="margin-left:15px;  width: 100%; height: 300px;">
            @if(file_exists(public_path('storage/spirometri/'.$data->id.'.jpg')))
            <img style="width: 100%;" src="{{ public_path('storage/spirometri/'.$data->id.'.jpg') }}" />
            @endif
		</div>

		<div style=" margin-left:10px;margin-right:10px;margin-top:200px;;">

			<h5 style="margin-left:15px;"><i>Kesimpulan :</i></h5>
			<div style="margin-left:15px;
			            margin-top:-20px;
						font-style:italic;
						font-weight:300;
						text-align: justify;
						text-justify: inter-word;
						padding-right:5px;
						padding-bottom:15px;
						font-size:10pt;
						">{{ $data->spirometri?$data->spirometri->kesimpulan_spirometri:'' }}</div>
		</div>
		@if($ttd_sp)
		<footer>
			<table style="width: 100%;">
			    <tr>
			     	<td style="text-align:left;">
					    <div class="" style="font-size:10pt;">					    

							<div xclass="table_ttd">
							   <div xclass="row_ttd">
								  <div class="cell_ttd" style="text-align: center;">
								
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
						  <br/>
						 
				    </td>
					<td xstyle="text-align:right;">
						<div class="" style="font-size:11pt;float:right;margin-right:100px;">
						    

							<div class="table_ttd">
							   <div class="row_ttd">
								  <div class="cell_ttd" style="text-align: center;" >
									<div>Tangerang, {{$tglTTD}}</div>
									<div>Spirometri</div>
									
									<div style="margin-right:-20px;">
										<img height="162" width="311" src="{{$ttd_sp}}" >
									</div>
									
									<div>{{$nama_sp}}</div>
								  </div>
							   </div>
							</div>
						</div>
						  <br/>
						  <br/>
					</td>
				</tr>
				
			</table>
	    </footer>
		@endif

	 @endif

	 @if($data->papSmear)
			@if(trim($data->papSmear->kesimpulan_pap_smear) !="")
			<p></p>
			<div class="header">
				<table class="table1">
					<tbody>
						<tr>
							<td width="50%">
								<div style="margin-top:-10px">
								</div>
							</td>
							<td style="" width="50%">
								<table class="tb_he">
									<tbody>
										<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
										<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
										<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
										<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
										<tr><td>Tanggal Lahir</td><td class="td_1">{{ date("d/m/Y/", strtotime($data['tgl_lahir']))}}</td></tr>
										<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
										<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
										<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->customer->name }}</td></tr>
									</tbody>

								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
			<div style="margin-top:140px;">
				<center>
					<h3>HASIL PEMERIKSAAN PAP SMEAR</h3>
				</center>
			</div>
			<br/>
			<div style="margin-left:10px;margin-right:10px;">
				<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:25px;margin-right:5px;margin-bottom:5px;">
					<tbody>
						<tr ><td width="30%" valign="top"><span style="font-style:bold;">Tgl. terima</span> </td> <td>{{ date("d/m/Y", strtotime($data->papSmear->tgl_terima))}}</td></tr>
						<tr style=""><td width="30%" valign="top"><span style="font-style:bold;">Tgl. selesai </span></td><td>{{ date("d/m/Y", strtotime($data->papSmear->tgl_selesai))}}</td></tr>
						<tr ><td width="30%" valign="top"><span style="font-style:bold;">Bahan pemeriksaan</span></td><td>{{ $data->papSmear?$data->papSmear->bahan_pemeriksaan:'' }}</td></tr>
						<tr style=""><td width="30%" valign="top"><span style="font-style:bold;">Makroskopik</span></td><td>{{ $data->papSmear?$data->papSmear->makroskopik:'' }}</td></tr>
						<tr ><td width="30%" valign="top"><span style="font-style:bold;">Mikroskopik</span></td><td>{{ $data->papSmear?$data->papSmear->mikroskopik:'' }}</td></tr>
						<tr style=""><td width="30%" valign="top"><span style="font-style:bold;">Mikroskopik</span></td><td></td></tr>
					</tbody>
				</table>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>

				<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:25px;margin-right:5px;margin-bottom:5px;">
					<tbody>
						<tr style=""><td width="" valign="top"><span style="font-style:bold;"></span>  </td></tr>
						<tr style=""><td width="" valign="top"><span style="font-style:bold;">Kesimpulan</span></td></tr>
						<tr style=""><td width="" valign="top" align="left">{{ $data->papSmear?$data->papSmear->kesimpulan_pap_smear:'' }}</td></tr>
						<tr style=""><td width="" valign="top" align="left"><span style="font-style:bold;"></span></td></tr>
						<tr style=""><td width="" valign="top"  align="left"></td></tr>
					</tbody>
				</table>

			</div>
	      @endif	
	    @endif	

        @if($data->rectalSwab)
		<p></p>
	    <div style="margin-top:10px;">
			<center>
				<h3><u>SURAT HASIL KETERANGAN HASIL PEMERIKSAAN</u></h3>
				<h3 style="margin-top:-16px;padding-bottom:10px;"><i>CERTIFICATE OF EXAMINATION RESULTS</i></h3>
			</center>
		</div>
		<div style="font-size:10pt;">Kami yang bertanda tangan di bawah ini, menyatakan bahwa :<br/>
		   <i>We, the undersigned, certify that the	</i>
		</div>
		<br/>
		<div>
			<table style="margin-left:20px;font-size:12pt;" cellpadding="2">
				<tbody>
					<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" style="font-style:bold;" valign="top">{{$data['id']}}</td></tr>
					<tr><td valign="top">NIP</td><td class="td_1" valign="top" style="font-style:bold;">{{$data['no_nip']}}</td></tr>
					<tr><td valign="top"><u>Nama</u><br><i>Name</i></td><td class="td_1" style="font-style:bold;" valign="top">{{$data['nama_pasien']}}</td></tr>
					<tr><td width=""><u>Jenis Kelamin</u><br><i>Sex</i></td><td class="td_1" style="font-style:bold;">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
					<tr><td><u>Tanggal Lahir</u><br><i>Date Of Birth</i></td><td class="td_1" style="font-style:bold;">{{date("d/m/Y",strtotime($data['tgl_lahir']))}}</td></tr>
					<tr><td><u>Bagian/Unit</u><br><i>Department</i></td><td class="td_1" style="font-style:bold;" >{{$data['bagian']}}</td></tr>
					<tr><td><u>Telah Dilakukan</u><br/><i>Has Been Examined</i></td><td class="td_1" style="font-style:bold;">Pemeriksaan Usap Dubur (Rectal Swab)</td></tr>
					<tr><td><u>Perusahaan</u><br/><i>Comapany</i></td><td class="td_1" style="font-style:bold;">{{ $data->vendorCustomer->customer->name }}</td></tr>
					<tr><td><u>Tanggal Pemeriksaan</u><br/><i>On Date</i></td><td class="td_1" style="font-style:bold;">{{ date("d/m/Y",strtotime($data['tgl_input'])) }}</td></tr>
					<tr><td><u>Untuk Tujuan</u><br/><i>Purpose of examination</i></td><td class="td_1" style="font-style:bold;">Skrining Kesehatan Penjamah Makanan (Food Hygiene Screeneng)</td></tr>
					<tr><td><u>Kesimpulan</u><br/><i>Conclusion</i></td><td class="td_1" style="font-style:bold;">{{ $data->rectalSwab->kesimpulan_rectal_swab }}</td></tr>
				</tbody>

			</table>
		</div>
		<br/>
		<div  style="font-style:italic;
				     text-align: justify;
				     text-justify: inter-word;
				     font-size:10pt;">Demikian surat ini saya buat dengan sebenar-benarnya berdasarkan pemeriksaan yang saya lakukan sesuai dengan keahlian dan pengetahuan saya. So I created this letter in good faith based on the examination that I do fit with my skills
		   and knowledge
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		<div style="float:right;">
			<table style="margin-right:20px;font-size:12pt;" cellpadding="2">
				<tbody>
					<tr><td valign="top"><u>Diterbitkan di</u><br><i>Published in</i></td><td class="td_1" style="font-style:bold;" valign="top">{{ $data->vendorCustomer->vendor->city}}</td></tr>
					<tr><td valign="top"><u>Diterbitkan Tanggal</u><br><i>Published on</i></td><td class="td_1" style="font-style:bold;" valign="top">{{ date('d/m/Y', strtotime($data->published_at)) }}</td></tr>
					<tr><td valign="top"><u>Berlaku sampai dengan</u><br><i>Valid until</i></td><td class="td_1" style="font-style:bold;" valign="top">{{ date('d/m/Y', strtotime('+6 month', strtotime($data->published_at))) }}</td></tr>
				</tbody>
			</table>
		</div>

		<style>


		/* Create two equal columns that floats next to each other */
		.kol1 {
		  flex: 15%;
		}

		.kol2 {
		 padding-left : 21px;
		 flex: 70%;

		}

		.rw {
		  display: flex;
		}

		</style>


		<p></p>

		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->vendor->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<br/>
		<div style="margin-top:140px;">
			<center>
				<h3>HASIL PEMERIKSAAN RECTAL SWAB</h3>
			</center>
		</div>
		<br/>
		<div style="font-size: 10pt;">Tanggal Pemeriksaan {{ date("d/m/Y",strtotime($data['tgl_input'])) }}</div>
		<br/>
		<fieldset class="fieldset1"><legend class="legend1">Riwayat Penyakit Dahulu</legend>
			<table style="margin-left:160px;">
				<tr>
					<td width="30%" style="padding:10px;">
						<div class="rw">
							<div class="box-kp kol1">
								<span>{{ ( strtolower($data->rectalSwab->typoid) == 'positif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
							</div>
							<div class="kol2">Thypoid</div>
						</div>
					</td>
					<td width="30%" style="padding:10px;">
						<div class="rw">
							<div class="box-kp kol1">
								<span>{{ ( strtolower($data->rectalSwab->disentri) == 'positif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
							</div>
							<div class="kol2">Disentri</div>
						</div>
					</td>
				</tr>
				<tr>
					<td width="30%" style="padding:10px;">
						<div class="rw">
							<div class="box-kp kol1">
								<span>{{ ( strtolower($data->rectalSwab->diare) == 'positif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
							</div>
							<div class="kol2">Diare</div>
						</div>
					</td>
					<td width="30%" style="padding:10px;">
						<div class="rw">
							<div class="box-kp kol1">
								<span>{{ ( strtolower($data->rectalSwab->kolera) == 'positif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
							</div>
							<div class="kol2">Kolera</div>
						</div>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="fieldset1"><legend class="legend1">Hasil Kulture Mikroorganisme</legend>
			<table style="margin-left:60px;">
				<tr>
					<td width="25%" style="padding:10px;font-weight:bold;">Salmonela SP</td>
					<td width="25%" style="padding:10px;">{{$data->rectalSwab->salmonella}}</td>
					<td width="25%" style="padding:10px;font-weight:bold;">E Coli SP</td>
					<td width="25%" style="padding:10px;">{{$data->rectalSwab->e_coli}}</td>
				</tr>
				<tr>
					<td width="25%" style="padding:10px;font-weight:bold;">Shigella</td>
					<td width="25%" style="padding:10px;">{{$data->rectalSwab->shigella}}</td>
					<td width="25%" style="padding:10px;font-weight:bold;">Vibrio SP</td>
					<td width="25%" style="padding:10px;">{{$data->rectalSwab->vibrio_cholera}}</td>
				</tr>
			</table>

		</fieldset>
		<table style="margin-left:60px;margin-top:20px;">
				<tr>
					<td valign="top" style="padding:10px"><b>Kesimpulan</b></td>
					<td valign="top" style="padding:10px;">{{$data->rectalSwab->kesimpulan_rectal_swab}}</td>

				</tr>
				<tr>
					<td valign="top" style="padding:10px;"><b>Saran</b></td>
					<td valign="top" style="padding:10px;">Jaga Kesehatan, kebersihan diri dan lingkungan, lakukan pemeriksaan ulang setiap 6 (enam) bulan </td>
				</tr>
		</table>
		<br/>
		<br/>
		<br/>

		<div style="float:right;">
			<table style="margin-right:20px;font-size:13pt;" cellpadding="2">
				<tbody>
					<tr><td valign="top"><u>Diterbitkan di</u><br><i>Published in</i></td><td class="td_1" style="font-style:bold;" valign="top">{{ $data->vendorCustomer->vendor->city}} </td></tr>
					<tr><td valign="top"><u>Diterbitkan Tanggal</u><br><i>Published on</i></td><td class="td_1" style="font-style:bold;" valign="top">{{ date('d/m/Y', strtotime($data->published_at)) }}</td></tr>
				</tbody>
			</table>
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>

        @endif

        @if($data->drugScreeningDetail->count() > 0)
		<p></p>
		<div class="header">
			<table class="table1">
				<tbody>
					<tr>
						<td width="50%">
							<div style="margin-top:-10px">
							</div>
						</td>
						<td style="" width="50%">
							<table class="tb_he">
								<tbody>
									<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
									<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
									<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{date("d/m/Y", strtotime($data['tgl_lahir']))}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td>Perusahaan</td><td class="td_1">{{ $data->vendorCustomer->vendor->name }}</td></tr>
								</tbody>

							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<br/>
		<div style="margin-top:100px;">
			<center>
				<h3>HASIL PEMERIKSAAN DRUG SCREENING</h3>
			</center>
		</div>
		<div style=" margin-left:10px;margin-right:10px;">
		    <h5 style="margin-left:15px;">Pemeriksaan Drug Screening :</h5>

			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:20px;margin-right:5px;margin-bottom:5px;border : thin solid;">
				<thead>
					<tr >
						<th width="25%" align="left">Tgl. Pemeriksaan</th>
						<th width="25%" align="left">Status Pemeriksaan</th>
						<th width="25%" align="left">Parameter</th>
						<th width="25%" align="left">Hasil</th>
					</tr>
				</thead>
				<tbody>
				    <?php $i=0; ?>
					@foreach($data->drugScreeningDetail as $ds)
						@if( $i % 2 == 0)
							<tr >
								<td>{{ date("d/m/Y", strtotime($ds->tgl_pemeriksaan)) }}</td>
								<td>{{ $ds->status_pemeriksaan }}</td>
								<td>{{ $ds->parameter_drug_screening }}</td>
								<td>{{ $ds->hasil_drug_screening }}</td>
							</tr>
						@else
							<tr style="">
								<td>{{ $ds->tgl_pemeriksaan }}</td>
								<td>{{ $ds->status_pemeriksaan }}</td>
								<td>{{ $ds->parameter_drug_screening }}</td>
								<td>{{ $ds->hasil_drug_screening }}</td>
							</tr>

						@endif
					<?php $i++; ?>
					@endforeach
				</tbody>
			</table>
			 <h5 style="margin-left:15px;">Kesimpulan Drug Screening :</h5>
			<div style="margin-left:15px;
			            margin-top:-20px;
						font-style:italic;
						font-weight:300;
						text-align: justify;
						text-justify: inter-word;
						padding-right:5px;
						padding-bottom:15px;
						font-size:12pt;
						">{{ $data->drugScreening->kesimpulan_drug_screening }}</div>


		</div>
        @endif

	  </main>

</body>
</html>
