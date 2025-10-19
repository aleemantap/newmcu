<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne('App\Models\Menu', 'id', 'parent_id')->orderBy('sequence');
    }
    
    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'id')->orderBy('sequence');
    }

    public function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
                ->where('parent_id', NULL)
                ->orderBy('sequence')
                ->get();
    }
    
    public function actions() {
        return $this->hasMany('App\Models\MenuAction');
    }
}
