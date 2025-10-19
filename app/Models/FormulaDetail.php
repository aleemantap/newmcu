<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaDetail extends Model
{
     public $timestamps = false;
	 protected $table = 'formula_details';
	 
	 public function formula()
     {
         return $this->belongsTo('App\Models\Formula');
     }
	
	
	// public function parameter()
    // {
        // return $this->belongsTo('App\Parameter');
    // }
    
    // public function icd10()
    // {
        // return $this->belongsTo('App\Icd10', 'icd10_id');
    // }
    
    // public function workHealth()
    // {
        // return $this->belongsTo('App\WorkHealth');
    // }
	
}
