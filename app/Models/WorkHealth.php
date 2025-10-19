<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of WorkHeath
 *
 * @author In House Dev Program
 */
class WorkHealth extends Model
{
    public $timestamps = false;
	protected $table = 'work_healths';
	
	public function recommendation()
    {
        return $this->hasMany('App\Models\Recommendation');
    }
}
