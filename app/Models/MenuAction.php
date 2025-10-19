<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAction extends Model
{
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action_type', 'is_visible', 'menu_id',
    ];
    
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
}
