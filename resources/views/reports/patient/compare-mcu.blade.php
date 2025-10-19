@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumbs pull-left">
    <li>Report</li>
    <li>Pasien</li>
    <li><a href="{{ url('/report/patient/medical-check-up') }}">Medical Check Up</a></li>
    <li>Compare</li>
</ul>
@endsection
@section('title', $title_page_left)

@section('content')

<div class="container">
   <div class="row">
        <div class="col-12 mt-5 mb-5">
		    <div class="card">
				<div class="card-body">
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Identitas</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd"></label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif text-center">
												@if (file_exists(public_path('storage/patient/'.$m->id.'.jpg')))
													<img src="{{ asset('assets/patient/'.$m->id.'.jpg') }}" style="margin-top: 10px; height: 100px" />
												@else
													@if (strtolower($m->jenis_kelamin) == 'l')
														<img src="{{ asset('assets/patient/male.jpg') }}" style="margin-top: 10px; height: 100px" />
													@else
														<img src="{{ asset('assets/patient/female.jpg') }}" style="margin-top: 10px; height: 100px" />
													@endif
												@endif
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Medical Id :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ (int) substr($m->id, 12, 8) }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">No. NIP :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->no_nip }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">No. Paper :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->no_paper }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Nama pasien :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->nama_pasien }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Tgl. lahir :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->tgl_lahir }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Jenis kelamin :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->jenis_kelamin }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Bagian :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->bagian }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Paket MCU :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->paket_mcu }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Tgl. Kerja :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->tgl_kerja }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Email :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->email }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Telepon :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->telepon }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Client :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->client }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Customer :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->vendorCustomer->customer->name }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Tgl. Input :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->tgl_input }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Umum</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Nadi :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->umum->nadi }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Sistolik :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->umum->sistolik }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Diastolik :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->umum->diastolik }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Respirasi :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->umum->respirasi }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd odd">Suhu :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->umum->suhu }} &deg;C</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Riwayat</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Keluhan utama :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->keluhan_utama }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Riwayat alergi :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->riwayat_alergi }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Riwayat penyakit sekarang:</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->riwayat_penyakit_sekarang }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Riwayat kesehatan dahulu:</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->riwayat_kesehatan_dahulu }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Riwayat kesehatan keluarga:</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->riwayat_kesehatan_keluarga }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Riwayat kesehatan pribadi:</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->riwayat_kesehatan_pribadi }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Olahraga :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->olahraga == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Frekuensi perminggu :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->frekuensi_per_minggu }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Merokok :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span  id="olahragaY" class="basic-text">{{ ($m->riwayat->merokok == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bungkus perhari :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->rokok_bungkus_per_hari }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kopi :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->kopi == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Gelas perhari :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->kopi_gelas_per_hari }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Alkohol :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->alkohol == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Alkohol sebanyak :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->alkohol_sebanyak }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lama tidur perhari :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->lama_tidur_per_hari }} jam</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Pernah kecelakaan kerja :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->pernah_kecelakaan_kerja == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Tahun kecelakaan kerja :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->tahun_kecelakaan_kerja }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Tempat kerja berbahaya :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->tempat_kerja_berbahaya == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Pernah rawat inap :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
												<span class="basic-text">{{ ($m->riwayat->pernah_rawat_inap == 'Y')?'ya':'tidak' }}</span>
											</div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lama rawat inap (hari) :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->hari_lama_rawat_inap }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Rawat inap karena penyakit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->riwayat->rawat_inap_penyakit }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Antrovisus</strong></div>
						<div class="panel-body">
						<div class="form-horizontal row">
							<div class="col-md-12">
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Berat badan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->berat_badan }} kg</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Tinggi badan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->tinggi_badan }} cm</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">BMI :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->bmi }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Visus kanan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->visus_kanan }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Visus kiri :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->visus_kiri }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Rekomendasi kacamata :</label>
									@foreach ($mcus as $i => $m)
									<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
										<span class="basic-text" type="text">{{ ($m->riwayat->rekomendasi_kacamatan == 'Y')?'ya':'tidak' }}</span>
									 </div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Spheris kanan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->spheris_kanan }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Cylinder kanan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->cylinder_kanan }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Axis kanan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->axis_kanan }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Addition kanan :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->addition_kanan }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Shperis kiri :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->spheris_kiri }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Cylinder kiri :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->cylinder_kiri }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Axis kiri :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->axis_kiri }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Addition kiri :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->addition_kiri }}&nbsp;</span></div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Pupil distance :</label>
									@foreach ($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->antrovisus->pupil_distance }}&nbsp;</span></div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				    </div>

					@php
						$hasFisik = false;
						$hasHematologi = false;
						$hasKimia = false;
						$hasOAE = false;
						$hasRontgen = false;
						$hasSerologi = false;
						$hasSpirometri = false;
						$hasEKG = false;
						$hasTreadmill = false;
						$hasAudiometri = false;
						$hasFeses = false;
						$hasUrin = false;
						$hasPapSmear = false;
						$hasRectalSwab = false;
						$hasDrugScreening = false;

						foreach ($mcus as $i => $m) {
							$m->fisik ? $hasFisik = true : $hasFisik;
							$m->hematologi ? $hasHematologi = true : $hasHematologi;
							$m->kimia ? $hasKimia = true : $hasKimia;
							$m->oea ? $hasOAE = true : $hasOAE;
							$m->rontgen ? $hasRontgen = true : $hasRontgen;
							$m->serologi ? $hasSerologi = true : $hasSerologi;
							$m->spirometri ? $hasSpirometri = true : $hasSpirometri;
							$m->ekg ? $hasEKG = true : $hasEKG;
							$m->treadmill ? $hasTreadmill = true : $hasTreadmill;
							$m->audiometri ? $hasAudiometri = true : $hasAudiometri;
							$m->feses ? $hasFeses = true : $hasFeses;
							$m->urin ? $hasUrin = true : $hasUrin;
							$m->papSmear ? $hasPapSmear = true : $hasPapSmear;
							$m->rectalSwab ? $hasRectalSwab = true : $hasRectalSwab;
							$m->drugScreening ? $hasDrugScreening = true : $hasDrugScreening;
						}
					@endphp

					@if($hasFisik)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Fisik</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kepala :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->kepala:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Mata :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->mata:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Telinga :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->telinga:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hidung :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->hidung:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Tenggorokan :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->tenggorokan:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Leher :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->leher:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Mulut :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->mulut:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Gigi :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->gigi:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Dada :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->dada:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Abdomen :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->abdomen:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Extremitas :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->extremitas:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Anogenital :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->fisik?$m->fisik->anogenital:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasHematologi)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Hematologi</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hemoglobin :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->hemoglobin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hematokrit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->hematokrit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Eritrosit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->eritrosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Leukosit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->leukosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Trombosit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->trombosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Basofil :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->basofil:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Eosinofil :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->eosinofil:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Neutrofil batang :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->neutrofil_batang:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Neutrofil segment :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->neutrofil_segment:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Limfosit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->limfosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Monosit :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->hematologi?$m->hematologi->monosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Laju endap darah :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_laju_endap_darah">{{ $m->hematologi?$m->hematologi->laju_endap_darah:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">MCV :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_mcv">{{ $m->hematologi?$m->hematologi->mcv:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">MCH :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_mch">{{ $m->hematologi?$m->hematologi->mch:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">MCHC :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_mchc">{{ $m->hematologi?$m->hematologi->mchc:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Golongan darah (ABO) :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_golongan_darah_abo">{{ $m->hematologi?$m->hematologi->golongan_darah_abo:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Golongan darah (Rh) :</label>
										@foreach ($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="hematologi_golongan_darah_rh">{{ $m->hematologi?$m->hematologi->golongan_darah_rh:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasKimia)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Kimia</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">GDS :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->gds:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">GDP :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->gdp:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">2 jam PP :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->dua_jam_pp:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">HbA1c :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->hba1c:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Ureum :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->ureum:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kreatinin :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->kreatinin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Asam urat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->asam_urat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bilirubin total :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->bilirubin_total:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bilirubin direk :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->bilirubin_direk:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bilirubin indirek :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->bilirubin_indirek:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">SGOT :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->sgot:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">SGPT :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->sgpt:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Protein :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->protein:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Albumin :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->albumin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Alkaline fosfatase :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->alkaline_fosfatase:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Choline esterase :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->choline_esterase:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Gamma GT :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->gamma_gt:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Trigliserida :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->trigliserida:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kolesterol total :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->kolesterol_total:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">HDL :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->hdl:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">LDL direk :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->ldl_direk:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">LDL indirek :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->ldl_indirek:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">CK :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->ck:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">CKMB :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->ckmb:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Spuktum BTA 1 :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia->spuktum_bta1 }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Spuktum BTA 2 :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->spuktum_bta2:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Spuktum BTA 3 :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->kimia?$m->kimia->spuktum_bta3:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasOAE)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> OAE</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hasil OAE Ka :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->oae?$m->oae->hasil_oae_ka:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hasil OAE Ki :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->oae?$m->oae->hasil_oae_ki:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesimpulan :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->oae?$m->oae->kesimpulan_oae:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasRontgen)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Rontgen</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesan Rontgen :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rontgen?$m->rontgen->kesan_rontgen:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasSerologi)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Serologi</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">HBSAg :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->hbsag }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Anti HBs :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->anti_hbs }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Tuberculosis :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->tuberculosis }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">IgM salmonella :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->igm_salmonella }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">IgG salmonella :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->igg_salmonella }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela typhi O :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_typhi_o }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela typhi H :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_typhi_h }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela parathyphi A-O :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_a_o }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela parathyphi A-H :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_a_h }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela paratyhphi B-O :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_b_o }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela paratyphi B-H :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_b_h }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela paratyphi C-O :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_c_o }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Salmonela paratyphi C-H :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->salmonela_parathypi_c_h }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">HCG :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->serologi->hcg }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">PSA :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_psa">{{ $m->serologi->psa }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">AFP :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_afp">{{ $m->serologi->afp }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">CEA :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_cea">{{ $m->serologi->cea }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">IgM toxo :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_igm_toxo">{{ $m->serologi->igm_toxo }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">IgG toxo :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_igg_toxo">{{ $m->serologi->igg_toxo }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">CKMB :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_ckmb">{{ $m->serologi->ckmb }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Myoglobin :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_myoglobin">{{ $m->serologi->myoglobin }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Toponin I :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text" name="serologi_troponin_i">{{ $m->serologi->troponin_i }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasSpirometri)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Spirometri</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">FEV :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->spirometri?$m->spirometri->fev:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">FVC :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->spirometri?$m->spirometri->fvc:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">PEF :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->spirometri?$m->spirometri->pef:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesimpulan :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->spirometri?$m->spirometri->kesimpulan_spirometri:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</>
							</div>
						</div>
					</div>
					@endif

					@if($hasEKG)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> EKG</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hasil EKG :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span  class="basic-text">{{ $m->ekg?$m->ekg->hasil_ekg:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesimpulan EKG :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span  class="basic-text">{{ $m->ekg?$m->ekg->kesimpulan_ekg:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasTreadmill)
					<div class="panel panel-report panel-control">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Treadmill</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Resting EKG :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->resting_ekg:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bruce heart beat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->bruce_heart_beat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Capaian heart beat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->capaian_heart_beat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Capaian menit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->capaian_menit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Respon heart beat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->respon_heart_beat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Respon Sistol :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->respon_sistol:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Respon diastol :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->respon_diastol:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Aritmia :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->aritmia:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Nyeri dada :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->nyeri_dada:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Gejala lain :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->gejala_lain:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Perubahan segmen ST :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->perubahan_segmen_st:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lead :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->lead:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lead pada menit ke :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->lead_pada_menit_ke:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Normalisasi setelah :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->normalisasi_setelah:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Functional class :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->functional_class:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kapasitas aerobik :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->kapasitas_aerobik:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Tingkat kesegaran :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->tingkat_kesegaran:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Grafik :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->grafik:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesimpulan :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->treadmill?$m->treadmill->kesimpulan_treadmill:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasAudiometri)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i>Hasil Pemeriksaan Audiometri</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hasil telinga kiri :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->audiometri?$m->audiometri->hasil_telinga_kiri:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Hasil telingan kanan :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->audiometri?$m->audiometri->hasil_telinga_kanan:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kesimpulan audiometri :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->audiometri?$m->audiometri->kesimpulan_audiometri:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasFeses)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Feses</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Warna :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->warna_feses:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Konsistensi :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->konsistensi:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Darah :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->darah_feses:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lendir :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->lendir:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Eritrosit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->eritrosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Leukosit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->leukosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Amoeba :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->amoeba:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">E-hystolitica :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->e_hystolitica:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">E-coli :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->e_coli:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kista :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->kista:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Ascaris :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->ascaris:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Oxyuris :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->oxyuris:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Serat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->serat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lemak :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->lemak:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Karbohidrat :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->karbohidrat:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Benzidine :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->benzidine:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Lain-lain :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->feses?$m->feses->lain_lain:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					@if($hasUrin)
					<div class="panel panel-report panel-compare">
						<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Urin</strong></div>
						<div class="panel-body">
							<div class="form-horizontal row">
								<div class="col-md-12">
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Warna :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->warna_urin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kejernihan :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->kejernihan:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Berat jenis :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->berat_jenis:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">pH :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->ph:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Protein urin :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->protein_urin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Reduksi :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->reduksi:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Keton :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->keton:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bilirubin :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->bilirubin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Urobilinogen :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->urobilinogen:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Leukosit esterase :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->leukosit_esterase:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Darah :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->darah_urin:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Nitrit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->nitrit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Sedimen eritrosit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->sedimen_eritrosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Sedimen leukosit :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->sedimen_leukosit:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Epitel :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->epitel:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Silinder :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->silinder:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Kristal :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->kristal:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Bakteri :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->bakteri:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">Jamur :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->jamur:'' }}&nbsp;</span></div>
										@endforeach
									</div>
									<div class="form-group row">
										<label for="" class="control-label {{$class}} odd">HCG :</label>
										@foreach($mcus as $i => $m)
											<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->urin?$m->urin->hcg:'' }}&nbsp;</span></div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

						@if($hasPapSmear)
						<div class="panel panel-report panel-compare">
							<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Pap Smear</strong></div>
							<div class="panel-body">
								<div class="form-horizontal row">
									<div class="col-md-12">
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Tgl. terima :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->tgl_terima:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Tgl. selesai :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->tgl_selesai:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Bahan pemeriksaan :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->bahan_pemeriksaan:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Makroskopik :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->makroskopik:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Mikroskopik :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->mikroskopik:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Kesimpulan :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->papSmear?$m->papSmear->kesimpulan_pap_smear:'' }}&nbsp;</span></div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif

						@if($hasRectalSwab)
						<div class="panel panel-report panel-compare">
							<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Rectal Swab</strong></div>
							<div class="panel-body">
								<div class="form-horizontal row">
									<div class="col-md-12">
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Typoid :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->typoid:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Diare :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->diare:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Disentri :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->disentri:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Kolera :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->kolera:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Salmonella :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->salmonella:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Shigella :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->shigella:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">E-coli :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->e_coli:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Vibrio cholera :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->vibrio_cholera:'' }}&nbsp;</span></div>
											@endforeach
										</div>
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Kesimpulan :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->rectalSwab?$m->rectalSwab->kesimpulan_rectal_swab:'' }}&nbsp;</span></div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif

						@if($hasDrugScreening)
						<div class="panel panel-report panel-compare">
							<div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Drug Screening</strong></div>
							<div class="panel-body">
								<div class="form-horizontal row">
									<div class="col-md-12">
										<div class="form-group row">
											<label for="" class="control-label {{$class}} odd">Kesimpulan Drug Screening :</label>
											@foreach($mcus as $i => $m)
												<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif"><span class="basic-text">{{ $m->drugScreening->kesimpulan_drug_screening }}&nbsp;</span></div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif

						<div class="panel panel-report panel-compare">
                <div class="panel-heading bg-corporate"><strong><i class="fa fa-th-large"></i> Summary</strong></div>
					<div class="panel-body">
						<div class="form-horizontal row">
							<div class="col-md-12">
								<div class="form-group row">
									@php
										$maxDiagnosis = 0;
									@endphp
									@foreach($mcus as $i => $m)
										@php
											if($m->diagnosis->count() > $maxDiagnosis) {
												$maxDiagnosis = $m->diagnosis->count();
											}
										@endphp
									@endforeach
									<label for="" class="control-label {{$class}} odd">Diagnosis (ICD X) :<br>&nbsp;<br></label>
									@foreach($mcus as $i => $m)
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
											@if($m->diagnosis->count() > 0)
												@foreach($m->diagnosis as $d)
													<span class="basic-text">{{ isset($d->recommendation->icd10->name) ? $d->recommendation->icd10->name : '-' }}&nbsp;</span>
												@endforeach
												@for ($i = 0; $i < ($maxDiagnosis - $m->diagnosis->count()); $i++)
													<span class="basic-text">&nbsp;</span>
												@endfor
											@else
												<span class="basic-text">Normal Condition</span>
												@for ($i = 0; $i < ($maxDiagnosis - 1); $i++)
													<span class="basic-text">&nbsp;</span>
												@endfor
											@endif
										</div>
									@endforeach
								</div>
								<div class="form-group row">
									<label for="" class="control-label {{$class}} odd">Diagnosis Kesehatan Kerja :</label>
									@foreach($mcus as $i => $m)
										@php
											$workHealthDiagnosis  = 'FIT ON JOB';
											if($m->diagnosis->count() > 0) {

												$arrDiagnosis = collect();
												foreach($m->diagnosis as $d) {
													$arrDiagnosis->push([
													'sequence' => $d->recommendation->workHealth->sequence,
													'diagnosis' => $d->recommendation->workHealth->name
													]);
												}

												$getDiagnosis = collect($arrDiagnosis)->sortBy('sequence')->first();
												$workHealthDiagnosis = $getDiagnosis['diagnosis'];

											}
										@endphp
										<div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
											<span class="basic-text">{{ $workHealthDiagnosis }}&nbsp;</span>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>

        <div class="panel panel-report panel-compare">
            <div class="panel-body">
                <div class="form-horizontal row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="" class="control-label {{$class}} odd">&nbsp;<br></label>
                            @foreach($mcus as $i => $m)
                                <div class="{{$class}} @if(($i % 2) == 0) even @else odd @endif">
                                    <span class="basic-text">
                                        <a target="_blank" href="{{ url('report/patient/medical-check-up/print/'.$m->id) }}" class="btn btn btn-outline-secondary btn-flat"><i class="fa fa-print"></i> @lang('general.print')</a> &nbsp;
                                        <a href="{{ url('report/patient/medical-check-up/print/'.$m->id) }}" class="btn btn-success btn-flat" download><i class="fa fa-download"></i> @lang('general.download')</a>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
			</div>
		</div>
	</div>
</div>
@endsection

