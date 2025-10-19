<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RectalSwab extends Model
{
    protected $table = 'rectal_swab';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'typoid','diare', 'disentri','kolera','salmonella','shigella', 'e_coli','vibrio_cholera','kesimpulan_rectal_swab','mcu_id','process_id'
    ];

	public function mcuid()
    {
        return $this->hasOne('App\Models\Mcu', 'id', 'mcu_id');
    }
}
