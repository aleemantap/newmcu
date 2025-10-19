<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';

    public function diagnosis()
    {
        return $this->hasMany('App\Models\Diagnosis')->where('deleted','0');
    }
    public function icd10()
    {
         return $this->belongsTo('App\Models\Icd10', 'icd10_id');
    }

    public function workHealth()
    {
        return $this->belongsTo('App\Models\WorkHealth', 'work_health_id');
    }

	public function formulaDetail()
    {
        return $this->belongsTo('App\Models\FormulaDetail');
    }
}
