<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RontgenDetail extends Model
{
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis_foto', 'parameter', 'temuan', 'mcu_id','process_id'
    ];
    
    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu','mcu_id');
    }
}
