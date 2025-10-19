<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spirometri extends Model
{
    protected $table = 'spirometri';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'fev','fvc', 'pef','kesimpulan_spirometri','chart','mcu_id','process_id','ttd_id'
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
