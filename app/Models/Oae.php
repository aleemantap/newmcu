<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oae extends Model
{
    protected $table = 'oae';
    public $timestamps = false;

    protected $fillable = [
        'mcu_id', 'hasil_oae_ka','hasil_oae_ki','kesimpulan_oae','process_id'
    ];

}
