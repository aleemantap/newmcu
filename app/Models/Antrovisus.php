<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrovisus extends Model
{
    protected $table = 'antrovisus';

    public $timestamps = false;

    protected $fillable = [
        'berat_badan','tinggi_badan', 'bmi','visus_kanan','visus_kiri','rekomendasi_kacamatan', 'spheris_kanan','cylinder_kanan','axis_kanan','addition_kanan','spheris_kiri','cylinder_kiri','axis_kiri','addition_kiri','pupil_distance','mcu_id','process_id'
    ];

}
