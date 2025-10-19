<table class="table1">
		<tbody>
			<tr>
				<td width="60%">
					
				</td>
				<td style="" width="40%">
					<table class="tb_he">
						<tbody>
							<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
							<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
							<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
							<tr><td width="">Jenis Kelamin</td><td class="td_1">{{$data['jenis_kelamin']}}</td></tr>
							<tr><td>Tanggal Lahir</td><td class="td_1">{{$data['tgl_lahir']}}</td></tr>
							<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
							<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
							<tr><td>Perusahaan</td><td class="td_1">{{$data->vendorCustomer->vendor->name}}</td></tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
</table>
<div class="title_head">
	<span>HASIL PEMERIKSAAN RADIOLOGI</span>
</div>
<br/>
<table cellpadding="10"  style="width:100%;margin-top:2px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
	<tbody>
	<tr><td width="100%" valign="top" style="padding-left:10px;"><b>Pemeriksaan Radiologi :</b></td></tr>
	<tr>
			<td width="100%" valign="top" align="">
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
			
			<!--<td width="100%" valign="top" >
				<table style="width:90%;" style="margin-left:32px;">
					<tbody>
						<tr>
							 <td align="center"><b>Thorax PA</b></td>
							 <td style="padding:15px;">COR</td>
							 <td style="padding:15px;">CTR < 15%</td>
						</tr>
						<tr>
							 <td></td>
							 <td style="padding:15px;">Pulmo</td>
							 <td style="padding:15px;">Corakan bronkhovaskular baik</td>
						</tr>
						<tr>
							 <td></td>
							 <td style="padding:15px;">Sinus dan Diafragma</td>
							 <td style="padding:15px;">Sinus dan Diafragma baik</td>
						</tr>
						<tr>
							 <td></td>
							 <td style="padding:15px;">Tulang Dan Jaring lunak</td>
							 <td style="padding:15px;">Tulang tulang intek dan jaringan lunak baik</td>
						</tr>
					</tbody>
				</table>
			</td>	-->		
			
	</tr>
	<tr><td width="100%" valign="top" style="padding-left:10px;"><b>Kesan Rontgen :</b> <i>{{ $data->rontgen?$data->rontgen->kesan_rontgen:'' }}</i></td></tr>
	</tbody>
</table>
   