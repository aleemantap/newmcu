<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hematologi extends Model
{
    protected $table = 'hematologi';

    public $timestamps = false;

    protected $fillable = [
        'hemoglobin','hematokrit', 'eritrosit','leukosit','trombosit','basofil', 'eosinofil','neutrofil_batang','neutrofil_segment','limfosit','monosit','laju_endap_darah','mcv','mch','mchc','golongan_darah_abo','golongan_darah_rh','mcu_id','process_id'
    ];
}
