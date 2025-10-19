<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urin extends Model
{
	protected $table = 'urin';
	public $timestamps = false;
    protected $primaryKey = 'id';
 
    protected $fillable = [
        'warna_urin','kejernihan','berat_jenis', 'ph','sedimen_leukosit','protein_urin','reduksi','keton', 'bilirubin','urobilinogen','leukosit_esterase','darah_urin','nitrit','sedimen_eritrosit','epitel','silinder','kristal','bakteri','jamur','hcg_urin','mcu_id','process_id'
    ];

	public function mcuid()
    {
        return $this->hasOne('App\Models\Mcu', 'id', 'mcu_id');
    }
}
