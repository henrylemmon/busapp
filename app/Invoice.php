<?php

namespace App;

use Carbon\Carbon;
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

    public function title($id)
    {
        $caption = strip_tags(implode(' ', array_slice(explode(' ', $this->description), 0, 6)));
        $descriptionCaption = preg_replace('/\s/', '_', $caption);
        $createdAt = Carbon::create(strval($this->created_at));
        return $createdAt->isoFormat('MMM_Do_YYYY')
            . '_' . str_replace(' ', '_', $this->customer->jobAddress($id)->address)
            . '_' . $descriptionCaption;
    }
}
