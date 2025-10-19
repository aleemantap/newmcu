<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rontgen extends Model
{
    protected $table = 'rontgen';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kesan_rontgen', 'mcu_id','process_id','ttd_id'
    ];
    
    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }

    public function ttd()
    {
        return $this->belongsTo('App\Models\Ttd');
    }
}
