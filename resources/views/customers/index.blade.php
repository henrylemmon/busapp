@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center">
        <div class="text-gray-700 text-2xl">
            Customers
        </div>

        <a href="/customers/create" class="button">Create Customer</a>
    </div>
    @forelse($customers as $customer)
        <div class="mx-auto mt-4">
            <a
                href="{{ $customer->path() }}"
                class="underline text-blue-400 block"
            >
                {{ $customer->first_name . ' ' . $customer->last_name }}
            </a>
        </div>
    @empty
        No Customers Yet!<br>
    @endforelse
@endsection
