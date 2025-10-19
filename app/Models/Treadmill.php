<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treadmill extends Model
{
    protected $table = 'treadmill';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'resting_ekg','bruce_heart_beat', 'capaian_heart_beat','capaian_menit','respon_heart_beat','respon_sistol', 'respon_diastol','aritmia','nyeri_dada','gejala_lain','perubahan_segmen_st','lead','lead_pada_menit_ke','normalisasi_setelah','functional_class','kapasitas_aerobik','tingkat_kesegaran','grafik','kesimpulan_treadmill','mcu_id','process_id'
    ];

	public function mcuid()
    {
        return $this->hasOne('App\Models\Mcu', 'id', 'mcu_id');
    }
}
