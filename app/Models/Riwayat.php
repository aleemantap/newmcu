<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $table = 'riwayat';

    public $timestamps = false;

    protected $fillable = [
        'keluhan_utama','riwayat_alergi', 'riwayat_penyakit_sekarang','riwayat_kesehatan_dahulu','riwayat_kesehatan_keluarga','riwayat_kesehatan_pribadi', 'olahraga','frekuensi_per_minggu','merokok','rokok_bungkus_per_hari','kopi','kopi_gelas_per_hari','alkohol','alkohol_sebanyak','lama_tidur_per_hari','pernah_kecelakaan_kerja','tahun_kecelakaan_kerja','tempat_kerja_berbahaya','pernah_rawat_inap','hari_lama_rawat_inap','rawat_inap_penyakit','mcu_id','process_id'
    ];
}
