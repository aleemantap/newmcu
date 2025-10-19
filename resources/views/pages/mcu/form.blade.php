@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumb">
    <li>@lang('menu.database')</li>
    <li><a href="{{ url('/database/medical-check-up') }}">@lang('menu.medical_check_up')</a></li>
    <li>@lang('general.create')</li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif

        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        <ul class="nav nav-tabs" id="tabs" role="tablist">
            <li class="nav-item active"><a class="nav-link" data-toggle="tab" aria-selected="true" href="#tab-identitas" id="identitas-tab">@lang('mcu.identity')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-umum" id="umum-tab">@lang('mcu.general')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-riwayat" id="riwayat-tab">@lang('mcu.history')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-antrovisus" id="antrovisus-tab">@lang('mcu.antrovisus')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-fisik" id="fisik-tab">@lang('mcu.physical')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-hematologi" id="hematologi-tab">@lang('mcu.hematology')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-kimia" id="kimia-tab">@lang('mcu.chemical')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-oae" id="oae-tab">@lang('mcu.oae')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-rontgen" id="rontgen-tab">@lang('mcu.roentgen')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-serologi" id="serologi-tab">@lang('mcu.serology')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-spirometri" id="spirometri-tab">@lang('mcu.spirometry')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-ekg" id="ekg-tab">@lang('mcu.ekg')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-treadmill" id="treadmill-tab">@lang('mcu.treadmill')</a></li>
            <!--
			<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-audiometri" id="audiometri-tab">Audiometri</a></li>
            -->
			<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-feses" id="feses-tab">@lang('mcu.feces')</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-urin" id="urin-tab">@lang('mcu.urine')</a></li>
            <li class="nav-item dropdown" style="opacity: 1; transform: scale(1)">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; left: -58px; top: 37px;">
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-pap-smear" id="pap-smear-tab">@lang('mcu.pap_smear')</a>
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-rectal-swab" id="rectal-swab-tab">@lang('mcu.rectal_swab')</a>
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-drug-screening" id="drug-screening-tab">@lang('mcu.drug_screening')</a>
                </div>
            </li>
        </ul>
        <form method="post" enctype="multipart/form-data" action="{{ URL::to('/database/medical-check-up/store') }}">
            @csrf
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab-identitas" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading "><strong><i class="fa fa-th-large"></i> @lang('mcu.identity')</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.medical_id')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="medical_id"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.employee_id')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_no_nip"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.paper_number')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_no_paper"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.patient_name')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_nama_pasien" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.dob')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_lahir" name="mcu_tgl_lahir"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.gender')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="L"><input checked="" id="L" type="radio" name="mcu_jenis_kelamin" value="L"> @lang('mcu.male')</label></div>
                                            <div class="radio radio-inline"><label for="P"><input id="P" type="radio" name="mcu_jenis_kelamin" value="P"> @lang('mcu.female')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.department')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_bagian"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.package_mcu')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_paket_mcu"></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.start_date')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_kerja" name="mcu_tgl_kerja"></div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.email')</label>
                                        <div class="col-md-8"><input type="email" class="form-control input-xs" name="mcu_email"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.phone')</label>
                                        <div class="col-md-8"><input type="tel" class="form-control input-xs" name="mcu_telepon"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.client')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_client"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('project.project')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" name="mcu_vendor_customer_id">
                                                <option value="">&raquo; @lang('general.select') @lang('project.project')</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->vendor->name .' - '. $project->customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.input_date')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_input" name="mcu_tgl_input"></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.saran')</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="mcu_saran" id="mcu_saran"></textarea></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.catatan')</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="mcu_catatan" id="mcu_catatan"></textarea></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.published')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="mcu_publishedY"><input id="mcu_publishedY" type="radio" name="mcu_published" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="mcu_publishedN"><input checked="" id="mcu_publishedN" type="radio" name="mcu_published" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" disabled><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#umum-tab')" href="#tab-umum">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-umum" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> @lang('mcu.general')</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.pulse')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_nadi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.systolic')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_sistolik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.diastolic')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_diastolik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.respiration')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_respirasi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.temperature')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_suhu" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#identitas-tab')" href="#tab-identitas"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')" href="#tab-riwayat">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> @lang('mcu.history')</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.main_complaint')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_keluhan_utama" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat alergi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_alergi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat penyakit sekarang</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_penyakit_sekarang" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan dahulu</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_dahulu" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan keluarga</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_keluarga" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan pribadi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_pribadi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Olahraga</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="olahragaY"><input id="olahragaY" type="radio" name="riwayat_olahraga" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="olahragaN"><input checked="" id="olahragaN" type="radio" name="riwayat_olahraga" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Frekuensi perminggu</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_frekuensi_per_minggu"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Merokok</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="merokokY"><input id="merokokY" type="radio" name="riwayat_merokok" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="merokokN"><input checked="" id="merokokN" type="radio" name="riwayat_merokok" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bungkus perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_rokok_bungkus_per_hari"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kopi</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="kopiY"><input id="kopiY" type="radio" name="riwayat_kopi" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="kopiN"><input checked="" id="kopiN" type="radio" name="riwayat_kopi" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gelas perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_kopi_gelas_per_hari"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="alkoholY"><input id="alkoholY" type="radio" name="riwayat_alkohol" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="alkoholN"><input checked="" id="alkoholN" type="radio" name="riwayat_alkohol" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol sebanyak</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_alkohol_sebanyak"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama tidur perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_lama_tidur_per_hari" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah kecelakaan kerja</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="pernah_kecelakaan_kerjaY"><input id="pernah_kecelakaan_kerjaY" type="radio" name="riwayat_pernah_kecelakaan_kerja" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="pernah_kecelakaan_kerjaN"><input checked="" id="pernah_kecelakaan_kerjaN" type="radio" name="riwayat_pernah_kecelakaan_kerja" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tahun kecelakaan kerja</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_tahun_kecelakaan_kerja"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tempat kerja berbahaya</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="tempat_kerja_berbahayaY"><input id="tempat_kerja_berbahayaY" type="radio" name="riwayat_tempat_kerja_berbahaya" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="tempat_kerja_berbahayaN"><input checked="" id="tempat_kerja_berbahayaN" type="radio" name="riwayat_tempat_kerja_berbahaya" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah rawat inap</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="pernah_rawat_inapY"><input id="pernah_rawat_inapY" type="radio" name="riwayat_pernah_rawat_inap" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="pernah_rawat_inapN"><input checked="" id="pernah_rawat_inapN" type="radio" name="riwayat_pernah_rawat_inap" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama rawat inap (hari)</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_hari_lama_rawat_inap"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Rawat inap karena penyakit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_rawat_inap_penyakit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#umum-tab')" href="#tab-umum"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')" href="#tab-antrovisus">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-antrovisus" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> @lang('mcu.antrovisus')</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.weight')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="antrovisus_berat_badan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.height')</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="antrovisus_tinggi_badan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.bmi')</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="antrovisus_bmi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.right_vision')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_visus_kanan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.left_vision')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_visus_kiri" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.glasses_recommendation')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="rekomendasi_kacamatanY"><input id="rekomendasi_kacamatanY" type="radio" name="antrovisus_rekomendasi_kacamatan" value="Y"> @lang('mcu.yes')</label></div>
                                            <div class="radio radio-inline"><label for="rekomendasi_kacamatanN"><input checked="" id="rekomendasi_kacamatanN" type="radio" name="antrovisus_rekomendasi_kacamatan" value="N"> @lang('mcu.no')</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.right_spherical')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_spheris_kanan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.right_cylinder')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_cylinder_kanan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.right_axis')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_axis_kanan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.right_addition')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_addition_kanan" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.left_spherical')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_spheris_kiri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.left_cylinder')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_cylinder_kiri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.left_axis')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_axis_kiri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.left_addition')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_addition_kiri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.pupil_distance')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_pupil_distance" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')" href="#tab-riwayat"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#fisik-tab')" href="#tab-fisik">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-fisik" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> @lang('mcu.physical')</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="fisik_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="fisik_diperiksa" id="fisik_diperiksa_no" checked="" value="TIDAK DIPERIKSA"> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.head')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_kepala" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.eyes')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_mata" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.ears')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_telinga" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.nose')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_hidung" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.throat')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_tenggorokan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.neck')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_leher" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.mouth')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_mulut" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.tooth')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_gigi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.chest')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_dada" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.abdomen')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_abdomen" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.extremities')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_extremitas" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.anogenital')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_anogenital" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')" href="#tab-antrovisus"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')" href="#tab-hematologi">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-hematologi" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Hematologi</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="hematologi_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="hematologi_diperiksa" id="fisik_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hemoglobin</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_hemoglobin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hematokrit</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_hematokrit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_eritrosit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_leukosit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trombosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_trombosit" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Basofil</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_basofil" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eosinofil</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_eosinofil" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil batang</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_neutrofil_batang" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil segment</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_neutrofil_segment" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Limfosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_limfosit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Monosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_monosit" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Laju endap darah</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_laju_endap_darah" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCV</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mcv" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCH</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mch" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCHC</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mchc" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (ABO)</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="hematologi_golongan_darah_abo" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (Rh)</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="hematologi_golongan_darah_rh" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#fisik-tab')" href="#tab-fisik"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#kimia-tab')" href="#tab-kimia">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-kimia" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Kimia</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="kimia_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="kimia_diperiksa" id="fisik_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDS</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="kimia_gds" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDP</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="kimia_gdp" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">2 jam PP</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_2_jam_pp" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HbA1c</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_hba1c" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ureum</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="kimia_ureum" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kreatinin</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="kimia_kreatinin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Asam urat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_asam_urat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin total</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_bilirubin_total" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin direk</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_bilirubin_direk" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin indirek</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_bilirubin_indirek" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGOT</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="kimia_sgot" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGPT</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="kimia_sgpt" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_protein" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Albumin</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_albumin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkaline fosfatase</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_alkaline_fosfatase" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Choline esterase</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_choline_esterase" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gamma GT</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_gamma_gt" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trigliserida</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_trigliserida" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolesterol total</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_kolesterol_total" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HDL</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_hdl" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL direk</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_ldl_direk" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL indirek</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_ldl_indirek" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CK</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_ck" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CKMB</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_ckmb" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 1</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta1" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 2</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta2" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 3</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta3" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')" href="#tab-hematologi"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#oae-tab')" href="#tab-oae">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-oae" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> OAE</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="oae_diperiksa" id="oae_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="oae_diperiksa" id="oae_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ka</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_hasil_oae_ka" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ki</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_hasil_oae_ki" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_kesimpulan" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#kimia-tab')" href="#tab-kimia"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')" href="#tab-rontgen">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-rontgen" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Rontgen</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rontgen_diperiksa" id="rontgen_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rontgen_diperiksa" id="rontgen_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesan Rontgen</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" id="kesan_rontgen" name="kesan_rontgen" ></div>
                                    </div>
                                </div>
                                <!--<div class="col-md-12">

                                    <div class="row">
                                        <div class="panel-heading"><i class="fa fa-th-list"></i> Detail <a id="add-rontgen" class="text-success pull-right" style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Input</a></div>
                                    </div>

                                    <div id="rontgen-detail">
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Jenis Foto</label>
                                                <input type="text" class="form-control input-xs" id="rontgen_jenis_foto" name="rontgen_jenis_foto[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_parameter[]" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="">Temuan</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_temuan[]" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Jenis Foto</label>
                                                <input type="text" class="form-control input-xs" id="rontgen_jenis_foto" name="rontgen_jenis_foto[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_parameter[]" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="">Temuan</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_temuan[]" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Jenis Foto</label>
                                                <input type="text" class="form-control input-xs" id="rontgen_jenis_foto" name="rontgen_jenis_foto[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_parameter[]" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="">Temuan</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_temuan[]" >
                                            </div>
                                        </div>
                                    </div>

                                </div> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#oae-tab')" href="#tab-oae"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#serologi-tab')" href="#tab-serologi">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-serologi" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Serologi</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">HBSAg</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_hbsag" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Anti HBs</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_anti_hbs" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Tuberculosis</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_tuberculosis" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgM salmonella</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igm_salmonella" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgG salmonella</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igg_salmonella" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela typhi O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_typhi_o" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela typhi H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_typhi_h" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela parathyphi A-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_o" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela parathyphi A-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_h" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyhphi B-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_o" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi B-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_h" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi C-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_o" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi C-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_h" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">HCG</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_hcg" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">PSA</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_psa" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">AFP</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_afp" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">CEA</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_cea" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgM toxo</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igm_toxo" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgG toxo</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igg_toxo" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">CKMB</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_ckmb" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Myoglobin</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_myoglobin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Toponin I</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_troponin_i" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')" href="#tab-rontgen"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')" href="#tab-spirometri">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-spirometri" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Spirometri</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="spirometri_diperiksa" id="spirometri_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="spirometri_diperiksa" id="spirometri_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FEV</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_fev" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FVC</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_fvc" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">PEF</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_pef" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_kesimpulan" ></div>
                                    </div>
									<div class="form-group row">
										<label for="" class="control-label col-md-4">Chart JPG</label>
										<div class="col-md-8">
											<input accept=".jpg,.jpeg" id="file" type="file" name="file" class="form-control input-xs">
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#serologi-tab')" href="#tab-serologi"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#ekg-tab')" href="#tab-ekg">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-ekg" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> EKG</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="ekg_diperiksa" id="ekg_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="ekg_diperiksa" id="ekg_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil EKG</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="ekg_hasil" ></textarea></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion') EKG</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="ekg_kesimpulan" ></textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')" href="#tab-spirometri"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')" href="#tab-treadmill">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-treadmill" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Treadmill</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="treadmill_diperiksa" id="treadmill_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="treadmill_diperiksa" id="treadmill_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Resting EKG</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_resting_ekg" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Bruce heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_bruce_heart_beat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Capaian heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_capaian_heart_beat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Capaian menit</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_capaian_menit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_heart_beat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon Sistol</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_sistol" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon diastol</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_diastol" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Aritmia</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_aritmia" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Nyeri dada</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_nyeri_dada" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Gejala lain</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_gejala_lain" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Perubahan segmen ST</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_perubahan_segmen_st" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Lead</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_lead" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Lead pada menit ke</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_lead_pada_menit_ke" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Normalisasi setelah</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_normalisasi_setelah" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Functional class</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_functional_class" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Kapasitas aerobik</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_kapasitas_aerobik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Tingkat kesegaran</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_tingkat_kesegaran" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Grafik</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_grafik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Kesmipulan</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_kesimpulan" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#ekg-tab')" href="#tab-ekg"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')" href="#tab-audiometri">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <!--
				<div class="tab-pane fade" id="tab-audiometri" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Audiometri</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="panel-heading"><i class="fa fa-th-list"></i> Detail <a id="add-audiometri" class="text-success pull-right" style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Input</a></div>
                                    </div>

                                    <div id="audiometri-detail">
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Frekuensi</label>
                                                <input type="text" class="form-control input-xs" id="audiometri_freksuensi" name="audiometri_frekuensi[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kiri</label>
                                                <input type="number" class="form-control input-xs" name="audiometri_kiri[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kanan</label>
                                                <input type="number" class="form-control input-xs" name="audiometri_kanan[]" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Frekuensi</label>
                                                <input type="text" class="form-control input-xs " id="audiometri_freksuensi" name="audiometri_frekuensi[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kiri</label>
                                                <input type="text" class="form-control input-xs" name="audiometri_kiri[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kanan</label>
                                                <input type="text" class="form-control input-xs" name="audiometri_kanan[]" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Frekuensi</label>
                                                <input type="text" class="form-control input-xs " id="audiometri_freksuensi" name="audiometri_frekuensi[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kiri</label>
                                                <input type="text" class="form-control input-xs" name="audiometri_kiri[]" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="">Kanan</label>
                                                <input type="text" class="form-control input-xs" name="audiometri_kanan[]" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')" href="#tab-treadmill"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#feses-tab')" href="#tab-feses">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div> -->
                <div class="tab-pane fade" id="tab-feses" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Feses</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="feses_diperiksa" id="feses_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="feses_diperiksa" id="feses_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_warna" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Konsistensi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_konsistensi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_darah" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lendir</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lendir" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_eritrosit" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_leukosit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Amoeba</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_amoeba" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-hystolitica</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_e_hystolitica" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_e_coli" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kista</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_kista" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ascaris</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_ascaris" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Oxyuris</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_oxyuris" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Serat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_serat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lemak</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lemak" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Karbohidrat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_karbohidrat" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Benzidine</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_benzidine" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lain-lain</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lain_lain" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')" href="#tab-audiometri"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#urin-tab')" href="#tab-urin">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-urin" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Urin</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="urin_diperiksa" id="urin_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="urin_diperiksa" id="urin_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_warna" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kejernihan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_kejernihan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Berat jenis</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_berat_jenis" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">pH</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_ph" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein urin</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_protein_urin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Reduksi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_reduksi" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Keton</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_keton" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_bilirubin" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Urobilinogen</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_urobilinogen" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit esterase</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_leukosit_esterase" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_darah" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nitrit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_nitrit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen eritrosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_sedimen_eritrosit" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen leukosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_sedimen_leukosit" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Epitel</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_epitel" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Silinder</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_silinder" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kristal</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_kristal" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bakteri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_bakteri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jamur</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_jamur" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HCG</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_hcg" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#feses-tab')" href="#tab-feses"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')" href="#tab-pap-smear">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pap-smear" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Pap Smear</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. terima</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="pap_smear_tgl_terima" name="pap_smear_tgl_terima" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. selesai</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="pap_smear_tgl_selesai" name="pap_smear_tgl_selesai" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bahan pemeriksaan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_bahan_pemeriksaan" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Makroskopik</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_makroskopik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mikroskopik</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_mikroskopik" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_kesimpulan" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#urin-tab')" href="#tab-urin"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')" href="#tab-rectal-swab">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-rectal-swab" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Rectal Swab</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rectal_swab_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rectal_swab_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Typoid</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_typoid" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diare</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_diare" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Disentri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_disentri" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolera</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_kolera" ></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonella</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_salmonella" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Shigella</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_shigella" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_e_coli" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Vibrio cholera</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_vibrio_cholera" ></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion')</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_kesimpulan" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')" href="#tab-pap-smear"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#drug-screening-tab')" href="#tab-drug-screening">@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-drug-screening" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Drug Screening</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.checked')</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="drug_screening_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA"> @lang('mcu.yes')</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="drug_screening_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA" checked=""> @lang('mcu.no')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.conclusion') Drug Screening</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" id="drug_screening_kesimpulan" name="drug_screening_kesimpulan" ></div>
                                    </div>
                                </div>
                                <!--<div class="col-md-12">

                                    <div class="row">
                                        <div class="panel-heading"><i class="fa fa-th-list"></i> Detail <a id="add-drug-screening" class="text-success pull-right" style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Input</a></div>
                                    </div>

                                    <div id="drug-screening-detail">
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Tgl. pemeriksaan</label>
                                                <input type="text" class="form-control input-xs datepicker" id="drug_screening_tgl_pemeriksaan" name="drug_screening_tgl_pemeriksaan[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Status pemeriksaan</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_status_pemeriksaan[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_parameter[]" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Hasil</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_hasil[]" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Tgl. pemeriksaan</label>
                                                <input type="text" class="form-control input-xs datepicker" id="drug_screening_tgl_pemeriksaan" name="drug_screening_tgl_pemeriksaan" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Status pemeriksaan</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_status_pemeriksaan" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_parameter" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Hasil</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_hasil" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Tgl. pemeriksaan</label>
                                                <input type="text" class="form-control input-xs datepicker" id="drug_screening_tgl_pemeriksaan" name="drug_screening_tgl_pemeriksaan" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Status pemeriksaan</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_status_pemeriksaan" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_parameter" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Hasil</label>
                                                <input type="text" class="form-control input-xs" name="drug_screening_hasil" >
                                            </div>
                                        </div>
                                    </div>

                                </div> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')" href="#tab-rectal-swab"><i class="fa fa-chevron-left"></i> @lang('mcu.prev')</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" disabled>@lang('mcu.next') <i class="fa fa-chevron-right"></i></a> &nbsp;
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> @lang('general.save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>




</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
@endsection

@section('script')
<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    function tabSwitch(id){
        event.preventDefault();
        $(id).tab('show');
    }

    $(document).ready(function(){


		$("#file").change(function () {
				var fileExtension = ['jpeg', 'jpg'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("Only formats are allowed : "+fileExtension.join(', '));
					$("#file").val("");
				}
		});



        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#rontgen-detail').on('focus', '.datepicker', function(){
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

        // Add rontgen input
        $('#add-rontgen').click(function() {
            var dsContent = `<div class="row" style="margin-bottom: 10px">
                                <div class="col-md-1">
                                    <label for="">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Jenis Foto</label>
                                    <input type="text" class="form-control input-xs" id="rontgen_jenis_foto" name="rontgen_jenis_foto[]" >
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="">Parameter</label>
                                    <input type="text" class="form-control input-xs" name="rontgen_parameter[]" >
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="">Temuan</label>
                                    <input type="text" class="form-control input-xs" name="rontgen_temuan[]" >
                                </div>
                            </div>`;
            $('#rontgen-detail').append(dsContent);
        });

        // Remove drug screening
        $('#audiometri-detail').on('click', '.remove', function() {
            $(this).closest('.row').remove();
        });

        // Add audiometri input
        $('#add-audiometri').click(function() {
            var dsContent = `<div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-1">
                                        <label for="">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Frekuensi</label>
                                        <input type="text" class="form-control input-xs " id="audiometri_freksuensi" name="audiometri_frekuensi[]" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="">Kiri</label>
                                        <input type="text" class="form-control input-xs" name="audiometri_kiri[]" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="">Kanan</label>
                                        <input type="text" class="form-control input-xs" name="audiometri_kanan[]" >
                                    </div>
                                </div>`;
            $('#audiometri-detail').append(dsContent);
        });

        // Remove drug screening
        $('#rontgen-detail').on('click', '.remove', function() {
            $(this).closest('.row').remove();
        });

        $('#drug-screening-detail').on('focus', '.datepicker', function(){
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

        // Add drug screening input
        $('#add-drug-screening').click(function() {
            var dsContent = `<div class="row" style="margin-bottom: 10px">
                                <div class="col-md-1">
                                    <label for="">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tgl. pemeriksaan</label>
                                    <input type="text" class="form-control input-xs datepicker" id="drug_screening_tgl_pemeriksaan" name="drug_screening_tgl_pemeriksaan[]" >
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="">Status pemeriksaan</label>
                                    <input type="text" class="form-control input-xs" name="drug_screening_status_pemeriksaan[]" >
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="">Parameter</label>
                                    <input type="text" class="form-control input-xs" name="drug_screening_parameter[]" >
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="">Hasil</label>
                                    <input type="text" class="form-control input-xs" name="drug_screening_hasil[]" >
                                </div>
                            </div>`;
            $('#drug-screening-detail').append(dsContent);
        });

        // Remove drug screening
        $('#drug-screening-detail').on('click', '.remove', function() {
            $(this).closest('.row').remove();
        });
    });

</script>
@endsection
