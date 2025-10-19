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
	<span class="">
		HASIL PEMERIKSAAN LABORATORIUM
	</span>
</div>
<br>	
@if($data->hematologi)
		<div>
		<fieldset  class="fieldset1">
		    <legend class="legend1">Hematologi</legend>
		    <table cellspacing="0"  style="width:90%;margin-top:2px;margin-left:10px;margin-right:10px;margin-bottom:5px;">
					   <tbody>
							<tr style="">
								<td width="20%"><b>Hemoglobin (Hb)</b></td>
								<td style="" width="20%"><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->hemoglobin:'' }}</span></td>
								<td style="" width="60%" colspan="4">gr/dL (L:13-18 | P;11,5-16,5)</td>
								
							</tr>
							<tr >
								<td width=""><b>Hematokrit (Ht)</b></td>
								<td style="" width=""><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->hematokrit:'' }}</span></td>
								<td style="" width="60%" colspan="4">% (L:40-50 | P: 37-43)</td>
								
							</tr>
							<tr style="">
								<td width=""><b>Eritrosit (Eri)</b></td>
								<td style="" width=""><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->eritrosit:'' }}</span></td>
								<td style="" colspan="4">*10^6/mm3 (L:4,5-5,5 | P:4-5)</td>
								
							</tr>
							<tr>
								<td width=""><b>Leukosit (Leu)</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->leukosit:'' }}</td>
								<td style="" width="" colspan="4">/mm3 (4.000 - 11.000)</td>
								
							</tr>
							<tr style="">
								<td width=""><b>Trombosit (Trom)</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->trombosit:'' }}</td>
								<td style="" width="" colspan="4">*10^3/mm3 (150 - 400)</td>
								
							</tr>
							<tr>
								<td width=""><b>LED</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->laju_endap_darah:'' }}</td>
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
								<td style="" width="">{{ $data->hematologi?$data->hematologi->basofil:'' }}</td>
								<td style="" width="">% (0-1)</td>
								<td style="" width="">MCV</td>
								<td style="" width=""><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->mcv:'' }}</span></td>
								<td style="" width="">82-92 Femtoliter</td>
							</tr>
							<tr style="">
								<td width=""><b>Eosinofil</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->eosinofil:'' }}</td>
								<td style="" width="">% (1-3)</td>
								<td style="" width="">MCH</td>
								<td style="" width=""><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->mch:'' }}</span></td>
								<td style="" width="">27-31 Picograms/sel</td>
							</tr>
							<tr>
								<td width=""><b>Neutrofil Batang</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->neutrofil_batang:'' }}</td>
								<td style="" width="">% (2-5)</td>
								<td style="" width="">MCHC</td>
								<td style="" width=""><span style="color:red;font-weight:bold;">{{ $data->hematologi?$data->hematologi->mchc:'' }}</span></td>
								<td style="" width="">32-37 gram / dL</td>
							</tr>
							<tr style="">
								<td width=""><b>Neutrofil Segmen</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->neutrofil_segment:'' }}</td>
								<td style="" width="">% (50-70)	</td>
								<td style="" width=""></td>
								<td style="" width=""></td>
								<td style="" width=""></td>
							</tr>
							<tr>
								<td width=""><b>Limfosit</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->limfosit:'' }}</td>
								<td style="" width="">% (20-40)</td>
								<td style="" colspan="2">Golongan Darah (ABO)</td>
								<td style="">{{ $data->hematologi?$data->hematologi->golongan_darah_abo:'' }}</td>
							</tr>
							<tr style="">
								<td width=""><b>Monosit</b></td>
								<td style="" width="">{{ $data->hematologi?$data->hematologi->monosit:'' }}</td>
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
						<td style="" width="">{{ $data->urin?$data->urin->urobilinogen:'' }}</td>
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
							<td width="10%">{{ $data->kimia?$data->kimia->gds:'' }}</td>
							<td width="25%">mg/dL (60 - 200)</td>
							<td style="" width="">Bilirubin Total</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->bilirubin_total:'' }}</td>
							<td width="25%">mg/dL (0 -1 )</td>
						</tr>
						<tr>
							<td width="15%">GDP</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->gdp:'' }}</td>
							<td style="" width="">mg/dL (60 - 125)</td>
							<td style="" width="">Bilirubin Direk</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->bilirubin_direk:'' }}</td>
							<td style="" width="">mg/dL (0 - 0,25)</td>
						</tr>
						<tr style="">
							<td width="15%">2 Jam PP</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->dua_jam_pp:'' }}</td>
							<td style="" width="">mg/dL (60 - 140)</td>
							<td style="" width="">Bilirubin Indirek</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->bilirubin_indirek:'' }}</td>
							<td style="" width="">mg/dL (0 0,75)</td>
						</tr>
						<tr>
							<td width="15%">HbA1c</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->hba1c:'' }}</td>
							<td style="" width="">%(4-8)</td>
							<td style="" width="">SGOT</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->sgot:'' }}</td>
							<td style="" width="">mg/dL (L:<35 | P:<31)</td>
						</tr>
						<tr style="">
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">SGPT</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->sgpt:'' }}</td>
							<td style="" width="">mg/dL (L:<41 | P:<31)</td>
						</tr>
						<tr>
							<td width="15%">Ureum</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ureum:'' }}</td>
							<td style="" width="">mg/dL (10 -50)</td>
							<td style="" width="">Protein</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->protein:'' }}</td>
							<td style="" width="">mg/dL (6,2 - 8,4)</td>
						</tr>
						<tr style="">
							<td width="15%">Kreatinin</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->kreatinin:'' }}</td>
							<td style="" width="">mg/dL (L:0,9-1,3 | P:0,6-1,1)</td>
							<td style="" width="">Albumin</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->albumin:'' }}</td>
							<td style="" width="">mg/dL (3,5 - 5,5)</td>
						</tr>
						<tr>
							<td width="15%">Asam Urat</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->asam_urat:'' }}</td>
							<td style="" width="">mg/dL (L:3,6-8,2 | P:2,3-6,1)</td>
							<td style="" width="">Alkaline fosfatase</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->alkaline_fosfatase:'' }}</td>
							<td style="" width="">mg/dL (45 - 190)</td>
						</tr>
						<tr style="">
							<td width="15%">Trigliserida</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->trigliserida:'' }}</td>
							<td style="" width="">mg/dL (&#60; 200)</td>
							<td style="" width="">Gamma GT</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->gamma_gt:'' }}</td>
							<td style="" width="">IU/L (0-51)</td>
						</tr>
						<tr>
							<td width="15%">Kolesterol Total</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->kolesterol_total:'' }}</td>
							<td style="" width="">mg/dL (&#60;200)</td>
							<td style="" width="">Gamma GT</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->gamma_gt:'' }}</td>
							<td style="" width="">IU/L (0-51)</td>
						</tr>
						<tr style="">
							<td width="15%">HDL</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->hdl:'' }}</td>
							<td style="" width="">mg/dL (L:35-55 | P:45-65)</td>
							<td style="" width="">CK</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ck:'' }}</td>
							<td style="" width="">mg/dL (L:30-180 | P:25-150)</td>
						</tr>
						<tr>
							<td width="15%">LDL direk</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ldl_direk:'' }}</td>
							<td style="" width="">mg/dL (&#60;150)</td>
							<td style="" width="">CKMB</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ckmb:'' }}</td>
							<td style="" width="">mg/dL (&#60;10 U/L)</td>
						</tr>
						<tr style="">
							<td width="15%">LDL indirek</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->ldl_indirek:'' }}</td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
						</tr>
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
							<td style="" width="">{{ $data->serologi->hbsag }}</td>
							<td style="" width="">(Non Reaktif)</td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
						</tr>
						<tr>
							<td width="15%">Anti HBs</td>
							<td style="" width="">{{ $data->serologi->anti_hbs }}</td>
							<td style="" width="">(Non Reaktif)</td>
							<td style="" width="">Sputum BTA 1</td>
							<td style="" width="">{{ $data->kimia->spuktum_bta1 }}</td>
							<td style="" width="">(Negatif)</td>
						</tr>
						<tr style="">
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">Sputum BTA 2</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->spuktum_bta2:'' }}</td>
							<td style="" width="">(Negatif)</td>
						</tr>
						<tr>
							<td width="15%"></td>
							<td style="" width=""></td>
							<td style="" width=""></td>
							<td style="" width="">Sputum BTA 3</td>
							<td style="" width="">{{ $data->kimia?$data->kimia->spuktum_bta3:'' }}</td>
							<td style="" width="">(Negatif)</td>
						</tr>
					</tbody>
				
				
				</table>	
			</fieldset>
		</div>
		<br>
		@endif
		