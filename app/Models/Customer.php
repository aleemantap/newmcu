<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address1', 'address2', 'city', 'zip_code', 'phone', 'fax', 'email', 'active'
    ];

    public function vendors()
    {
        return $this->hasMany('App\Models\Vendor', 'vendor_customer');
    }
}
