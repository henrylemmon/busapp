<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/customers/{$this->id}";
    }

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function addAddress($addressAttributes)
    {
        return $this->addresses()->create($addressAttributes);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class)->orderBy('billing_address', 'desc');
    }

    public function billingAddress()
    {
        return $this->addresses()->where('billing_address', true)->first();
    }

    public function jobAddress($id)
    {
        return $this->addresses()->where('id', $id)->first();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
