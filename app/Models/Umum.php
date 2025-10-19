<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umum extends Model
{
    protected $table = 'umum';
    public $timestamps = false;
    
    protected $fillable = [
        'nadi','sistolik', 'diastolik','respirasi', 'suhu', 'mcu_id','process_id'
    ];
}
