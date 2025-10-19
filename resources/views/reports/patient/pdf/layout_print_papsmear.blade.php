		<style>
			.tb_pap {
						border-spacing: 2px;
						
						border : thin solid;
						
						margin-top:2px;
						margin-left:25px;
						margin-right:5px;
						margin-bottom:5px;
						
					}
			.tb_pap th    {padding: 4px;}
			.tb_pap td    {padding: 4px;}
		</style>
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
				<span>HASIL PEMERIKSAAN PAP SMEAR</span>
		</div>
		
		<br/>
		<br/>
		<div style="margin-left:10px;margin-right:10px;">
		 	<table width="90%" class="tb_pap">
				<tbody>
					<tr ><td width="30%" valign="top">Tgl. terima </td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->tgl_terima:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Tgl. selesai </td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->tgl_selesai:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Bahan pemeriksaan</td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->bahan_pemeriksaan:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Makroskopik</td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->makroskopik:'' }}</span></td></tr>
					<tr ><td width="30%" valign="top">Mikroskopik</td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->mikroskopik:'' }}</span></td></tr>
					<tr style=""><td width="30%" valign="top">Kesimpulan</td><td><span style="font-weight:bold;">{{ $data->papSmear?$data->papSmear->kesimpulan_pap_smear:'' }}</span></td></tr>
				</tbody>	
			</table>
			
		</div>