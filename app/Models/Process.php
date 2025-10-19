<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'processes';

    protected $fillable = [
        'upload', 'processed', 'success', 'failed', 'total', 'status'
    ];
}
