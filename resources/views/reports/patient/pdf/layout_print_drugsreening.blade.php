		<style>
			.tb_drg {
						border-spacing: 2px;
						margin-top:2px;
						margin-left:20px;
						margin-right:1px;
						margin-bottom:5px;
						border : thin solid;
					}
			.tb_drg th    {padding: 4px;}
			.tb_drg td    {padding: 4px;}
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
								<tr><td>Perusahaan</td><td class="td_1">{{$data->vendorCustomer->vendor->name}}</td></tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="title_head">
			<span class="">HASIL PEMERIKSAAN DRUG SCREENING</span>
		</div>
		<br/>
		<div style=" margin-left:10px;margin-right:10px;">
		    <h5 style="margin-left:15px;">Pemeriksaan Drug Screening :</h5>
				
			<table width="90%" class="tb_drg" >
				<thead>
					<tr >
						<th width="25%" align="left">Tgl. Pemeriksaan</th>
						<th width="25%" align="left">Status Pemeriksaan</th>
						<th width="25%" align="left">Parameter</th>
						<th width="25%" align="left">Hasil</th>
					</tr>
				</thead>
				<tbody>
				    <?php $i=0; ?>
					@foreach($data->drugScreeningDetail as $ds)
						@if( $i % 2 == 0)
							<tr >
								<td>{{ $ds->tgl_pemeriksaan }}</td>
								<td>{{ $ds->status_pemeriksaan }}</td>
								<td>{{ $ds->parameter_drug_screening }}</td>
								<td>{{ $ds->hasil_drug_screening }}</td>
							</tr>
						@else
							<tr style="">
								<td>{{ $ds->tgl_pemeriksaan }}</td>
								<td>{{ $ds->status_pemeriksaan }}</td>
								<td>{{ $ds->parameter_drug_screening }}</td>
								<td>{{ $ds->hasil_drug_screening }}</td>
							</tr>
						
						@endif
					<?php $i++; ?>
					@endforeach
				</tbody>
			</table>
			 <h5 style="margin-left:15px;">Kesimpulan Drug Screening :</h5>
			<div style="margin-left:25px;
			            margin-top:-10px;
						font-style:italic;
						font-weight:300;
						text-align: left;
						text-justify: inter-word;
						padding-right:5px;
						padding-bottom:15px;
						font-size:12pt;
						">{{ $data->drugScreening->kesimpulan_drug_screening }}</div>
		
			
		</div>