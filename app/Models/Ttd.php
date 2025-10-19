<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ttd extends Model
{
    protected $table = 'ttd';
    public $timestamps = true;
    
    protected $fillable = [
        'id','nama_dokter', 'gambar_ttd','jenis', 'note','created_by','updated_by','created_at','updated_at'
    ];

    public function rontgen()
    {
        return $this->hasMany('App\Models\Rontgen');
    }

    public function ekg()
    {
        return $this->hasMany('App\Models\Ekg');
    }

    public function audiomteri()
    {
        return $this->hasMany('App\Models\Audiometri');
    }

    public function spirometri()
    {
        return $this->hasMany('App\Models\Spirometri');
    }




  

}
