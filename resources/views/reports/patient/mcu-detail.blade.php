@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('title', "Report Detail")
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a href="#">Pasien</a></li>
        <li><a href="{{ url('/report/patient/medical-check-up') }}">Medical Check Up</a></li>
        <li class="active"><span>{{ $mcu->id }}</span></li>
    </ul>

@endsection

@section('content')
<style>

.tbl .td-b {
	  white-space: normal !important;
}
.basic-text-bb{
	border-bottom:2px solid #a0a0a0;
}
</style>
<div class=" mb-3">
    <div class="row">
        <div class="col-12 mt-5">
        <div class="card">
        <div class="card-body">

            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Identitas</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row p-3">
                        <div class="col-md-4"> 
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Medical Id :</label>
                                <div class="col-md-7"><span class="basic-text">{{ (int) substr($mcu->id, 12, 8) }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">No. NIP :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->no_nip }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">No. Paper :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->no_paper }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Nama pasien :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->nama_pasien }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tgl. lahir :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->tgl_lahir }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Jenis kelamin :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->jenis_kelamin }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bagian :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->bagian }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Paket MCU :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->paket_mcu }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tgl. Kerja :</label>
                                <div class="col-md-7"><span class="basic-text" id="mcu_tgl_kerja">{{ $mcu->tgl_kerja }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Email :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->email }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Telepon :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->telepon }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Client :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->client }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Customer :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->vendorCustomer->customer->name }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tgl. Input :</label>
                                <div class="col-md-7"><span class="basic-text" id="mcu_tgl_input">{{ $mcu->tgl_input }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Tanda Vital</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Nadi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->umum->nadi }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Sistolik :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->umum->sistolik }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Diastolik :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->umum->diastolik }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Respirasi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->umum->respirasi }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Suhu :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->umum->suhu }} &deg;C</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Riwayat</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Keluhan utama :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->keluhan_utama }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Riwayat alergi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->riwayat_alergi }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Riwayat penyakit sekarang:</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->riwayat_penyakit_sekarang }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Riwayat kesehatan dahulu:</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->riwayat_kesehatan_dahulu }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Riwayat kesehatan keluarga:</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->riwayat_kesehatan_keluarga }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Riwayat kesehatan pribadi:</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->riwayat_kesehatan_pribadi }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Olahraga :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->olahraga == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Frekuensi perminggu :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->frekuensi_per_minggu }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Merokok :</label>
                                <div class="col-md-7">
                                    <span  id="olahragaY" class="basic-text">{{ ($mcu->riwayat->merokok == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bungkus perhari :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->rokok_bungkus_per_hari }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kopi :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->kopi == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Gelas perhari :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->kopi_gelas_per_hari }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Alkohol :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->alkohol == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Alkohol sebanyak :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->alkohol_sebanyak }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Lama tidur perhari :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->lama_tidur_per_hari }} jam</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Pernah kecelakaan kerja :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->pernah_kecelakaan_kerja == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tahun kecelakaan kerja :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->tahun_kecelakaan_kerja }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tempat kerja berbahaya :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->tempat_kerja_berbahaya == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Pernah rawat inap :</label>
                                <div class="col-md-7">
                                    <span class="basic-text">{{ ($mcu->riwayat->pernah_rawat_inap == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Lama rawat inap (hari) :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->hari_lama_rawat_inap }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Rawat inap karena penyakit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->riwayat->rawat_inap_penyakit }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Antrovisus</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Berat badan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->berat_badan }} kg</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tinggi badan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->tinggi_badan }} cm</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">BMI :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->bmi }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Visus kanan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->visus_kanan }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Visus kiri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->visus_kiri }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Rekomendasi kacamata :</label>
                                <div class="col-md-7">
                                    <span class="basic-text" type="text">{{ ($mcu->riwayat->rekomendasi_kacamatan == 'Y')?'ya':'tidak' }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Spheris kanan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->spheris_kanan }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Cylinder kanan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->cylinder_kanan }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Axis kanan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->axis_kanan }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Addition kanan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->addition_kanan }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Shperis kiri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->spheris_kiri }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Cylinder kiri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->cylinder_kiri }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Axis kiri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->axis_kiri }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Addition kiri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->addition_kiri }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Pupil distance :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->antrovisus->pupil_distance }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($mcu->fisik)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Fisik</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kepala :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->kepala:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Mata :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->mata:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Telinga :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->telinga:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Hidung :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->hidung:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Tenggorokan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->tenggorokan:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Leher :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->leher:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Mulut :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->mulut:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Gigi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->gigi:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Dada :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->dada:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Abdomen :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->abdomen:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Extremitas :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->extremitas:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Anogenital :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->fisik?$mcu->fisik->anogenital:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->hematologi)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Hematologi</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Hemoglobin :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->hemoglobin:'' }}</span>L: 13-18 | P: 11,5-16,5</div>
                                    <div class="col-md-2">gram/dL</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Hematokrit :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->hematokrit:'' }}</span>L: 40 - 50 | P: 37 - 43</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <label for="" class="control-label col-md-5">Eritrosit :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->eritrosit:'' }}</span>L: 4.5-5.5 | P: 4-5</div>
                                    <div class="col-md-2">*10<sup>6</sup>/mm<sup>3</sup></div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Leukosit :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->leukosit:'' }}</span>4.000 - 11.000</div>
                                    <div class="col-md-2">/mm<sup>3</sup></div>	
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Trombosit :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->trombosit:'' }}</span>150 - 400</div>
                                    <div class="col-md-2">mm/jam</div>	
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Laju endap darah :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_laju_endap_darah">&nbsp{{ $mcu->hematologi?$mcu->hematologi->laju_endap_darah:'' }}</span>L: 0-10 | P: 0-15</div>
                                    <div class="col-md-2">mm/jam</div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Basofil :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->basofil:'' }}</span>0 - 1</div>
                                    <div class="col-md-2">%</div>	
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Eosinofil :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->eosinofil:'' }}</span>1 - 3</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Neutrofil batang :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->neutrofil_batang:'' }}</span>2 - 5</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Neutrofil segment :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->neutrofil_segment:'' }}</span>50 - 70</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Limfosit :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->limfosit:'' }}</span>20 - 40</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Monosit :</label>
                                <div class="col-md-7">	
                                    <div class="col-md-10"><span class="basic-text basic-text-bb">&nbsp{{ $mcu->hematologi?$mcu->hematologi->monosit:'' }}</span>2 -  6</div>
                                    <div class="col-md-2">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">MCP :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_mcv">&nbsp{{ $mcu->hematologi?$mcu->hematologi->mcv:'' }}</span>82 - 92</div>
                                    <div class="col-md-2">Femtoliter</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">MCH :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_mch">&nbsp{{ $mcu->hematologi?$mcu->hematologi->mch:'' }}</span>27 - 31</div>
                                    <div class="col-md-2">Picogram/sel</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">MCHC :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_mchc">&nbsp{{ $mcu->hematologi?$mcu->hematologi->mchc:'' }}</span>32 -  37</div>
                                    <div class="col-md-2">gram/dL</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Golongan darah (ABO) :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_golongan_darah_abo">&nbsp{{ $mcu->hematologi?$mcu->hematologi->golongan_darah_abo:'&nbsp' }}</span></div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Golongan darah (Rh) :</label>
                                <div class="col-md-7">
                                    <div class="col-md-10"><span class="basic-text basic-text-bb" name="hematologi_golongan_darah_rh">&nbsp{{ $mcu->hematologi?$mcu->hematologi->golongan_darah_rh:'&nbsp' }}</span></div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->kimia)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Kimia</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">GDS :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->gds:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">GDP :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->gdp:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">2 jam PP :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->dua_jam_pp:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">HbA1c :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->hba1c:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Ureum :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->ureum:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kreatinin :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->kreatinin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Asam urat :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->asam_urat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bilirubin total :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->bilirubin_total:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bilirubin direk :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->bilirubin_direk:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bilirubin indirek :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->bilirubin_indirek:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">SGOT :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->sgot:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">SGPT :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->sgpt:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Protein :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->protein:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Albumin :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->albumin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Alkaline fosfatase :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->alkaline_fosfatase:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Choline esterase :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->choline_esterase:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Gamma GT :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->gamma_gt:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Trigliserida :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->trigliserida:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kolesterol total :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->kolesterol_total:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">HDL :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->hdl:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">LDL direk :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->ldl_direk:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">LDL indirek :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->ldl_indirek:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">CK :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->ck:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">CKMB :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->ckmb:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Spuktum BTA 1 :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia->spuktum_bta1 }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Spuktum BTA 2 :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->spuktum_bta2:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Spuktum BTA 3 :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->kimia?$mcu->kimia->spuktum_bta3:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->audiometri)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Audiometri</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-2">Kesimpulan :</label>
                                <div class="col-md-10"><span class="basic-text">{{ $mcu->audiometri?$mcu->audiometri->kesimpulan_audiometri 	:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-2">Hasil Audiometri :</label>
                                <div class="col-md-10"><span class="basic-text">{{ $mcu->audiometri?$mcu->audiometri->hasil_audiometri  	:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <div style="height:13px;width: 100%;background: #fff;position: absolute;"></div>
                                <img src="{{ $audiometriChart }}" width="90%" />
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($mcu->audiometriDetail->count() > 0)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i>Hasil Pemeriksaan Audiometri</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-12">

                            <div id="rontgen-audiometri" style="margin-right: 25px">
                                <hr/>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr class="bg-none">
                                            <th>Frekuensi</th>
                                            <th>Kiri</th>
                                            <th>Kanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mcu->audiometriDetail as $a)
                                        <tr>
                                            <td>{{ $a->frekuensi }}</td>
                                            <td>{{ $a->kiri }}</td>
                                            <td>{{ $a->kanan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->rontgenDetail->count() > 0)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Rontgen</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kesan Rontgen :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rontgen?$mcu->rontgen->kesan_rontgen:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div id="rontgen-detail" style="margin-right: 25px">
                                <hr/>
                                <table class="table table-borderless" style="font-size:13px;">
                                    <thead>
                                        <tr class="bg-none">
                                            <th>Jenis Foto</th>
                                            <th>Parameter</th>
                                            <th>Temuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mcu->rontgenDetail as $r)
                                        <tr>
                                            <td>{{ $r->jenis_foto }}</td>
                                            <td>{{ $r->parameter }}</td>
                                            <td>{{ $r->temuan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <img style="width:100%;height:100%;object-fit: cover;" src="{{($mcu->rontgen->foto)? 'https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/rontgen/'.$mcu->rontgen->foto:''}}" />
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->serologi)
                @if($mcu->serologi->hbsag 
                    or $mcu->serologi->anti_hbs 
                    or $mcu->serologi->igm_salmonella  
                    or $mcu->serologi->igg_salmonella   
                    or $mcu->serologi->salmonela_typhi_o   
                    or $mcu->serologi->salmonela_typhi_h    
                    or $mcu->serologi->salmonela_parathypi_a_o    
                    or $mcu->serologi->salmonela_parathypi_a_h    
                    or $mcu->serologi->salmonela_parathypi_b_o    
                    or $mcu->serologi->salmonela_parathypi_b_h    
                    or $mcu->serologi->salmonela_parathypi_c_o    
                    or $mcu->serologi->salmonela_parathypi_c_h    
                    or $mcu->serologi->hcg     
                    or $mcu->serologi->psa      
                    or $mcu->serologi->afp      
                    or $mcu->serologi->cea      
                    or $mcu->serologi->igm_toxo       
                    or $mcu->serologi->igg_toxo       
                    or $mcu->serologi->ckmb_serologi       
                    or $mcu->serologi->myoglobin        
                    or $mcu->serologi->troponin_i   
                    )
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Serologi</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">HBSAg :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->hbsag }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Anti HBs :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->anti_hbs }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Tuberculosis :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->tuberculosis }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">IgM salmonella :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->igm_salmonella }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">IgG salmonella :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->igg_salmonella }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela typhi O :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_typhi_o }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela typhi H :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_typhi_h }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela parathyphi A-O :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_a_o }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela parathyphi A-H :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_a_h }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela paratyhphi B-O :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_b_o }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela paratyphi B-H :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_b_h }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela paratyphi C-O :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_c_o }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Salmonela paratyphi C-H :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->salmonela_parathypi_c_h }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">HCG :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->serologi->hcg }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">PSA :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_psa">{{ $mcu->serologi->psa }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">AFP :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_afp">{{ $mcu->serologi->afp }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">CEA :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_cea">{{ $mcu->serologi->cea }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">IgM toxo :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_igm_toxo">{{ $mcu->serologi->igm_toxo }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">IgG toxo :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_igg_toxo">{{ $mcu->serologi->igg_toxo }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">CKMB :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_ckmb">{{ $mcu->serologi->ckmb }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Myoglobin :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_myoglobin">{{ $mcu->serologi->myoglobin }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Toponin I :</label>
                                <div class="col-md-6"><span class="basic-text" name="serologi_troponin_i">{{ $mcu->serologi->troponin_i }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endif
            @endif

            @if($mcu->spirometri)
                @if($mcu->spirometri->fev or 
                    $mcu->spirometri->fvc or
                    $mcu->spirometri->pef or
                    $mcu->spirometri->kesimpulan_spirometri 
                    )
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Spirometri</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">FEV :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->spirometri?$mcu->spirometri->fev:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">FVC :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->spirometri?$mcu->spirometri->fvc:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">PEF :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->spirometri?$mcu->spirometri->pef:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kesimpulan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->spirometri?$mcu->spirometri->kesimpulan_spirometri:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endif
            @endif

            @if($mcu->ekg)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> EKG</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-2">Hasil EKG :</label>
                                <div class="col-md-10"><span  class="basic-text">{{ $mcu->ekg?$mcu->ekg->hasil_ekg:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-2">Kesimpulan EKG :</label>
                                <div class="col-md-10"><span  class="basic-text">{{ $mcu->ekg?$mcu->ekg->kesimpulan_ekg:'' }}</span></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <img style="width:90%;" src="{{($mcu->ekg->foto)? 'https://gmeds-emcu.s3.ap-southeast-3.amazonaws.com/ekg/'.$mcu->ekg->foto:''}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->treadmill)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Treadmill</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Resting EKG :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->resting_ekg:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Bruce heart beat :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->bruce_heart_beat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Capaian heart beat :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->capaian_heart_beat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Capaian menit :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->capaian_menit:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Respon heart beat :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->respon_heart_beat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Respon Sistol :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->respon_sistol:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Respon diastol :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->respon_diastol:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Aritmia :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->aritmia:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Nyeri dada :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->nyeri_dada:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Gejala lain :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->gejala_lain:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Perubahan segmen ST :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->perubahan_segmen_st:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Lead :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->lead:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Lead pada menit ke :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->lead_pada_menit_ke:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Normalisasi setelah :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->normalisasi_setelah:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Functional class :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->functional_class:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Kapasitas aerobik :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->kapasitas_aerobik:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Tingkat kesegaran :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->tingkat_kesegaran:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Grafik :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->grafik:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-6">Kesmipulan :</label>
                                <div class="col-md-6"><span class="basic-text">{{ $mcu->treadmill?$mcu->treadmill->kesimpulan_treadmill:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        

            @if($mcu->feses)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Feses</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Warna :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->warna_feses:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Konsistensi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->konsistensi:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Darah :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->darah_feses:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Lendir :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->lendir:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Eritrosit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->eritrosit:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Leukosit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->leukosit:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Amoeba :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->amoeba:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">E-hystolitica :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->e_hystolitica:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">E-coli :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->e_coli:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kista :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->kista:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Ascaris :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->ascaris:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Oxyuris :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->oxyuris:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Serat :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->serat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Lemak :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->lemak:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Karbohidrat :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->karbohidrat:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Benzidine :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->benzidine:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Lain-lain :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->feses?$mcu->feses->lain_lain:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->urin)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Urin</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Warna :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->warna_urin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kejernihan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->kejernihan:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Berat jenis :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->berat_jenis:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">pH :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->ph:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Protein urin :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->protein_urin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Reduksi :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->reduksi:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Keton :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->keton:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bilirubin :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->bilirubin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Urobilinogen :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->urobilinogen:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Leukosit esterase :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->leukosit_esterase:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Darah :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->darah_urin:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Nitrit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->nitrit:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Sedimen eritrosit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->sedimen_eritrosit:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Sedimen leukosit :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->sedimen_leukosit:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Epitel :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->epitel:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Silinder :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->silinder:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kristal :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->kristal:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Bakteri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->bakteri:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Jamur :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->jamur:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">HCG :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->urin?$mcu->urin->hcg:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        
            @if($mcu->papSmear)
                @if(trim($mcu->papSmear->tgl_terima)
                    or trim($mcu->papSmear->tgl_selesai)
                    or trim($mcu->papSmear->bahan_pemeriksaan)
                    or trim($mcu->papSmear->makroskopik)
                    or trim($mcu->papSmear->mikroskopik)
                    or trim($mcu->papSmear->kesimpulan_pap_smear)
                    )
                    <div class="panel panel-report">
                        <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Pap Smear</strong></div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Tgl. terima :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->tgl_terima:'' }}</span></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Tgl. selesai :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->tgl_selesai:'' }}</span></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Bahan pemeriksaan :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->bahan_pemeriksaan:'' }}</span></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Makroskopik :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->makroskopik:'' }}</span></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Mikroskopik :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->mikroskopik:'' }}</span></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-5">Kesimpulan :</label>
                                        <div class="col-md-7"><span class="basic-text">{{ $mcu->papSmear?$mcu->papSmear->kesimpulan_pap_smear:'' }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if($mcu->rectalSwab)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Rectal Swab</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Typoid :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->typoid:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Diare :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->diare:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Disentri :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->disentri:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kolera :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->kolera:'' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Salmonella :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->salmonella:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Shigella :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->shigella:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">E-coli :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->e_coli:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Vibrio cholera :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->vibrio_cholera:'' }}</span></div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kesimpulan :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->rectalSwab?$mcu->rectalSwab->kesimpulan_rectal_swab:'' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($mcu->drugScreeningDetail->count() > 0)
            <div class="panel panel-report">
                <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Drug Screening</strong></div>
                <div class="panel-body">
                    <div class="form-horizontal row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="control-label col-md-5">Kesimpulan Drug Screening :</label>
                                <div class="col-md-7"><span class="basic-text">{{ $mcu->drugScreening?$mcu->drugScreening->kesimpulan_drug_screening : '' }}</span></div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div id="rontgen-audiometri" style="margin-right: 25px">
                                <hr/>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr class="bg-none">
                                            <th>Tgl. Pemeriksaan</th>
                                            <th>Status Pemeriksaan</th>
                                            <th>Paramter</th>
                                            <th>Hasil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mcu->drugScreeningDetail as $ds)
                                        <tr>
                                            <td>{{ $ds->tgl_pemeriksaan }}</td>
                                            <td>{{ $ds->status_pemeriksaan }}</td>
                                            <td>{{ $ds->parameter_drug_screening }}</td>
                                            <td>{{ $ds->hasil_drug_screening }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="panel panel-report">
                <div class="panel-heading bg-corporate"><strong><i class="fa fa-th-large"></i> Summary</strong></div>
                <div class="panel-body">
                    <div class="sform-horizontal">
                        <div class="col-md-12">

                            <div id="" style="margin-right: 25px">
                                <table class="table table-borderless tbl" >
                                    <thead>
                                        <tr class="bg-none">
                                            <th>Diagnosis</th>
                                            <th>Saran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($mcu->diagnosis->where('deleted',0)->count() > 0)
                                            @foreach($mcu->diagnosis->where('deleted',0) as $d)
                                            <tr>
                                                <td>{{ isset($d->recommendation->icd10->name) ? $d->recommendation->icd10->name : '-' }}</td>
                                                <td><p class="td-b">{{ $d->recommendation['recommendation']}}</p></td>
                                            </tr>
                                            @endforeach
                                            
                                        @else
                                            <tr>
                                                <td>Normal Condition</td>
                                                <td class="td-b">Pertahankan pola hidup sehat, jaga pola makan dengan diet seimbang, olah raga teratur dan istirahat yang cukup karena saat ini anda dalam kondisi sehat</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <hr/>
                            </div>

                        </div>
                        <div class="col-md-6">
                        <div class="form-group row">

                                @php
                                    $workHealthDiagnosis  = 'FIT ON JOB';
                                    if($mcu->diagnosis->count() > 0) {
                                        $i = 0;
                                        $arrDiagnosis = collect();
                                        foreach($mcu->diagnosis->where('deleted',0) as $d) {
                                            
                                            
                                            $arrDiagnosis->push([
                                            'sequence' => $d->recommendation['workHealth']['sequence'],
                                            'diagnosis' => $d->recommendation['workHealth']['name']
                                            ]);
                                            $i++;
                                        }

                                        $getDiagnosis = collect($arrDiagnosis)->sortBy('sequence')->first();
                                        $workHealthDiagnosis = $getDiagnosis['diagnosis'];
                                        

                                    }
                                @endphp

                                <label for="" class="control-label col-md-5">Diagnosis Kesehatan Kerja :</label>
                                <div class="col-md-7"><span class="basic-text">{{ ($workHealthDiagnosis) ? $workHealthDiagnosis : 'Normal Condition' }}</span></div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

            <div class="panel panel-report">
                <div class="panel-body">
                    <a target="_blank" href="" class="btn btn-outline-primary mb-3"><i class="fa fa-print"></i> @lang('general.print')</a> &nbsp;
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
$(document).ready(function () {
    //$('#ulscroller li').last()
    //var idm = "{{ $mcu->id }}";
    //var url = '<a href="/">'+idm+'</a>';
    //$('ul.breadcrumbs').append('<li><span>'+url+'</span></li>');
})
</script>
@endsection
