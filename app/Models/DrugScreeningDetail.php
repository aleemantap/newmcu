<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugScreeningDetail extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'tgl_pemeriksaan',
        'status_pemeriksaan',
        'parameter_drug_screening',
        'hasil_drug_screening',
        'mcu_id',
		'process_id'
    ];

    public function mcu()
    {
        return $this->hasOne('App\Models\Mcu');
    }
}
