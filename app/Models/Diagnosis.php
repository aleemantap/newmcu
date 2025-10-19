<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       // 'icd10_id', 'work_health_id', 'recommendation', 'mcu_id'
         'recommendation_id', 'mcu_id','deleted','note','process_id','id'
    ];

    // public function icd10()
    // {
        // return $this->belongsTo('App\Icd10');
    // }

    // public function workHealth()
    // {
        // return $this->belongsTo('App\WorkHealth');
    // }

	public function recommendation()
    {
        return $this->belongsTo('App\Models\Recommendation');
    }

    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
