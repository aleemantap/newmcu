<table class="table1">
		<tbody>
			<tr>
				<td width="60%">
					<div style="margin-top:-10px;padding-left:40px;  ">
						<img width="100px;" src="{{ asset('images/'.$data->vendorCustomer->vendor->image) }}" class="img-thumbnail">
					</div>
				</td>
				<td style="" width="40%">
					<table class="tb_he">
						<tbody>
							<tr ><td width="70%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
							<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
							<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'PEREMPUAN' : 'LAKI-LAKI'  }}</td></tr>
							<tr><td>Tanggal Lahir</td><td class="td_1">{{$data['tgl_lahir']}}</td></tr>
							<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
							<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
							<tr><td valign="top">Perusahaan</td><td class="td_1" valign="top">{{$data->vendorCustomer->vendor->name}}</td></tr>
							<tr><td>Paket MCU</td><td class="td_1">{{$data['paket_mcu']}}</td></tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="title_head">
			<span class="">RESUME MEDICAL CHECK UP</span>
	</div>	
	<br/>
	<table class="table2"  cellspacing="0">
		<tbody>
			<tr style="">
				<td width="30%">
					<div style="font-style:bold;">
						Diagnosis Kesehatan Kerja
					</div>
				</td>
				<td style="text-align: left; vertical-align: middle;" width="30%">
					<div style="">
					@php
						$workHealthDiagnosis  = 'FIT ON JOB';
						if($data->diagnosis->count() > 0) {
							
							$arrDiagnosis = collect();
							foreach($data->diagnosis as $d) {
								$arrDiagnosis->push([
								   'sequence' => $d->recommendation->workHealth->sequence,
								   'diagnosis' => $d->recommendation->workHealth->name
								]);
							}
							
							$getDiagnosis = collect($arrDiagnosis)->sortBy('sequence')->first();
							$workHealthDiagnosis = $getDiagnosis['diagnosis'];
							
						}
					@endphp
					<b>{{strtoupper($workHealthDiagnosis)}}</b>
					</div>
				</td>
				<td style="text-align: center; vertical-align: middle;" width="40%">
					
				</td>
			</tr>
			<tr>
				<td width="30%">
				<b>Catatan :</b><p>(HB Kurang dari 10)</p>
				</td>
				<td style="text-align: center; vertical-align: middle;" width="30%">
				</td>
				<td style="text-align: center; vertical-align: middle;" width="40%">
				</td>
			</tr>
			<tr>
				<td  colspan="3">
				<b>Saran</b><p>
				(Lorem Ipsum is simply dummy text of the printing and 
				typesetting industry. Lorem Ipsum has been the industry's standard 
				dummy text ever since the 1500s, when an unknown printer took a galley 
				of type and scrambled it to make a type specimen book. It has survived 
				not only five centuries, but also the leap into electronic typesetting, 
				remaining essentially unchanged. )
				
				</p>
				</td>
			</tr>
			<tr>
				<td  colspan="3">
				<b>Diagnosis Kerja</b>
				</td>
			</tr>
			<tr>
				<td align="justify"  width="20%">
					<b>Kategori Pemeriksaan<b/>
				</td>
				<td style="text-align: justify; vertical-align: top;" width="35%">
					<b>ICD X</b>
				</td>
				<td style="text-align: justify; vertical-align: middle;" width="45%">
					<b>Saran</b>
				</td>
			</tr>
			
				@if($data->diagnosis->count() > 0)
					<?php $i=0;  $temp_icd= "";  $temp_kategori="";  ?>
					@foreach($data->diagnosis as $d)
					
						    <?php 
							$icd_n = ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '';
							if($icd_n != "")
							{	
								if($temp_icd==$d->recommendation->icd10->name)
								{
									continue;
								}
							}	
							
							?>

							<tr style="">
								<td style="text-align: justify; vertical-align: top;">{{ $d->recommendation->formulaDetail->formula->rumus->rumusDetail->parameter->kategori}}</td> 
								<td style="text-align: justify; vertical-align: top;">{{ ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '' }}</td>
								<td valign="top" style="text-align: justify; vertical-align: top;">{{ ($d->recommendation->recommendation) ? $d->recommendation->recommendation : ''  }}</td>
							</tr>
							
							<?php 
							
								$temp_icd      = ($d->recommendation->icd10) ? $d->recommendation->icd10->name : '';
								$temp_kategori = $d->recommendation->formulaDetail->formula->rumus->rumusDetail->parameter->kategori;
							  
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
	<table class="table2" style="margin-top:25px;margin-bottom:30px;">
		<tr>
			<td>
			</td>
			<td width="30%">
				<div class="row_ttd">
				  <div class="cell_ttd" style="text-align: center;">
					<div>Dokter Pemeriksa Kesehatan Tenaga Kerja</div>
					<div>dr. Ade Budi Setiawan</div>
					<div>
						<img style="margin-top:1px;" src="{{ asset('img/ttd1.png') }}" >
					</div>
					<div>No Register PJK3 Kemenakertrans</div>
					<div>KEP.49/BINWSK3-PNK3/KK/II/2016</div>
				  </div>
			   </div>
			</td>
		</tr>
	</table>
	<footer>
		<div class="foot">
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
	</footer>