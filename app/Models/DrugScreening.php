<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugScreening extends Model
{
    protected $table = 'drug_screening';
    public $timestamps = false;
    
    protected $fillable = [
        'kesimpulan_drug_screening',
        'mcu_id','process_id'
    ];

    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
