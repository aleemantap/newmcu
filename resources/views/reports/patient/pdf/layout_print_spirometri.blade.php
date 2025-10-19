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
							
							<tr><td width="">Jenis Kelamin</td><td class="td_1">{{ ($data['jenis_kelamin']=='P') ? 'Perempuan' : 'Laki-laki'}}</td></tr>
							<tr><td>Tanggal Lahir</td><td class="td_1">{{$data['tgl_lahir']}}</td></tr>
							<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
							<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
							<tr><td valign="top">Perusahaan</td><td class="td_1" valign="top">{{$data->vendorCustomer->vendor->name}}</td></tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="title_head">
			<span class="">HASIL PEMERIKSAAN SPIROMETRI</span>
	</div>
	<br/>
		<fieldset  class="fieldset1" style="width:70%">
		<legend class="legend1">Best Value Methode</legend>
		<table width="90%" cellspacing="0" class="stable_adpf" style="margin : 5px 30px 10px 20px;">
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
	<div style="font-size:10pt;margin-top:10px;font-weight:bold;">Grafik Spirometri</div>
	<div style=" margin-left:10px;margin-right:10px;">
		<div id="chart_spiro" style="width: 100%;{{($spiro)?'display:block;':'display:none;'}}">		
			<img id="image-spiro"  width="100%" height="100%"  src="{{ asset(($spiro)? 'chart_spirometri/'.$spiro:'avatar1.jpg') }}" />
		</div>
		<h5 style="margin-left:15px;font-weight:bold;">Kesimpulan :</h5>
		<div style="margin-left:55px;
					margin-top:-10px;
					font-weight:300;
					text-align: justify;
					text-justify: inter-word;
					padding-right:5px;
					padding-bottom:15px;
					font-size:10pt;
					">{{ $data->spirometri?$data->spirometri->kesimpulan_spirometri:'' }}</div>
	</div>
		
<script>

</script>
	