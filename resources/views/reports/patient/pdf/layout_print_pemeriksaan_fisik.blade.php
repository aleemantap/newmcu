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
							<tr><td valign="top">Perusahaan</td><td class="td_1" valign="top">{{$data->vendorCustomer->vendor->name}}</td></tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="title_head">
			<span class="">RESUME PEMERIKSAAN FISIK</span>
	</div>	
	<div>Tanggal Pemeriksaan (20 Desember 2020)</div>	
	<br/>
	<style>
		
	</style>
	<fieldset  class="fieldset1">
		<legend class="legend1">Kebiasaan Dan Pekerjaan</legend>
		<table  cellspacing="0" class="" width="95%" style="margin : 1px -20px 5px 20px;">
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
		
		<div style=" border-radius:8px; margin :5px 0px 0 10px; padding-left:21px;">
			<table cellspacing="0" width="100%" >
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
						<fieldset style="" class="fieldset1">
							<legend class="legend1">Antropometri</legend>
							<table width="98%" style="margin : 1px -20px 5px 20px;">
								<tr><td  width="47%"><b>Tinggi Badan</b></td><td>{{ $data->antrovisus->berat_badan }}</td><td>cm</td></tr>
								<tr><td><b>Berat Badan</b></td><td>{{ $data->antrovisus->berat_badan }}</td><td>Kg</td></tr>
								<tr><td><b>BMI</b></td><td  colspan="2">{{ $data->antrovisus->bmi }}</td></tr>
								<tr><td><b>Kategori BMI</b></td><td colspan="2"><span style="color:red;">(Obesity 1)</span></td></tr>
							</table>
						</fieldset>
					
					</td>
				</tr>
			</table>
		</div>
		<fieldset  class="fieldset1">
		<legend class="legend1">Tanda Vital</legend>
			<table cellspacing="0" width="95%" style="margin : 1px -20px 5px 20px;" >
				<tbody>
						<tr class="">
							<td width="">Nadi</td>
							<td style="" width="">{{ $data->umum->nadi }}</td>
							<td style="" width="">x menit</td>
							<td style="" width="">Denyut Nadi</td>
							
							<td style="" width="" bgcolor="red"><span style="color:#fff;font-style:bold;" >(xxxx)</span></td>
						</tr>
						<tr>
							<td width="">Respirasi</td>
							<td style="" width="">{{$data->umum->respirasi}}</td>
							<td style="" width="">x/menit</td>
							<td style="" width=""> </td>
							<td style="" width=""></td>
						</tr>
						<tr class="">
							<td width="">Suhu Tubuh</td>
							<td style="" width="">{{ $data->umum->suhu }}</td>
							<td style="" width=""></td>
							<td style="" width="">Kategori JNC VII (Sistolik)</td>
							<td style="" width=""><span style="color:red;font-style:bold;" >{{ $data->umum->sistolik }}</span></td>
						</tr>
						<tr>
							<td width="">Tekanan Darah</td>
							<td style="" width="">()</td>
							<td style="" width="">mmHg</td>
							<td style="" width="">Kategori JNC VII (Diastolik)</td>
							<td style="" width=""><span style="color:red;font-style:bold;" >{{ $data->umum->diastolik }}</span></td>
						</tr>
				<tbody>
			</table>
		</fieldset>
		<fieldset  class="fieldset1">
		    <legend class="legend1">Visus Dan Refraksi</legend>
			<table  cellspacing="0" width="95%" style="margin : 1px -20px 5px 20px;">
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
		    <legend class="legend1">Pemeriksaan Fisik</legend>
			<table  cellspacing="0" width="95%" style="margin : 1px -20px 5px 20px;">
				<tr>
					<td width="50%">
						
						<table  cellspacing="0" width="100%">
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
						<table  cellspacing="0" width="100%">
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
									<td style="" width="">{{ $data->fisik?$data->fisik->gigi:'' }}</td>
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