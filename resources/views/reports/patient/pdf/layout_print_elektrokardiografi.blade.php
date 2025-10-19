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
<br/>
<div class="title_head">
	<span>HASIL PEMERIKSAAN ELEKTROKARDIOGRAFI</span>
</div>
<br/>
<div style=" margin-left:10px;margin-right:10px;">
	<table cellpadding="10" cellspacing="4" style="width:100%;margin-top:2px;margin-left:0px;margin-right:5px;margin-bottom:5px;">
		<tbody>
			<tr ><td width="60%" valign="top" class="" style=""><b>Hasil EKG :</b></td><td></td></tr>
			<tr ><td width="60%" valign="top" class="" style="">&nbsp;&nbsp;</td><td></td></tr>
			<tr><td width="100%" valign="top" colspan="2" style="padding-left:20px;">{{ $data->ekg?$data->ekg->hasil_ekg:'' }}</td></tr>
			<tr ><td width="60%" valign="top" class="" style="">&nbsp;&nbsp;</td><td></td></tr>
			<tr ><td width="60%" valign="top" class=""><b>Kesimpulan EKG :</b></td><td></td></tr>
			<tr ><td width="60%" valign="top" class="" style="">&nbsp;&nbsp;</td><td></td></tr>
			<tr><td width="100%" valign="top" colspan="2"  style="padding-left:20px;">{{ $data->ekg?$data->ekg->kesimpulan_ekg:'' }}</td></tr>
		</tbody>
	</table>
</div>