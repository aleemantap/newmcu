<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    
    public function menuActions()
    {
        return $this->belongsToMany('App\Models\MenuAction', 'user_group_menu_actions');
    }
}
