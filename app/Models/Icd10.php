<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model
{
    protected $table = 'icd10s';
	
	public $timestamps = true;

    public function recommendation()
    {
        return $this->hasMany('App\Models\Recommendation');
    }
}
