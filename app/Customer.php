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

    /**
     * Add an address to the customer
     *
     * @param $addressAttributes
     * @return Model
     */
    public function addAddress($addressAttributes)
    {
        return $this->addresses()->create($addressAttributes);
    }

    /**
     * Get those addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class)->orderBy('billing_address', 'desc');
    }

    /**
     * Single out the billing address
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
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
