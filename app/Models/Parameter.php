<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
   
	protected $table = 'parameters';
	public $timestamps = false; 
	
	protected $fillable = [
        'id','name', 'field','index_of_colom_excel','kategori'
    ];

	
}
