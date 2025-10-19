<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feses extends Model
{
    protected $table = 'feses';

    public $timestamps = false;

    protected $fillable = [
        'warna_feses','konsistensi', 'darah_feses','lendir','eritrosit_feses','leukosit_feses', 'amoeba','e_hystolitica','e_coli_feses','kista','ascaris','oxyuris','serat','lemak','karbohidrat','benzidine','lain_lain','mcu_id','process_id'
    ];
    
    public function mcu()
    {
        return $this->belongsTo('App\Models\Mcu');
    }
}
