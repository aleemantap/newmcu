<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kimia extends Model
{
    protected $table = 'kimia';

    public $timestamps = false;

    protected $fillable = [
        'gds','gdp','gfr','dua_jam_pp','hba1c','ureum','kreatinin', 'asam_urat','bilirubin_total','bilirubin_direk','bilirubin_indirek','sgot','sgpt','protein','albumin','alkaline_fosfatase','choline_esterase','gamma_gt','trigliserida','kolesterol_total','hdl','ldl_direk','ldl_indirek','ck','ckmb','spuktum_bta1','spuktum_bta2','spuktum_bta3','mcu_id','process_id'
    ];
}
