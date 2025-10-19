	    <style>
		.tb_hpp {border-spacing: 2px;}
		.tb_hpp td    {padding: 4px;}
		.tb_hpp .td_12{ font-weight : bold;}
		.tb_12 {border-spacing: 2px;}
		.tb_12 td {padding: 2px;}
		.tb_12 .td_12 { font-weight : bold; }
		</style>
		<div style="margin-top:10px;">
			<center>
				<h3 style="font-weight:bold;"><u>SURAT HASIL KETERANGAN HASIL PEMERIKSAAN</u></h3>
				<h3 style="margin-top:-16px;padding-bottom:10px;font-weight:bold;"><i>CERTIFICATE OF EXAMINATION RESULTS</i></h3>
			</center>
		</div>
		<div>Kami yang bertanda tangan di bawah ini, menyatakan bahwa :<br/>
		   <i>We, the undersigned, certify that the	</i>
		</div>
		<br/>
		<div>
			<table  class="tb_hpp" style="margin-left:20px;font-size:13pt;">
				<tbody>
					<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_12"  valign="top">{{$data['id']}}</td></tr>
					<tr><td valign="top">NIP</td><td class="td_12" valign="top" style="font-style:bold;">{{$data['no_nip']}}</td></tr>
					<tr><td valign="top"><u>Nama</u><br><i>Name</i></td><td class="td_12"  valign="top">{{$data['nama_pasien']}}</td></tr>
					<tr><td width=""><u>Jenis Kelamin</u><br><i>Sex</i></td><td class="td_12" style="font-style:bold;">{{ ($data['jenis_kelamin']=='P') ? "Perempuan" : "Laki-Laki" }}</td></tr>
					<tr><td><u>Tanggal Lahir</u><br><i>Date Of Birth</i></td><td class="td_12" style="font-style:bold;">{{$data['tgl_lahir']}}</td></tr>
					<tr><td><u>Bagian/Unit</u><br><i>Department</i></td><td class="td_12"  >{{$data['bagian']}}</td></tr>
					<tr><td><u>Telah Dilakukan</u><br/><i>Has Been Examined</i></td><td class="td_12" style="font-style:bold;">()</td></tr>
					<tr><td><u>Perusahaan</u><br/><i>Comapany</i></td><td class="td_12" style="font-style:bold;">{{$data->vendorCustomer->vendor->name}}</td></tr>
					<tr><td><u>Tanggal Pemeriksaan</u><br/><i>On Date</i></td><td class="td_12" style="font-style:bold;">{{$data['perusahaan']}}</td></tr>
					<tr><td><u>Untuk Tujuan</u><br/><i>Purpose of examination</i></td><td class="td_12" style="font-style:bold;">{{$data['perusahaan']}}</td></tr>
					<tr><td><u>Kesimpulan</u><br/><i>Conclusion</i></td><td class="td_12" style="font-style:bold;">{{$data['perusahaan']}}</td></tr>
				</tbody>
				
			</table>
		</div>
		<br/>
		<div  style="font-style:italic;justify-content:center;text-align:justify;">Demikian surat ini saya buat dengan sebenar-benarnya berdasarkan pemeriksaan yang saya lakukan sesuai<br/>
		   dengan keahlian dan pengetahuan saya.
		   So I created this letter in good faith based on the examination that I do fit with my skills
		   and knowledge
		</div> 
		<br/>
		<br/>
		<br/>
		<br/>
		<div style="float:right;">
			<table style="margin-right:20px;font-size:13pt;"  class="tb_12" width="100%" cellpadding="2">
				<tbody>
					<tr><td valign="top" width="50%"><u>Diterbitkan di</u><br><i>Published in</i></td><td class="td_12"  valign="top">(TANGERANG)</td></tr>
					<tr><td valign="top" width="50%"><u>Diterbitkan Tanggal</u><br><i>Published on</i></td><td class="td_12"  valign="top">(31 Mei 2020)</td></tr>
					<tr><td valign="top" width="50%"><u>Berlaku sampai dengan</u><br><i>Valid until</i></td><td class="td_12"  valign="top">(27 Maret 2020)</td></tr>
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
		
		
	<style>
	   
	   
		/* Create two equal columns that floats next to each other */
		.kol1 {
		  flex: 15%;
		}
      
	    .kol2 {
		 padding-left : 5px;	
		 flex: 70%;
		 
		}
		
		.rw {
		  display: flex;
		}
		
	</style>

		
	<p></p>
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
								<tr><td>Perusahaan</td><td class="td_1">{{$data['perusahaan']}}</td></tr>
								
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
	</table>
	<div class="title_head">
		<span>HASIL PEMERIKSAAN RECTAL SWAB</span>
	</div>
	<div><b>Tanggal Pemeriksaan</b> (<u>02/02/2020</u>)</div>
	<fieldset class="fieldset1"><legend class="legend1">Riwayat Penyakit Dahulu</legend>
		<table style="margin-left:160px;">
			<tr> 
				<td width="30%" style="padding:10px;">
					<div class="rw">
						<div class="box-kp kol1">
							<span>{{ ( strtolower($data->rectalSwab->typoid) == 'negatif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
						</div>
						<div class="kol2">Thypoid</div>
					</div>	
				</td>
				<td width="30%" style="padding:10px;">
					<div class="rw">
						<div class="box-kp kol1">
							<span>{{ ( strtolower($data->rectalSwab->disentri) == 'negatif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
						</div>
						<div class="kol2">Disentri</div>
					</div>
				</td>
			</tr>
			<tr> 
				<td width="30%" style="padding:10px;">
					<div class="rw">
						<div class="box-kp kol1">
							<span>{{ ( strtolower($data->rectalSwab->diare) == 'negatif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
						</div>
						<div class="kol2">Diare</div>
					</div>	
				</td>
				<td width="30%" style="padding:10px;">
					<div class="rw">
						<div class="box-kp kol1">
							<span>{{ ( strtolower($data->rectalSwab->kolera) == 'negatif')? html_entity_decode('&#10004;', ENT_COMPAT) : '' }}</span>
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
				<td valign="top" style="padding:10px;">(<u>Jaga Kesehatan, kebersihan diri dan lingkungan, lakukan pemeriksaan ulang setiap 6 (enam) bulan</u> )</td>
			</tr>
	</table>
	<br/>
	<br/>
	<br/>
	<div style="float:right;">
			<table style="margin-right:20px;font-size:13pt;"  class="tb_12" width="100%" cellpadding="2">
				<tbody>
					<tr><td valign="top" width="50%"><u>Diterbitkan di</u><br><i>Published in</i></td><td class="td_12"  valign="top">(TANGERANG)</td></tr>
					<tr><td valign="top" width="50%"><u>Diterbitkan Tanggal</u><br><i>Published on</i></td><td class="td_12"  valign="top">(31 Mei 2020)</td></tr>
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