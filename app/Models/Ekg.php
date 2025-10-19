<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekg extends Model
{
    protected $table = 'ekg';

    public $timestamps = false;

    protected $fillable = [
        'hasil_ekg','kesimpulan_ekg','mcu_id','process_id','ttd_id'
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
