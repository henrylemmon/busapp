@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center">
        <div class="text-gray-700 text-2xl">
            {{ $customer->fullName() }}'s Invoices
        </div>

        <a href="{{ $customer->path() }}" class="button">Back To {{ $customer->fullName() }}</a>
    </div>
    @forelse($customer->invoices as $invoice)
        <div class="mx-auto mt-4">
            <a
                href="{{ $invoice->path() }}"
                class="text-blue-400 block"
            >
                {{ $invoice->title($invoice->job_address_id) }}
            </a>
        </div>
    @empty
        No Invoices, Why are you here?<br>
    @endforelse
@endsection
