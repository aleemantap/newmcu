<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fisik extends Model
{
    protected $table = 'fisik';

    public $timestamps = false;

    protected $fillable = [
        'kepala','mata', 'telinga','hidung','tenggorokan','leher', 'mulut','gigi','dada','abdomen','extremitas','anogenital','mcu_id','process_id'
    ];
    
    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
