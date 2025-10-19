<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reportsendwa extends Model
{
    protected $table = 'reportsendwa';

    public $timestamps = true;

    protected $fillable = [
        'delivery','status','note','mcu_id','id','sender','created_at','updated_at'
    ];
    
    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
