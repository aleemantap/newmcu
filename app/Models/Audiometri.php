<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audiometri extends Model
{
    protected $table = 'audiometri';
    public $timestamps = false;

    protected $fillable = [
        'hasil_telinga_kiri','hasil_telinga_kanan', 'kesimpulan_audiometri','mcu_id','hasil_audiometri','process_id','foto','ttd_id'
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
