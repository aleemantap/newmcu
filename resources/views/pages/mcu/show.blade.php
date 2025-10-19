@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumb">
    <li><a>Database</a></li>
    <li>Medical Check Up</li>
    <li>Create</li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="tabs" role="tablist">
            <li class="nav-item active"><a class="nav-link" data-toggle="tab" aria-selected="true" href="#tab-identitas" id="identitas-tab">Identitas</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-umum" id="umum-tab">Umum</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-riwayat" id="riwayat-tab">Riwayat</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-antrovisus" id="antrovisus-tab">Antrovisus</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-fisik" id="fisik-tab">Fisik</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-hematologi" id="hematologi-tab">Hematologi</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-kimia" id="kimia-tab">Kimia</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-oae" id="oae-tab">OAE</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-rontgen" id="rontgen-tab">Rontgen</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-serologi" id="serologi-tab">Serologi</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-spirometri" id="spirometri-tab">Spirometri</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-treadmill" id="treadmill-tab">Treadmill</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" aria-selected="false" href="#tab-audiometri" id="audiometri-tab">Audiometri</a></li>
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

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: top, left; top: 37px; left: 0px;">
                    <a class="dropdown-item" data-toggle="tab" href="#tab_default-2" role="tab" aria-selected="true" aria-expanded="true">Personal</a>
                    <a class="dropdown-item" href="#">Friends</a>
                    <a class="dropdown-item" href="#">Settings</a>
                </div>
            </li>
        </ul>
        <form method="post" action="{{ URL::to('/database/medical-check-up/update') }}">
            @csrf
            <input readonly type="hidden" name="mcu_id" value="{{ $mcu->id }}">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab-identitas" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Identitas</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">No. NIP</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_no_nip" value="{{ $mcu->no_nip }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">No. Paper</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_no_paper" value="{{ $mcu->no_paper}}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nama pasien</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_nama_pasien" value="{{ $mcu->nama_pasien }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. lahir</label>
                                        <div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="mcu_tgl_lahir" value="{{ $mcu->tgl_lahir }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jenis kelamin</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="mcu_jenis_kelamin" value="{{ $mcu->jenis_kelamin }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bagian</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_bagian" value="{{ $mcu->bagian }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Paket MCU</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_paket_mcu" value="{{ $mcu->paket_mcu }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. Kerja</label>
                                        <div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="mcu_tgl_kerja" value="{{ $mcu->tgl_kerja }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Email</label>
                                        <div class="col-md-8"><input readonly type="email" class="form-control input-xs" name="mcu_email" value="{{ $mcu->email }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Telepon</label>
                                        <div class="col-md-8"><input readonly type="tel" class="form-control input-xs" name="mcu_telepon" value="{{ $mcu->telepon }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Client</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_client" value="{{ $mcu->client }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Customer</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_customer_name" value="{{ $mcu->customer->name }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Published</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="mcu_client" value="{{ $mcu->published }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" disabled><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#umum-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-umum" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Umum</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nadi</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="umum_nadi" value="{{ $mcu->umum->nadi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sistolik</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="umum_sistolik" value="{{ $mcu->umum->sistolik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diastolik</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="umum_diastolik" value="{{ $mcu->umum->diastolik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Respirasi</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="umum_respirasi" value="{{ $mcu->umum->respirasi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Suhu</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="umum_suhu" value="{{ $mcu->umum->suhu }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#identitas-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Riwayat</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Keluhan utama</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_keluhan_utama" value="{{ $mcu->riwayat->keluhan_utama }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat alergi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_riwayat_alergi" value="{{ $mcu->riwayat->riwayat_alergi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat penyakit sekarang</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_riwayat_penyakit_sekarang" value="{{ $mcu->riwayat->riwayat_penyakit_sekarang }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan dahulu</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_dahulu" value="{{ $mcu->riwayat->riwayat_kesehatan_dahulu }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan keluarga</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_keluarga" value="{{ $mcu->riwayat->riwayat_kesehatan_keluarga }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Riwayat kesehatan pribadi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_riwayat_kesehatan_pribadi" value="{{ $mcu->riwayat->riwayat_kesehatan_pribadi }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Olahraga</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_riwayat_olahraga" value="{{ $mcu->riwayat->olahraga }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Frekuensi perminggu</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_frekuensi_per_minggu" value="{{ $mcu->riwayat->frekuensi_per_minggu }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Merokok</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_riwayat_merokok" value="{{ $mcu->riwayat->merokok }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bungkus perhari</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_rokok_bungkus_per_hari" value="{{ $mcu->riwayat->rokok_bungkus_per_hari }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kopi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_riwayat_kopi" value="{{ $mcu->riwayat->kopi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gelas perhari</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_kopi_gelas_per_hari" value="{{ $mcu->riwayat->kopi_gelas_per_hari }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_riwayat_alkohol" value="{{ $mcu->riwayat->alkohol }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkohol sebanyak</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_alkohol_sebanyak" value="{{ $mcu->riwayat->alkohol_sebanyak }}"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama tidur perhari</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_lama_tidur_per_hari"  value="{{ $mcu->riwayat->lama_tidur_per_hari }}"required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah kecelakaan kerja</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat__pernah_kecelakaan_kerja" value="{{ $mcu->riwayat->pernah_kecelakaan_kerja }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tahun kecelakaan kerja</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_tahun_kecelakaan_kerja" value="{{ $mcu->riwayat->tahun_kecelakaan_kerja }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tempat kerja berbahaya</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_tempat_kerja_berbahaya" value="{{ $mcu->riwayat->tempat_kerja_berbahaya }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pernah rawat inap</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="riwayat_pernah_rawat_inap" value="{{ $mcu->riwayat->pernah_rawat_inap }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lama rawat inap (hari)</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="riwayat_hari_lama_rawat_inap" value="{{ $mcu->riwayat->hari_lama_rawat_inap }}"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Rawat inap karena penyakit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="riwayat_rawat_inap_penyakit" value="{{ $mcu->riwayat->rawat_inap_penyakit }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#umum-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-antrovisus" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Antrovisus</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Berat badan</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="antrovisus_berat_badan" value="{{ $mcu->antrovisus->berat_badan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tinggi badan</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="antrovisus_tinggi_badan" value="{{ $mcu->antrovisus->tinggi_badan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">BMI</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="antrovisus_bmi" value="{{ $mcu->antrovisus->bmi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Visus kanan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_visus_kanan" value="{{ $mcu->antrovisus->visus_kanan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Visus kiri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_visus_kiri" value="{{ $mcu->antrovisus->visus_kiri }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Rekomendasi kacamata</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="antrovisus_rekomendasi_kacamatan" value="{{ $mcu->antrovisus->rekomendasi_kacamatan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spheris kanan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_spheris_kanan" value="{{ $mcu->antrovisus->spheris_kanan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Cylinder kanan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_cylinder_kanan" value="{{ $mcu->antrovisus->cylinder_kanan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Axis kanan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_axis_kanan" value="{{ $mcu->antrovisus->axis_kanan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Addition kanan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_addition_kanan" value="{{ $mcu->antrovisus->addition_kanan }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Shperis kiri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_spheris_kiri" value="{{ $mcu->antrovisus->spheris_kiri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Cylinder kiri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_cylinder_kiri" value="{{ $mcu->antrovisus->cylinder_kiri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Axis kiri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_axis_kiri" value="{{ $mcu->antrovisus->axis_kiri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Addition kiri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_addition_kiri" value="{{ $mcu->antrovisus->addition_kiri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Pupil distance</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="antrovisus_pupil_distance" value="{{ $mcu->antrovisus->pupil_distance }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#riwayat-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#fisik-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-fisik" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Fisik</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kepala</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_kepala" value="{{ $mcu->fisik->kepala }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mata</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_mata" value="{{ $mcu->fisik->mata }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Telinga</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_telinga" value="{{ $mcu->fisik->telinga }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hidung</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_hidung" value="{{ $mcu->fisik->hidung }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tenggorokan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_tenggorokan" value="{{ $mcu->fisik->tenggorokan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leher</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_leher" value="{{ $mcu->fisik->leher }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mulut</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_mulut" value="{{ $mcu->fisik->mulut }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gigi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_gigi" value="{{ $mcu->fisik->gigi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Dada</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_dada" value="{{ $mcu->fisik->dada }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Abdomen</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_abdomen" value="{{ $mcu->fisik->abdomen }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Extremitas</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_extremitas" value="{{ $mcu->fisik->extremitas }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Anogenital</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="fisik_anogenital" value="{{ $mcu->fisik->anogenital }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#antrovisus-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-hematologi" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Hematologi</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hemoglobin</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_hemoglobin" value="{{ $mcu->hematologi->hemoglobin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hematokrit</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_hematokrit" value="{{ $mcu->hematologi->hematokrit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_eritrosit" value="{{ $mcu->hematologi->eritrosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_leukosit" value="{{ $mcu->hematologi->leukosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trombosit</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_trombosit" value="{{ $mcu->hematologi->trombosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Basofil</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_basofil" value="{{ $mcu->hematologi->basofil }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eosinofil</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_eosinofil" value="{{ $mcu->hematologi->eosinofil }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil batang</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_neutrofil_batang" value="{{ $mcu->hematologi->neutrofil_batang }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Neutrofil segment</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_neutrofil_segment" value="{{ $mcu->hematologi->neutrofil_segment }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Limfosit</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_limfosit" value="{{ $mcu->hematologi->limfosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Monosit</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_monosit" value="{{ $mcu->hematologi->monosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Laju endap darah</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="hematologi_laju_endap_darah" value="{{ $mcu->hematologi->laju_endap_darah }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCV</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_mcv" value="{{ $mcu->hematologi->mcv }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCH</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_mch" value="{{ $mcu->hematologi->mch }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCHC</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="hematologi_mchc" value="{{ $mcu->hematologi->mchc }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (ABO)</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="hematologi_golongan_darah_abo" value="{{ $mcu->hematologi->golongan_darah_abo }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Golongan darah (Rh)</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="hematologi_golongan_darah_rh" value="{{ $mcu->hematologi->golongan_darah_rh }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#fisik-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#kimia-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-kimia" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Kimia</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDS</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="kimia_gds" value="{{ $mcu->kimia->gds }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">GDP</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="kimia_gdp" value="{{ $mcu->kimia->gdp }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">2 jam PP</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_2_jam_pp" value="{{ $mcu->kimia->jam_pp }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HbA1c</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_hba1c" value="{{ $mcu->kimia->hba1c }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ureum</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="kimia_ureum" value="{{ $mcu->kimia->ureum }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kreatinin</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="kimia_kreatinin" value="{{ $mcu->kimia->kreatinin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Asam urat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_asam_urat" value="{{ $mcu->kimia->asam_urat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin total</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_bilirubin_total" value="{{ $mcu->kimia->bilirubin_total }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin direk</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_bilirubin_direk" value="{{ $mcu->kimia->bilirubin_direk }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin indirek</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_bilirubin_indirek" value="{{ $mcu->kimia->bilirubin_indirek }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGOT</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="kimia_sgot" value="{{ $mcu->kimia->sgot }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">SGPT</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="kimia_sgpt" value="{{ $mcu->kimia->sgpt }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_protein" value="{{ $mcu->kimia->protein }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Albumin</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_albumin" value="{{ $mcu->kimia->albumin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Alkaline fosfatase</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_alkaline_fosfatase" value="{{ $mcu->kimia->alkaline_fosfatase }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Choline esterase</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_choline_esterase" value="{{ $mcu->kimia->choline_esterase }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gamma GT</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_gamma_gt" value="{{ $mcu->kimia->gamma_gt }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Trigliserida</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_trigliserida" value="{{ $mcu->kimia->trigliserida }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolesterol total</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_kolesterol_total" value="{{ $mcu->kimia->kolesterol_total }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HDL</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_hdl" value="{{ $mcu->kimia->hdl }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL direk</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_ldl_direk" value="{{ $mcu->kimia->ldl_direk }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">LDL indirek</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_ldl_indirek" value="{{ $mcu->kimia->ldl_indirek }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CK</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_ck" value="{{ $mcu->kimia->ck }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CKMB</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_ckmb" value="{{ $mcu->kimia->ckmb }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 1</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_spuktum_bta1" value="{{ $mcu->kimia->spuktum_bta1 }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 2</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_spuktum_bta2" value="{{ $mcu->kimia->spuktum_bta2 }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Spuktum BTA 3</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="kimia_spuktum_bta3" value="{{ $mcu->kimia->spuktum_bta3 }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#hematologi-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#oae-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-oae" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">OAE</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ka</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="oae_hasil_oae_ka" value="{{ $mcu->oae->hasil_oae_ka }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil OAE Ki</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="oae_hasil_oae_ki" value="{{ $mcu->oae->hasil_oae_ki }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="oae_kesimpulan" value="{{ $mcu->oae->kesimpulan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#kimia-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-rontgen" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Rontgen</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jenis foto</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rontgen_jenis_foto" value="{{ $mcu->rontgen[0]->jenis_foto }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Parameter</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rontgen_parameter" value="{{ $mcu->rontgen[0]->parameter }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Temuan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rontgen_temuan" value="{{ $mcu->rontgen[0]->temuan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#oae-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#serologi-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-serologi" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Serologi</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HBSAg</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_hbsag" value="{{ $mcu->serologi->hbsag }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Anti HBs</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_anti_hbs" value="{{ $mcu->serologi->hbs }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tuberculosis</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_tuberculosis" value="{{ $mcu->serologi->tuberculosis }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">IgM salmonella</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_igm_salmonella" value="{{ $mcu->serologi->igm_salmonella }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">IgG salmonella</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_igg_salmonella" value="{{ $mcu->serologi->igg_salmonella }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela typhi O</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_typhi_o" value="{{ $mcu->serologi->salmonela_typhi_o }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela typhi H</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_typhi_h" value="{{ $mcu->serologi->salmonela_typhi_h }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela parathyphi A-O</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_o" value="{{ $mcu->serologi->salmonela_parathypi_a_o }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela parathyphi A-H</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_a_h" value="{{ $mcu->serologi->salmonela_parathypi_a_h }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela paratyhphi B-O</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_o" value="{{ $mcu->serologi->salmonela_parathypi_b_o }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela paratyphi B-H</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_b_h" value="{{ $mcu->serologi->salmonela_parathypi_b_h }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela paratyphi C-O</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_o" value="{{ $mcu->serologi->salmonela_parathypi_c_o }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonela paratyphi C-H</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_salmonela_parathypi_c_h" value="{{ $mcu->serologi->salmonela_parathypi_c_h }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HCG</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_hcg" value="{{ $mcu->serologi->hcg }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">PSA</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_psa" value="{{ $mcu->serologi->psa }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">AFP</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_afp" value="{{ $mcu->serologi->afp }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CEA</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_cea" value="{{ $mcu->serologi->cea }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">IgM toxo</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_igm_toxo" value="{{ $mcu->serologi->igm_toxo }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">IgG toxo</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_igg_toxo" value="{{ $mcu->serologi->igg_toxo }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">CKMB</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_ckmb" value="{{ $mcu->serologi->ckmb }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Myoglobin</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_myoglobin" value="{{ $mcu->serologi->myoglobin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Toponin I</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="serologi_troponin_i" value="{{ $mcu->serologi->troponin_i }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#rontgen-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-spirometri" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Spirometri</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FEV</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="spirometri_fev" value="{{ $mcu->spirometri->fev }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">FVC</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="spirometri_fvc" value="{{ $mcu->spirometri->fvc }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">PEF</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="spirometri_pef" value="{{ $mcu->spirometri->pef }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="spirometri_kesimpulan" value="{{ $mcu->spirometri->kesimpulan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#serologi-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-treadmill" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Treadmill</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Resting EKG</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_resting_ekg" value="{{ $mcu->treadmill->resting_ekg }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bruce heart beat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_bruce_heart_beat" value="{{ $mcu->treadmill->bruce_heart_beat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Capaian heart beat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_capaian_heart_beat" value="{{ $mcu->treadmill->capaian_heart_beat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Capaian menit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_capaian_menit" value="{{ $mcu->treadmill->capaian_menit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Respon heart beat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_respon_heart_beat" value="{{ $mcu->treadmill->respon_heart_beat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Respon Sistol</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_respon_sistol" value="{{ $mcu->treadmill->respon_sistol }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Respon diastol</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_respon_diastol" value="{{ $mcu->treadmill->respon_diastol }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Aritmia</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_aritmia" value="{{ $mcu->treadmill->aritmia }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nyeri dada</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_nyeri_dada" value="{{ $mcu->treadmill->nyeri_dada }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Gejala lain</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_gejala_lain" value="{{ $mcu->treadmill->gejala_lain }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Perubahan segmen ST</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_perubahan_segmen_st" value="{{ $mcu->treadmill->perubahan_segmen_st }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lead</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_lead" value="{{ $mcu->treadmill->lead }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lead pada menit ke</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_lead_pada_menit_ke" value="{{ $mcu->treadmill->lead_pada_menit_ke }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Normalisasi setelah</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_normalisasi_setelah" value="{{ $mcu->treadmill->normalisasi_setelah }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Functional class</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_functional_class" value="{{ $mcu->treadmill->functional_class }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kapasitas aerobik</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_kapasitas_aerobik" value="{{ $mcu->treadmill->kapasitas_aerobik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tingkat kesegaran</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_tingkat_kesegaran" value="{{ $mcu->treadmill->tingkat_kesegaran }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Grafik</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_grafik" value="{{ $mcu->treadmill->grafik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesmipulan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="treadmill_kesimpulan" value="{{ $mcu->treadmill->kesimpulan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#spirometri-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-audiometri" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Audiometri</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Frekuensi</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="audiometri_frekuensi" value="{{ $mcu->audiometri[0]->frekuensi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kiri</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="audiometri_kiri" value="{{ $mcu->audiometri[0]->kiri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kanan</label>
                                        <div class="col-md-8"><input readonly type="number" class="form-control input-xs" name="audiometri_kanan" value="{{ $mcu->audiometri[0]->kanan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#treadmill-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#feses-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-feses" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Feses</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_warna" value="{{ $mcu->feses->warna }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Konsistensi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_konsistensi" value="{{ $mcu->feses->konsistensi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_darah" value="{{ $mcu->feses->darah }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lendir</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_lendir" value="{{ $mcu->feses->lendir }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Eritrosit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_eritrosit" value="{{ $mcu->feses->eritrosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_leukosit" value="{{ $mcu->feses->leukosit }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Amoeba</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_amoeba" value="{{ $mcu->feses->amoeba }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-hystolitica</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_e_hystolitica" value="{{ $mcu->feses->e_hystolitica }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_e_coli" value="{{ $mcu->feses->feses_e_coli }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kista</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_kista" value="{{ $mcu->feses->kista }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Ascaris</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_ascaris" value="{{ $mcu->feses->ascaris }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Oxyuris</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_oxyuris" value="{{ $mcu->feses->oxyuris }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Serat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_serat" value="{{ $mcu->feses->serat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lemak</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_lemak" value="{{ $mcu->feses->lemak }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Karbohidrat</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_karbohidrat" value="{{ $mcu->feses->karbohidrat }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Benzidine</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_benzidine" value="{{ $mcu->feses->benzidin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Lain-lain</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="feses_lain_lain" value="{{ $mcu->feses->lain_lain }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#audiometri-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#urin-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-urin" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Urin</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Warna</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_warna" value="{{ $mcu->urin->warna }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kejernihan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_kejernihan" value="{{ $mcu->urin->kejernihan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Berat jenis</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="urin_berat_jenis" value="{{ $mcu->urin->berat_jenis }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">pH</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="urin_ph" value="{{ $mcu->urin->ph }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Protein urin</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_protein_urin" value="{{ $mcu->urin->protein_urin }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Reduksi</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_reduksi" value="{{ $mcu->urin->reduksi }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Keton</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_keton" value="{{ $mcu->urin->keton }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bilirubin</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_bilirubin" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Urobilinogen</label>
                                        <div class="col-md-8"><input readonly type="number" step="0.01" class="form-control input-xs" name="urin_urobilinogen" value="{{ $mcu->urin->urobilinogen }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Leukosit esterase</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_leukosit_esterase" value="{{ $mcu->urin->leukosit_esterase }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Darah</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_darah" value="{{ $mcu->urin->darah }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nitrit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_nitrit" value="{{ $mcu->urin->nitrit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen eritrosit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_sedimen_eritrosit" value="{{ $mcu->urin->sedimen_eritrosit }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Sedimen leukosit</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_sedimen_leukosit" value="{{ $mcu->urin->sedimen_leukosit }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Epitel</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_epitel" value="{{ $mcu->urin->epitel }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Silinder</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_silinder" value="{{ $mcu->urin->silinder }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kristal</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_kristal" value="{{ $mcu->urin->kristal }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bakteri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_bakteri" value="{{ $mcu->urin->bakteri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Jamur</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_jamur" value="{{ $mcu->urin->jamur }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">HCG</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="urin_hcg" value="{{ $mcu->urin->hcg }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#feses-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pap-smear" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Pap Smear</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. terima</label>
                                        <div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="pap_smear_tgl_terima" value="{{ $mcu->papSmear->tgl_terima }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. selesai</label>
                                        <div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="pap_smear_tgl_selesai" value="{{ $mcu->papSmear->tgl_selesai }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bahan pemeriksaan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="pap_smear_bahan_pemeriksaan" value="{{ $mcu->papSmear->bahan_pemeriksaan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Makroskopik</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="pap_smear_makroskopik" value="{{ $mcu->papSmear->makroskopik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Mikroskopik</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="pap_smear_mikroskopik" value="{{ $mcu->papSmear->mikroskopik }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="pap_smear_kesimpulan" value="{{ $mcu->papSmear->kesimpulan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#urin-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-rectal-swab" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Rectal Swab</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Typoid</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_typoid" value="{{ $mcu->rectalSwab->typoid }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Diare</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_diare" value="{{ $mcu->rectalSwab->diare }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Disentri</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_disentri" value="{{ $mcu->rectalSwab->disentri }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kolera</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_kolera" value="{{ $mcu->rectalSwab->kolera }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Salmonella</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_salmonella" value="{{ $mcu->rectalSwab->salmonella }}" required></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Shigella</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_shigella" value="{{ $mcu->rectalSwab->shigella }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">E-coli</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_e_coli" value="{{ $mcu->rectalSwab->e_coli }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Vibrio cholera</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_vibrio_cholera" value="{{ $mcu->rectalSwab->vibrio_cholera }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Kesimpulan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="rectalswab_kesimpulan" value="{{ $mcu->rectalSwab->kesimpulan }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#pap-smear-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#drug-screening-tab')">Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-drug-screening" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">Drug Screening</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. pemeriksaan</label>
                                        <div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="drug_screening_tgl_pemeriksaan" value="{{ $mcu->drugScreening[0]->tgl_pemeriksaan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Status pemeriksaan</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="drug_screening_status_pemeriksaan" value="{{ $mcu->drugScreening[0]->status_pemeriksaan }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Parameter</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="drug_screening_parameter" value="{{ $mcu->drugScreening[0]->parameter }}" required></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Hasil</label>
                                        <div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="drug_screening_hasil" value="{{ $mcu->drugScreening[0]->hasil }}" required></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-success" data-toggle="tab" onclick="tabSwitch('#rectal-swab-tab')"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                            <a class="btn btn-success" data-toggle="tab" disabled>Next <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>




</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $.each($("input.radio"), function(value){
            switch($(this).val()) {
                case "Y":
                    $(this).before("<div class='form-control input-xs'><i class='fa fa-check-square'></i> Ya</div>");
                    $(this).remove();
                    break;
                case "N":
                    $(this).before("<div class='form-control input-xs'><i class='fa fa-minus-square'></i> Tidak</div>");
                    $(this).remove();
                    break;
                case "L":
                    $(this).val("Pria");
                    break;
                case "P":
                    $(this).val("Wanita");
                    break;
            }
        });
    });
    function tabSwitch(id){
        event.preventDefault();
        $(id).tab('show');
    }
</script>
@endsection
