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
	<span>HASIL PEMERIKSAAN FESES</span>
</div>
<br/>
<br/>
<div style="margin-left:10px;margin-right:10px;">
	<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
		<tbody>
			<tr ><td width="30%" valign="top">Warna</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->warna_feses:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Konsistensi</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->konsistensi:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Capaian heart beat</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->capaian_heart_beat:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Darah</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->darah_feses:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Lendir</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->lendir:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Eritrosit</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->eritrosit:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Leukosit</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->leukosit:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Amoeba</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->amoeba:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">E-Hystolitica</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->e_hystolitica:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">E-Coli</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->e_coli:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Kista </td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->kista:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Ascaris </td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->ascaris:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Oxyuris</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->oxyuris:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Serat</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->serat:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Lemak</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->lemak:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Karbohidrat</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->karbohidrat:'' }}</span></td></tr>
			<tr ><td width="30%" valign="top">Benzidine</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->benzidine:'' }}</span></td></tr>
			<tr style="background:#ffe6e6;"><td width="30%" valign="top" style="padding-left:10px;">Lain-lain</td><td><span style="font-style:bold;">{{ $data->feses?$data->feses->lain_lain:'' }}</span></td></tr>
		</tbody>	
	</table>
</div>
<br/>
<br/>