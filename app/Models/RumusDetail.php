<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumusDetail extends Model
{
    public $timestamps = false;
	protected $table = 'rumus_details';
	 
	public function rumus()
    {
         return $this->belongsTo('App\Models\Rumus');
    }
	
	
	public function parameter()
    { 
         return $this->belongsTo('App\Models\Parameter');
    }
    
    // public function icd10()
    // {
        // return $this->belongsTo('App\Icd10', 'icd10_id');
    // }
    
    // public function workHealth()
    // {
        // return $this->belongsTo('App\WorkHealth');
    // }
}
