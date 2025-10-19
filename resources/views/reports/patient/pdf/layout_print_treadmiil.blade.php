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
									<tr><td width="">Jenis Kelamin</td><td class="td_1">{{$data['jenis_kelamin']}}</td></tr>
									<tr><td>Tanggal Lahir</td><td class="td_1">{{$data['tgl_lahir']}}</td></tr>
									<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
									<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
									<tr><td valign="top">Perusahaan</td><td class="td_1" valign="top">{{$data['perusahaan']}}</td></tr>
								</tbody>
								
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br/>
		<div class="title_head">
			<span>HASIL PEMERIKSAAN TREADMILL</span>
		</div>
		<br/>
		<div style=" margin-left:10px;margin-right:10px;">
			<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
				<tbody>
					<tr ><td width="30%" valign="top">Resting EKG</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->resting_ekg:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Bruce heart beat</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->resting_ekg:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Capaian heart beat</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->capaian_heart_beat:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Capaian menit</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->capaian_menit:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Respon heart beat</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->respon_heart_beat:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Respon Sistol</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->respon_sistol:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Respon diastol</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->respon_diastol:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Aritmia</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->aritmia:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Nyeri dada</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->nyeri_dada:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Gejala lain </td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->gejala_lain:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Perubahan segmen ST </td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->perubahan_segmen_st:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Lead </td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->lead:'' }}</span></td></tr>
				    <tr ><td width="30%" valign="top">Lead pada menit ke</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->lead_pada_menit_ke:'' }}</span></td></tr>
				    <tr style=""><td width="30%" valign="top">Normalisasi setelah</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->normalisasi_setelah:'' }}</span></td></tr>
				    <tr ><td width="30%" valign="top">Functional class</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->functional_class:'' }}</span></td></tr>
				    <tr style=""><td width="30%" valign="top">Kapasitas aerobik</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->kapasitas_aerobik:'' }}</span></td></tr>
				    <tr ><td width="30%" valign="top">Tingkat kesegaran</td><td><span style="font-style:bold;">{{  $data->treadmill?$data->treadmill->tingkat_kesegaran:'' }}</span></td></tr>
				    <tr style=""><td width="30%" valign="top">Grafik</td><td><span style="font-style:bold;">{{ $data->treadmill?$data->treadmill->grafik:'' }}</span></td></tr>
 
			</table>
		</div>