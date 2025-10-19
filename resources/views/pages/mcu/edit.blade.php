@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumb">
    <li>Database</li>
    <li><a href="{{ url('/database/medical-check-up') }}">Medical Check Up</a></li>
    <li>Edit</li>
</ul>
@endsection

<style>
.jom {
  padding: 6px;
  background-color: tranparent;
  transition: transform .2s;
  width: 200px;
  height: 160px;
  margin: 0 auto;
}

.jom:hover {
  -ms-transform: scale(2.5); /* IE 9 */
  -webkit-transform: scale(2.5); /* Safari 3-8 */
  transform: scale(2.5);
}

</style>

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
		
		<?php
		function ambSatuan($satuanArr,$sat)
		{
			foreach($satuanArr as $data)
			 {
				 if($data->field == $sat)
				 {
					 return $data->ket_or_satuan;
				 }
			 }
		}
		?>
        <ul class="nav nav-tabs" id="tabs" role="tablist">
            <li class="nav-item active"><a class="nav-link" data-toggle="tab" aria-selected="true" href="#tab-identitas" id="identitas-tab">Identitas</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-umum" id="umum-tab">Umum</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-riwayat" id="riwayat-tab">Riwayat</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-antrovisus" id="antrovisus-tab">Antrovisus</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-fisik" id="fisik-tab">Fisik</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-hematologi" id="hematologi-tab">Hematologi</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-kimia" id="kimia-tab">Kimia</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-audiometri" id="audiometri-tab">Audiometri</a></li>
            <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-oae" id="oae-tab">OAE</a></li>-->
        	<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-rontgen" id="rontgen-tab">Rontgen</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-serologi" id="serologi-tab">Serologi</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-spirometri" id="spirometri-tab">Spirometri</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-ekg" id="ekg-tab">EKG</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-treadmill" id="treadmill-tab">Treadmill</a></li>
            <!--
			<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-audiometri" id="audiometri-tab">Audiometri</a></li>
            -->
			<li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-feses" id="feses-tab">Feses</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-urin" id="urin-tab">Urin</a></li>
            <li class="nav-item dropdown" style="opacity: 1; transform: scale(1)">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; left: -58px; top: 37px;">
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-pap-smear" id="pap-smear-tab">Pap Smear</a>
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-rectal-swab" id="rectal-swab-tab">Rectal Swab</a>
                    <a class="dropdown-item" style="padding: 5px 15px; display: block" data-toggle="tab" aria-selected="false" href="#tab-drug-screening" id="drug-screening-tab">Drug Screening</a>
                </div>
            </li>
        </ul>
        <form method="post" enctype="multipart/form-data" action="{{ URL::to('/database/medical-check-up/update') }}">
            @csrf
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab-identitas" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading "><strong><i class="fa fa-th-large"></i> Identitas</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Medical Id</label>
                                        <div class="col-md-8">
											<input type="hidden" class="form-control input-xs" readonly="" name="mcu_id" value="{{ $mcu->id }}">
											<input type="number" class="form-control input-xs" readonly="" name="medical_id" value="{{ (int) substr($mcu->id, 12, 8) }}">
										</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">No. NIP</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_no_nip" value="{{ $mcu->no_nip }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">No. Paper</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_no_paper" value="{{ $mcu->no_paper }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nama pasien</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_nama_pasien" value="{{ $mcu->nama_pasien }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. lahir</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_lahir" name="mcu_tgl_lahir" value="{{ $mcu->tgl_lahir }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jenis kelamin</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="L"><input id="L" type="radio" name="mcu_jenis_kelamin" value="L" {{ ($mcu->jenis_kelamin == 'L')?'checked':null }}> Pria</label></div>
                                            <div class="radio radio-inline"><label for="P"><input id="P" type="radio" name="mcu_jenis_kelamin" value="P" {{ ($mcu->jenis_kelamin == 'P')?'checked':null }}> Wanita</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bagian</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_bagian" value="{{ $mcu->bagian }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Paket MCU</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_paket_mcu" value="{{ $mcu->paket_mcu }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. Kerja</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_kerja" name="mcu_tgl_kerja" value="{{ $mcu->tgl_kerja }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Email</label>
                                        <div class="col-md-8"><input type="email" class="form-control input-xs" name="mcu_email" value="{{ $mcu->email }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Telepon</label>
                                        <div class="col-md-8"><input type="tel" class="form-control input-xs" name="mcu_telepon" value="{{ $mcu->telepon }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Client</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="mcu_client" value="{{ $mcu->client }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Project</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" name="mcu_vendor_customer_id">
                                                <option value="">&raquo; Semua Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ ($project->id == $mcu->vendor_customer_id)?'selected':'' }}>{{ $project->vendor->name.' - '.$project->customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="mcu_tgl_input" readonly="" name="mcu_tgl_input"  value="{{ $mcu->tgl_input }}"></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">Saran</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="mcu_saran" id="mcu_saran">{{ $mcu->saran }}</textarea></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">Catatan</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="mcu_catatan" id="mcu_catatan">{{ $mcu->catatan }}</textarea></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Published</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="mcu_publishedY"><input id="mcu_publishedY" type="radio" name="mcu_published" value="Y" {{ ($mcu->published == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="mcu_publishedN"><input id="mcu_publishedN" type="radio" name="mcu_published" value="N" {{ ($mcu->published == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" disabled><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#umum-tab')" href="#tab-umum">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-umum" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Umum</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nadi</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_nadi" value="{{ $mcu->umum->nadi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sistolik</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_sistolik" value="{{ $mcu->umum->sistolik }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diastolik</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_diastolik" value="{{ $mcu->umum->diastolik }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Respirasi</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_respirasi" value="{{ $mcu->umum->respirasi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Suhu</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="umum_suhu" value="{{ $mcu->umum->suhu }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#identitas-tab')" href="#tab-identitas"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')" href="#tab-riwayat">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Riwayat</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Keluhan utama</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_keluhan_utama" value="{{ $mcu->riwayat->keluhan_utama }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat alergi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_alergi" value="{{ $mcu->riwayat->riwayat_alergi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat penyakit sekarang</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_penyakit_sekarang" value="{{ $mcu->riwayat->riwayat_penyakit_sekarang }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan dahulu</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_dahulu" value="{{ $mcu->riwayat->riwayat_kesehatan_dahulu }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan keluarga</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_keluarga" value="{{ $mcu->riwayat->riwayat_kesehatan_keluarga }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan pribadi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_pribadi" value="{{ $mcu->riwayat->riwayat_kesehatan_pribadi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Olahraga</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="olahragaY"><input id="olahragaY" type="radio" name="riwayat_olahraga" value="Y" {{ ($mcu->riwayat->olahraga == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="olahragaN"><input id="olahragaN" type="radio" name="riwayat_olahraga" value="N" {{ ($mcu->riwayat->olahraga == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Frekuensi perminggu</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_frekuensi_per_minggu" value="{{ $mcu->riwayat->frekuensi_per_minggu }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Merokok</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="merokokY"><input id="merokokY" type="radio" name="riwayat_merokok" value="Y" {{ ($mcu->riwayat->merokok == 'Y')?'checked':'' }}>Ya</label></div>
                                            <div class="radio radio-inline"><label for="merokokN"><input id="merokokN" type="radio" name="riwayat_merokok" value="N" {{ ($mcu->riwayat->merokok == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bungkus perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_rokok_bungkus_per_hari" value="{{ $mcu->riwayat->rokok_bungkus_per_hari }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kopi</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="kopiY"><input id="kopiY" type="radio" name="riwayat_kopi" value="Y" {{ ($mcu->riwayat->kopi == 'Y')?'checked':'' }}>Ya</label></div>
                                            <div class="radio radio-inline"><label for="kopiN"><input id="kopiN" type="radio" name="riwayat_kopi" value="N" {{ ($mcu->riwayat->kopi == 'N')?'checked':'' }}>Tidak</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gelas perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_kopi_gelas_per_hari" value="{{ $mcu->riwayat->kopi_gelas_per_hari }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="alkoholY"><input id="alkoholY" type="radio" name="riwayat_alkohol" value="Y" {{ ($mcu->riwayat->alkohol == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="alkoholN"><input id="alkoholN" type="radio" name="riwayat_alkohol" value="N" {{ ($mcu->riwayat->alkohol == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol sebanyak</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_alkohol_sebanyak" value="{{ $mcu->riwayat->alkohol_sebanyak }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama tidur perhari</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_lama_tidur_per_hari" value="{{ $mcu->riwayat->lama_tidur_per_hari }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah kecelakaan kerja</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="pernah_kecelakaan_kerjaY"><input id="pernah_kecelakaan_kerjaY" type="radio" name="riwayat_pernah_kecelakaan_kerja" value="Y" {{ ($mcu->riwayat->pernah_kecelakaan_kerja == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="pernah_kecelakaan_kerjaN"><input id="pernah_kecelakaan_kerjaN" type="radio" name="riwayat_pernah_kecelakaan_kerja" value="N" {{ ($mcu->riwayat->pernah_kecelakaan_kerja == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tahun kecelakaan kerja</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_tahun_kecelakaan_kerja" value="{{ $mcu->riwayat->tahun_kecelakaan_kerja }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tempat kerja berbahaya</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="tempat_kerja_berbahayaY"><input id="tempat_kerja_berbahayaY" type="radio" name="riwayat_tempat_kerja_berbahaya" value="Y" {{ ($mcu->riwayat->tempat_kerja_berbahaya == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="tempat_kerja_berbahayaN"><input id="tempat_kerja_berbahayaN" type="radio" name="riwayat_tempat_kerja_berbahaya" value="N" {{ ($mcu->riwayat->tempat_kerja_berbahaya == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah rawat inap</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="pernah_rawat_inapY"><input id="pernah_rawat_inapY" type="radio" name="riwayat_pernah_rawat_inap" value="Y" {{ ($mcu->riwayat->pernah_rawat_inap == 'Y')?'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="pernah_rawat_inapN"><input id="pernah_rawat_inapN" type="radio" name="riwayat_pernah_rawat_inap" value="N" {{ ($mcu->riwayat->pernah_rawat_inap == 'N')?'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama rawat inap (hari)</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="riwayat_hari_lama_rawat_inap" value="{{ $mcu->riwayat->hari_lama_rawat_inap }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Rawat inap karena penyakit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="riwayat_rawat_inap_penyakit" value="{{ $mcu->riwayat->rawat_inap_penyakit }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#umum-tab')" href="#tab-umum"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')" href="#tab-antrovisus">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-antrovisus" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Antrovisus</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Berat badan</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="antrovisus_berat_badan" value="{{ $mcu->antrovisus->berat_badan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tinggi badan</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="antrovisus_tinggi_badan" value="{{ $mcu->antrovisus->tinggi_badan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">BMI</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="antrovisus_bmi" value="{{ $mcu->antrovisus->bmi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Visus kanan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_visus_kanan" value="{{ $mcu->antrovisus->visus_kanan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Visus kiri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_visus_kiri" value="{{ $mcu->antrovisus->visus_kiri }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Rekomendasi kacamata</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline"><label for="rekomendasi_kacamatanY"><input id="rekomendasi_kacamatanY" type="radio" name="antrovisus_rekomendasi_kacamatan" value="Y" {{ ($mcu->antrovisus->rekomendasi_kacamatan == 'Y')? 'checked':'' }}> Ya</label></div>
                                            <div class="radio radio-inline"><label for="rekomendasi_kacamatanN"><input id="rekomendasi_kacamatanN" type="radio" name="antrovisus_rekomendasi_kacamatan" value="N" {{ ($mcu->antrovisus->rekomendasi_kacamatan == 'N')? 'checked':'' }}> Tidak</label></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spheris kanan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_spheris_kanan" value="{{ $mcu->antrovisus->spheris_kanan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Cylinder kanan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_cylinder_kanan" value="{{ $mcu->antrovisus->cylinder_kanan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Axis kanan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_axis_kanan" value="{{ $mcu->antrovisus->axis_kanan }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Addition kanan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_addition_kanan" value="{{ $mcu->antrovisus->addition_kanan }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Shperis kiri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_spheris_kiri" value="{{ $mcu->antrovisus->spheris_kiri }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Cylinder kiri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_cylinder_kiri" value="{{ $mcu->antrovisus->cylinder_kiri }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Axis kiri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_axis_kiri" value="{{ $mcu->antrovisus->axis_kiri }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Addition kiri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_addition_kiri" value="{{ $mcu->antrovisus->addition_kiri }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pupil distance</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="antrovisus_pupil_distance" value="{{ $mcu->antrovisus->pupil_distance }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')" href="#tab-riwayat"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#fisik-tab')" href="#tab-fisik">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-fisik" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Fisik</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="fisik_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA" {{ $mcu->fisik?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="fisik_diperiksa" id="fisik_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->fisik?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kepala</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_kepala" value="{{ $mcu->fisik?$mcu->fisik->kepala:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mata</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_mata" value="{{ $mcu->fisik?$mcu->fisik->mata:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Telinga</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_telinga" value="{{ $mcu->fisik?$mcu->fisik->telinga:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hidung</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_hidung" value="{{ $mcu->fisik?$mcu->fisik->hidung:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tenggorokan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_tenggorokan" value="{{ $mcu->fisik?$mcu->fisik->tenggorokan:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leher</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_leher" value="{{ $mcu->fisik?$mcu->fisik->leher:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mulut</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_mulut" value="{{ $mcu->fisik?$mcu->fisik->mulut:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gigi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_gigi" value="{{ $mcu->fisik?$mcu->fisik->gigi:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Dada</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_dada" value="{{ $mcu->fisik?$mcu->fisik->dada:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Abdomen</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_abdomen" value="{{ $mcu->fisik?$mcu->fisik->abdomen:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Extremitas</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_extremitas" value="{{ $mcu->fisik?$mcu->fisik->extremitas:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Anogenital</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="fisik_anogenital" value="{{ $mcu->fisik?$mcu->fisik->anogenital:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')" href="#tab-antrovisus"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')" href="#tab-hematologi">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="hematologi_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA" {{ $mcu->hematologi?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="hematologi_diperiksa" id="fisik_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->hematologi?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hemoglobin</label>
                                        <div class="col-md-8">
											<input type="number" step="0.01" class="form-control input-xs" name="hematologi_hemoglobin" value="{{ $mcu->hematologi?$mcu->hematologi->hemoglobin:'' }}">
										</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hematokrit</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_hematokrit" value="{{ $mcu->hematologi?$mcu->hematologi->hematokrit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_eritrosit" value="{{ $mcu->hematologi?$mcu->hematologi->eritrosit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_leukosit" value="{{ $mcu->hematologi?$mcu->hematologi->leukosit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trombosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_trombosit" value="{{ $mcu->hematologi?$mcu->hematologi->trombosit:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Basofil</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_basofil" value="{{ $mcu->hematologi?$mcu->hematologi->basofil:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eosinofil</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_eosinofil" value="{{ $mcu->hematologi?$mcu->hematologi->eosinofil:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil batang</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_neutrofil_batang" value="{{ $mcu->hematologi?$mcu->hematologi->neutrofil_batang:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil segment</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_neutrofil_segment" value="{{ $mcu->hematologi?$mcu->hematologi->neutrofil_segment:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Limfosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_limfosit" value="{{ $mcu->hematologi?$mcu->hematologi->limfosit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Monosit</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_monosit" value="{{ $mcu->hematologi?$mcu->hematologi->monosit:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Laju endap darah</label>
                                        <div class="col-md-8"><input type="number" class="form-control input-xs" name="hematologi_laju_endap_darah" value="{{ $mcu->hematologi?$mcu->hematologi->laju_endap_darah:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCV</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mcv" value="{{ $mcu->hematologi?$mcu->hematologi->mcv:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCH</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mch" value="{{ $mcu->hematologi?$mcu->hematologi->mch:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCHC</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="hematologi_mchc" value="{{ $mcu->hematologi?$mcu->hematologi->mchc:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (ABO)</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="hematologi_golongan_darah_abo" value="{{ $mcu->hematologi?$mcu->hematologi->golongan_darah_abo:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (Rh)</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="hematologi_golongan_darah_rh" value="{{ $mcu->hematologi?$mcu->hematologi->golongan_darah_rh:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#fisik-tab')" href="#tab-fisik"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#kimia-tab')" href="#tab-kimia">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="kimia_diperiksa" id="fisik_diperiksa_yes" value="DIPERIKSA" {{ $mcu->kimia?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="kimia_diperiksa" id="fisik_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->kimia?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDS</label>
                                        <div class="col-md-6">
											<input type="number" step="0.01" class="form-control input-xs" name="kimia_gds" value="{{ $mcu->kimia?$mcu->kimia->gds:'' }}">
										</div>
										
										<div class="col-md-2">
											<?php
											 echo ambSatuan($satuan,'gds');
											?>
										</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDP</label>
                                        <div class="col-md-6"><input type="number" step="0.01" class="form-control input-xs" name="kimia_gdp" value="{{ $mcu->kimia?$mcu->kimia->gdp:'' }}"></div>
										<div class="col-md-2"><?php echo ambSatuan($satuan,'gdp'); ?></div>
										
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">2 jam PP</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_2_jam_pp" value="{{ $mcu->kimia?$mcu->kimia->dua_jam_pp:'' }}"></div>
										<div class="col-md-2"><?php echo ambSatuan($satuan,'2_jam_pp'); ?></div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HbA1c</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_hba1c" value="{{ $mcu->kimia?$mcu->kimia->hba1c:'' }}"></div>
										<div class="col-md-2"><?php echo ambSatuan($satuan,'hba1c'); ?></div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ureum</label>
                                        <div class="col-md-6"><input type="number" class="form-control input-xs" name="kimia_ureum" value="{{ $mcu->kimia?$mcu->kimia->ureum:'' }}"></div>
										<div class="col-md-2"><?php echo ambSatuan($satuan,'ureum'); ?></div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kreatinin</label>
                                        <div class="col-md-6"><input type="number" step="0.01" class="form-control input-xs" name="kimia_kreatinin" value="{{ $mcu->kimia?$mcu->kimia->kreatinin:'' }}"></div>
                                        <div class="col-md-2"><?php echo ambSatuan($satuan,'kreatinin'); ?></div>
									</div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">GFR</label>
                                        <div class="col-md-8"><input type="number"  step="0.01" class="form-control input-xs" name="kimia_gfr" value="{{ $mcu->kimia?$mcu->kimia->gfr:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Asam urat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_asam_urat" value="{{ $mcu->kimia?$mcu->kimia->asam_urat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin total</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_bilirubin_total" value="{{ $mcu->kimia?$mcu->kimia->bilirubin_total:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin direk</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_bilirubin_direk" value="{{ $mcu->kimia?$mcu->kimia->bilirubin_direk:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin indirek</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_bilirubin_indirek" value="{{ $mcu->kimia?$mcu->kimia->bilirubin_indirek:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGOT</label>
                                        <div class="col-md-6"><input type="number" class="form-control input-xs" name="kimia_sgot" value="{{ $mcu->kimia?$mcu->kimia->sgot:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGPT</label>
                                        <div class="col-md-6"><input type="number" class="form-control input-xs" name="kimia_sgpt" value="{{ $mcu->kimia?$mcu->kimia->sgpt:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_protein" value="{{ $mcu->kimia?$mcu->kimia->protein:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Albumin</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_albumin" value="{{ $mcu->kimia?$mcu->kimia->albumin:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkaline fosfatase</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_alkaline_fosfatase" value="{{ $mcu->kimia?$mcu->kimia->alkaline_fosfatase:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Choline esterase</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_choline_esterase" value="{{ $mcu->kimia?$mcu->kimia->choline_esterase:'' }}"></div>
										<div class="col-md-2">U/L</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gamma GT</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_gamma_gt" value="{{ $mcu->kimia?$mcu->kimia->gamma_gt:'' }}"></div>
										<div class="col-md-2">U/L</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trigliserida</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_trigliserida" value="{{ $mcu->kimia?$mcu->kimia->trigliserida:'' }}"></div>
										<div class="col-md-2">IU/L</div>
									</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolesterol total</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_kolesterol_total" value="{{ $mcu->kimia?$mcu->kimia->kolesterol_total:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HDL</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_hdl" value="{{ $mcu->kimia?$mcu->kimia->hdl:'' }}"></div>
                                        <div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL direk</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_ldl_direk" value="{{ $mcu->kimia?$mcu->kimia->ldl_direk:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL indirek</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_ldl_indirek" value="{{ $mcu->kimia?$mcu->kimia->ldl_indirek:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CK</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_ck" value="{{ $mcu->kimia?$mcu->kimia->ck:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CKMB</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="kimia_ckmb" value="{{ $mcu->kimia?$mcu->kimia->ckmb:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 1</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta1" value="{{ $mcu->kimia?$mcu->kimia->spuktum_bta1 : '' }}"></div>
										
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 2</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta2" value="{{ $mcu->kimia?$mcu->kimia->spuktum_bta2:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 3</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="kimia_spuktum_bta3" value="{{ $mcu->kimia?$mcu->kimia->spuktum_bta3:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')" href="#tab-hematologi"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')" href="#tab-audiometri">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div>
                <!--<div class="tab-pane fade" id="tab-oae" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> OAE</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="oae_diperiksa" id="oae_diperiksa_yes" value="DIPERIKSA" {{ $mcu->oae?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="oae_diperiksa" id="oae_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->oae?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ka</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_hasil_oae_ka" value="{{ $mcu->oae?$mcu->oae->hasil_oae_ka:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ki</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_hasil_oae_ki" value="{{ $mcu->oae?$mcu->oae->hasil_oae_ki:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="oae_kesimpulan" value="{{ $mcu->oae?$mcu->oae->kesimpulan_oae:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#kimia-tab')" href="#tab-kimia"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')" href="#tab-rontgen">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
                        </div>
                    </div>
                </div> -->
				<div class="tab-pane fade" id="tab-audiometri" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading"><strong><i class="fa fa-th-large"></i> Audiometri</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="audiometri_diperiksa_yes" value="DIPERIKSA" {{ $mcu->audiometri?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="audiometri_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->audiometri?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil Telinga Kiri </label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="audiometri_hasil_telinga_kiri" value="{{ $mcu->audiometri?$mcu->audiometri->hasil_telinga_kanan:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil Telinga Kanan </label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="audiometri_hasil_telinga_kanan" value="{{ $mcu->audiometri?$mcu->audiometri->hasil_telinga_kiri:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="audiometri_kesimpulan" value="{{ $mcu->audiometri?$mcu->audiometri->kesimpulan_audiometri:'' }}"></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="audiometri_hasil" value="{{ $mcu->audiometri?$mcu->audiometri->hasil_audiometri :'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#kimia-tab')" href="#tab-kimia"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')" href="#tab-rontgen">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rontgen_diperiksa" id="rontgen_diperiksa_yes" value="DIPERIKSA" {{ $mcu->rontgen?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rontgen_diperiksa" id="rontgen_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->rontgen?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesan Rontgen</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" id="kesan_rontgen" name="kesan_rontgen" value="{{ $mcu->rontgen?$mcu->rontgen->kesan_rontgen:'' }}"></div>
                                    </div>
                                </div>
                                <!--<div class="col-md-12">

                                    <div class="row">
                                        <div class="panel-heading"><i class="fa fa-th-list"></i> Detail <a id="add-rontgen" class="text-success pull-right" style="cursor: pointer"><i class="fa fa-plus-circle"></i> Add Input</a></div>
                                    </div>

                                    <div id="rontgen-detail">

                                        @foreach($mcu->rontgenDetail as $r)

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-1">
                                                <label for="">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-xs btn-block remove"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Jenis Foto</label>
                                                <input type="text" class="form-control input-xs" id="rontgen_jenis_foto" name="rontgen_jenis_foto[]" value="{{ $r->jenis_foto }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="" class="">Parameter</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_parameter[]" value="{{ $r->parameter }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="">Temuan</label>
                                                <input type="text" class="form-control input-xs" name="rontgen_temuan[]" value="{{ $r->temuan }}">
                                            </div>
                                        </div>

                                        @endforeach

                                    </div>

                                </div> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#oae-tab')" href="#tab-oae"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#serologi-tab')" href="#tab-serologi">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_hbsag" value="{{ $mcu->serologi->hbsag }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Anti HBs</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_anti_hbs" value="{{ $mcu->serologi->anti_hbs }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Tuberculosis</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_tuberculosis" value="{{ $mcu->serologi->tuberculosis }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgM salmonella</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igm_salmonella" value="{{ $mcu->serologi->igm_salmonella }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgG salmonella</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igg_salmonella" value="{{ $mcu->serologi->igg_salmonella }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela typhi O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_typhi_o" value="{{ $mcu->serologi->salmonela_typhi_o }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela typhi H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_typhi_h" value="{{ $mcu->serologi->salmonela_typhi_h }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela parathyphi A-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_o" value="{{ $mcu->serologi->salmonela_parathypi_a_o }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela parathyphi A-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_h" value="{{ $mcu->serologi->salmonela_parathypi_a_h }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyhphi B-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_o" value="{{ $mcu->serologi->salmonela_parathypi_b_o }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi B-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_h" value="{{ $mcu->serologi->salmonela_parathypi_b_h }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi C-O</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_o" value="{{ $mcu->serologi->salmonela_parathypi_c_o }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Salmonela paratyphi C-H</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_h" value="{{ $mcu->serologi->salmonela_parathypi_c_h }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">HCG</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_hcg" value="{{ $mcu->serologi->hcg }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">PSA</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_psa" value="{{ $mcu->serologi->psa }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">AFP</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_afp" value="{{ $mcu->serologi->afp }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">CEA</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_cea" value="{{ $mcu->serologi->cea }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgM toxo</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igm_toxo" value="{{ $mcu->serologi->igm_toxo }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">IgG toxo</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_igg_toxo" value="{{ $mcu->serologi->igg_toxo }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">CKMB</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_ckmb" value="{{ $mcu->serologi->ckmb_serologi }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Myoglobin</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_myoglobin" value="{{ $mcu->serologi->myoglobin }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Toponin I</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="serologi_troponin_i" value="{{ $mcu->serologi->troponin_i }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')" href="#tab-rontgen"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')" href="#tab-spirometri">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="spirometri_diperiksa" id="spirometri_diperiksa_yes" value="DIPERIKSA" {{ $mcu->spirometri?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="spirometri_diperiksa" id="spirometri_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->spirometri?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FEV</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_fev" value="{{ $mcu->spirometri?$mcu->spirometri->fev:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FVC</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_fvc" value="{{ $mcu->spirometri?$mcu->spirometri->fvc:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">PEF</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_pef" value="{{ $mcu->spirometri?$mcu->spirometri->pef:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="spirometri_kesimpulan" value="{{ $mcu->spirometri?$mcu->spirometri->kesimpulan_spirometri:'' }}"></div>
                                    </div>
									<div class="form-group row">
											<label for="" class="control-label col-md-4">Chart JPG</label>
											<div class="col-md-8">
												<input  accept=".jpg,.jpeg" id="file" type="file" name="file" class="form-control input-xs">
											</div>
									</div>
									<div class="form-group row">
										<label for="" class="control-label col-md-4">View Chart</label>
										<div class="col-md-6">
										  <img class="jom"  width="100" src="{{ asset('chart_spirometri/' . ($mcu->spirometri?$mcu->spirometri->chart : 'avatar1.jpg') ) }}" />
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#serologi-tab')" href="#tab-serologi"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#ekg-tab')" href="#tab-ekg">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="ekg_diperiksa" id="ekg_diperiksa_yes" value="DIPERIKSA" {{ $mcu->ekg ?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="ekg_diperiksa" id="ekg_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->ekg?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil EKG</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="ekg_hasil" >{{ $mcu->ekg?$mcu->ekg->hasil_ekg:'' }}</textarea></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan EKG</label>
                                        <div class="col-md-8"><textarea class="form-control input-xs" name="ekg_kesimpulan" >{{ $mcu->ekg?$mcu->ekg->kesimpulan_ekg:'' }}</textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')" href="#tab-spirometri"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')" href="#tab-treadmill">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="treadmill_diperiksa" id="treadmill_diperiksa_yes" value="DIPERIKSA" {{ $mcu->treadmill?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="treadmill_diperiksa" id="treadmill_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->treadmill?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Resting EKG</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_resting_ekg" value="{{ $mcu->treadmill?$mcu->treadmill->resting_ekg:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Bruce heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_bruce_heart_beat" value="{{ $mcu->treadmill?$mcu->treadmill->bruce_heart_beat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Capaian heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_capaian_heart_beat" value="{{ $mcu->treadmill?$mcu->treadmill->capaian_heart_beat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Capaian menit</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_capaian_menit" value="{{ $mcu->treadmill?$mcu->treadmill->capaian_menit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon heart beat</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_heart_beat" value="{{ $mcu->treadmill?$mcu->treadmill->respon_heart_beat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon Sistol</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_sistol" value="{{ $mcu->treadmill?$mcu->treadmill->respon_sistol:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Respon diastol</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_respon_diastol" value="{{ $mcu->treadmill?$mcu->treadmill->respon_diastol:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Aritmia</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_aritmia" value="{{ $mcu->treadmill?$mcu->treadmill->aritmia:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Nyeri dada</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_nyeri_dada" value="{{ $mcu->treadmill?$mcu->treadmill->nyeri_dada:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Gejala lain</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_gejala_lain" value="{{ $mcu->treadmill?$mcu->treadmill->gejala_lain:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Perubahan segmen ST</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_perubahan_segmen_st" value="{{ $mcu->treadmill?$mcu->treadmill->perubahan_segmen_st:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Lead</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_lead" value="{{ $mcu->treadmill?$mcu->treadmill->lead:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Lead pada menit ke</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_lead_pada_menit_ke" value="{{ $mcu->treadmill?$mcu->treadmill->lead_pada_menit_ke:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Normalisasi setelah</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_normalisasi_setelah" value="{{ $mcu->treadmill?$mcu->treadmill->normalisasi_setelah:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Functional class</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_functional_class" value="{{ $mcu->treadmill?$mcu->treadmill->functional_class:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Kapasitas aerobik</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_kapasitas_aerobik" value="{{ $mcu->treadmill?$mcu->treadmill->kapasitas_aerobik:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Tingkat kesegaran</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_tingkat_kesegaran" value="{{ $mcu->treadmill?$mcu->treadmill->tingkat_kesegaran:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Grafik</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_grafik" value="{{ $mcu->treadmill?$mcu->treadmill->grafik:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-6">Kesmipulan</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="treadmill_kesimpulan" value="{{ $mcu->treadmill?$mcu->treadmill->kesimpulan_treadmill:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#ekg-tab')" href="#tab-ekg"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')" href="#tab-audiometri">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA" {{ $mcu->audiometri?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="audiometri_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->audiometri?'':'checked' }}> Tidak</label>
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
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')" href="#tab-treadmill"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#feses-tab')" href="#tab-feses">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="feses_diperiksa" id="feses_diperiksa_yes" value="DIPERIKSA" {{ $mcu->feses ?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="feses_diperiksa" id="feses_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->feses ?'':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_warna" value="{{ $mcu->feses?$mcu->feses->warna_feses:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Konsistensi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_konsistensi" value="{{ $mcu->feses?$mcu->feses->konsistensi:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_darah" value="{{ $mcu->feses?$mcu->feses->darah_feses:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lendir</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lendir" value="{{ $mcu->feses?$mcu->feses->lendir:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_eritrosit" value="{{ $mcu->feses?$mcu->feses->eritrosit_feses:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_leukosit" value="{{ $mcu->feses?$mcu->feses->leukosit_feses:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Amoeba</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_amoeba" value="{{ $mcu->feses?$mcu->feses->amoeba:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-hystolitica</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_e_hystolitica" value="{{ $mcu->feses?$mcu->feses->e_hystolitica:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_e_coli" value="{{ $mcu->feses?$mcu->feses->e_coli_feses:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kista</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_kista" value="{{ $mcu->feses?$mcu->feses->kista:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ascaris</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_ascaris" value="{{ $mcu->feses?$mcu->feses->ascaris:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Oxyuris</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_oxyuris" value="{{ $mcu->feses?$mcu->feses->oxyuris:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Serat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_serat" value="{{ $mcu->feses?$mcu->feses->serat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lemak</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lemak" value="{{ $mcu->feses?$mcu->feses->lemak:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Karbohidrat</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_karbohidrat" value="{{ $mcu->feses?$mcu->feses->karbohidrat:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Benzidine</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_benzidine" value="{{ $mcu->feses?$mcu->feses->benzidine:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lain-lain</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="feses_lain_lain" value="{{ $mcu->feses?$mcu->feses->lain_lain:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')" href="#tab-audiometri"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#urin-tab')" href="#tab-urin">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="urin_diperiksa" id="urin_diperiksa_yes" value="DIPERIKSA" {{ $mcu->urin?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="urin_diperiksa" id="urin_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->urin? '' : 'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_warna" value="{{ $mcu->urin?$mcu->urin->warna_urin:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kejernihan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_kejernihan" value="{{ $mcu->urin?$mcu->urin->kejernihan:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Berat jenis</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_berat_jenis" value="{{ $mcu->urin?$mcu->urin->berat_jenis:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">pH</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_ph" value="{{ $mcu->urin?$mcu->urin->ph:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein urin</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_protein_urin" value="{{ $mcu->urin?$mcu->urin->protein_urin:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Reduksi</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_reduksi" value="{{ $mcu->urin?$mcu->urin->reduksi:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Keton</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_keton" value="{{ $mcu->urin?$mcu->urin->keton:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin</label>
                                        <div class="col-md-6"><input type="text" class="form-control input-xs" name="urin_bilirubin" value="{{ $mcu->urin?$mcu->urin->bilirubin:'' }}"></div>
										<div class="col-md-2">mg/dl</div>
									</div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Urobilinogen</label>
                                        <div class="col-md-8"><input type="number" step="0.01" class="form-control input-xs" name="urin_urobilinogen" value="{{ $mcu->urin?$mcu->urin->urobilinogen:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit esterase</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_leukosit_esterase" value="{{ $mcu->urin?$mcu->urin->leukosit_esterase:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_darah" value="{{ $mcu->urin?$mcu->urin->darah_urin:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nitrit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_nitrit" value="{{ $mcu->urin?$mcu->urin->nitrit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen eritrosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_sedimen_eritrosit" value="{{ $mcu->urin?$mcu->urin->sedimen_eritrosit:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen leukosit</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_sedimen_leukosit" value="{{ $mcu->urin?$mcu->urin->sedimen_leukosit:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Epitel</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_epitel" value="{{ $mcu->urin?$mcu->urin->epitel:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Silinder</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_silinder" value="{{ $mcu->urin?$mcu->urin->silinder:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kristal</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_kristal" value="{{ $mcu->urin?$mcu->urin->kristal:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bakteri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_bakteri" value="{{ $mcu->urin?$mcu->urin->bakteri:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jamur</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_jamur" value="{{ $mcu->urin?$mcu->urin->jamur:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HCG</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="urin_hcg" value="{{ $mcu->urin?$mcu->urin->hcg_urin:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#feses-tab')" href="#tab-feses"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')" href="#tab-pap-smear">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="pap_smear_tgl_terima" name="pap_smear_tgl_terima" value="{{ $mcu->papSmear?$mcu->papSmear->tgl_terima:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. selesai</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs datepicker" id="pap_smear_tgl_selesai" name="pap_smear_tgl_selesai" value="{{ $mcu->papSmear?$mcu->papSmear->tgl_selesai:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bahan pemeriksaan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_bahan_pemeriksaan" value="{{ $mcu->papSmear?$mcu->papSmear->bahan_pemeriksaan:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Makroskopik</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_makroskopik" value="{{ $mcu->papSmear?$mcu->papSmear->makroskopik:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mikroskopik</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_mikroskopik" value="{{ $mcu->papSmear?$mcu->papSmear->mikroskopik:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="pap_smear_kesimpulan" value="{{ $mcu->papSmear?$mcu->papSmear->kesimpulan_pap_smear:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#urin-tab')" href="#tab-urin"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')" href="#tab-rectal-swab">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rectal_swab_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA" {{ $mcu->rectalSwab ?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="rectal_swab_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA" {{ $mcu->rectalSwab? '':'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Typoid</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_typoid" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->typoid:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diare</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_diare" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->diare:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Disentri</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_disentri" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->disentri:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolera</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_kolera" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->kolera:'' }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonella</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_salmonella" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->salmonella:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Shigella</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_shigella" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->shigella:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_e_coli" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->e_coli:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Vibrio cholera</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_vibrio_cholera" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->vibrio_cholera:'' }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" name="rectalswab_kesimpulan" value="{{ $mcu->rectalSwab?$mcu->rectalSwab->kesimpulan_rectal_swab:'' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')" href="#tab-pap-smear"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#drug-screening-tab')" href="#tab-drug-screening">Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
                                        <label for="" class="control-label col-md-4">Diperiksa</label>
                                        <div class="col-md-8">
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="drug_screening_diperiksa" id="rectal_swab_diperiksa_yes" value="DIPERIKSA" {{ $mcu->DrugScreening ?'checked':'' }}> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label><input type="radio" name="drug_screening_diperiksa" id="rectal_swab_diperiksa_no" value="TIDAK DIPERIKSA"  {{ $mcu->DrugScreening? '' : 'checked' }}> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan Drug Screening</label>
                                        <div class="col-md-8"><input type="text" class="form-control input-xs" id="drug_screening_kesimpulan" name="drug_screening_kesimpulan" value="{{ $mcu->DrugScreening?$mcu->DrugScreening->kesimpulan_drug_screening:'' }}" ></div>
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
                            <a class="btn btn-default" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')" href="#tab-rectal-swab"><i class="fa fa-chevron-left"></i> Previous</a> &nbsp;
                            <a class="btn btn-default" data-toggle="tab" disabled>Next <i class="fa fa-chevron-right"></i></a> &nbsp;
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
		/*
        $('#add-audiometri').click(function() {
            var dsContent = `<div class="row" style="margin-bottom: 10px">
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
                                        <input type="text" class="form-control input-xs" name="audiometri_kiri[]" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="">Kanan</label>
                                        <input type="text" class="form-control input-xs" name="audiometri_kanan[]" >
                                    </div>
                                </div>`;
            $('#audiometri-detail').append(dsContent);
        }); */

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
