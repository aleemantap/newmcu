<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address1', 'address2', 'city', 'zip_code', 'phone', 'fax', 'email', 'active', 'images'
    ];

    public function customers()
    {
        return $this->hasMany('App\Customer', 'vendor_customer');
    }
}
