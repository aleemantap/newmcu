<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
     public $timestamps = false;
	 protected $table = 'formulas';


	//public function parameter()
    //{
    //    return $this->belongsTo('App\parameter');
    //}

	public function rumus()
    {
        return $this->belongsTo('App\Models\Rumus');
    }
}
