<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumus extends Model
{
    protected $table = 'rumuses';


	//public function parameter()
    //{
    //    return $this->belongsTo('App\parameter');
    //}

	public function rumus()
    {
        return $this->belongsTo('App\Models\Rumus');
    }

	public function rumusDetail()
    {
        return $this->hasOne('App\Models\RumusDetail');
    }


}
