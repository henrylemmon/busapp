<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    protected $casts = ['billing_address' => 'boolean'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function path()
    {
        return $this->customer->path() . '/addresses/' . $this->id;
    }
}
