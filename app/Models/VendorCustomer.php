<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VendorCustomer extends Pivot
{
    protected $table = 'vendor_customer';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
