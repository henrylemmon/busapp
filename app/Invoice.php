<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Invoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean',
        'paid' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function path()
    {
        return "{$this->customer->path()}/invoices/{$this->id}";
    }

    public function title()
    {
        return $this->customer->billingAddress();
    }
}
