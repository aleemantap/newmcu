<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudiometriDetail extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id','frekuensi', 'kiri','kanan','mcu_id','process_id'
    ];    

    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
