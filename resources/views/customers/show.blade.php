@extends('layouts.app')

@section('content')
    <div>
        <div class="text-gray-700 text-2xl">
            <a
                href="/customers"
                class="underline text-blue-500"
            >Customers</a> < {{ $customer->first_name . ' ' . $customer->last_name }}
        </div>
    </div>

    <div class="lg:flex lg:justify-between">
        <div class="lg:w-2/3 lg:mr-4">

            @isset($customer)

                <div class="text-2xl mt-4 mb-0 font-bold">Customer Address</div>
                <hr class="border-gray-500">
                <div class="mt-4">
                    {{ $customer->fullName() }}<br>
                    Tel. {{ $customer->telephone }}<br>
                    {{ $customer->email ? 'email: ' . $customer->email: '' }}
                </div>
                <div class="font-bold mt-4">Billing Address:</div>

                @isset($customer->billingAddress()->address)
                    <div>
                        {{ $customer->billingAddress()->address }}<br>
                        @isset($customer->billingAddress()->address2)
                            {{ $customer->billingAddress()->address2 }}<br>
                        @endisset
                        {{ $customer->billingAddress()->city }}
                        {{ $customer->billingAddress()->state }}<br>
                        {{ $customer->billingAddress()->zip }}<br>
                    </div>
                @endisset

                @empty($customer->billingAddress())
                    <div class="mt-4">
                        <strong>No Billing Address!</strong><br>
                        Create Address Then Set It As Billing Address
                    </div>
                @endempty

                @if ($customer->addresses->count() >= 1)
                    <div class="text-2xl mt-4 mb-0 font-bold">Job Addresses</div>
                    <hr class="border-gray-500">

                    @foreach($customer->addresses as $address)
                        <div class="mt-4">
                            {{ $address->address }}<br>
                            @isset($address->address2)
                                {{ $address->address2 }}<br>
                            @endisset
                            {{ $address->city . ' ' . $address->state }}<br>
                            {{ $address->zip }}<br>
                            <hr class="border-gray-500 mt-4">
                        </div>
                    @endforeach
                @else
                    <hr class="border-gray-500 mt-4">
                @endif

            @endisset
            @empty($customer)
                No Customers Yet!<br>
            @endempty
        </div>

        <div class="mt-4 mb-6 lg:mb-0 lg:mt-0 lg:w-1/3 lg:text-center">
            <div>
                <div class="text-2xl mt-4 mb-0 font-bold text-center">Manage Customers</div>
                <hr class="border-gray-500">

                <a
                    href="{{ $customer->path() . '/edit' }}"
                    class="button block text-center mt-4"
                >Edit Customer or Change Billing Address</a>

                <form
                    action="{{ $customer->path() }}"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button w-full text-center mt-4">
                        Delete Customer
                    </button>
                </form>
            </div>

            <div>
                <div class="text-2xl mt-8 mb-0 font-bold text-center">Manage Addresses</div>
                <hr class="border-gray-500">
                <a
                    href="{{ $customer->path() . '/addresses/create' }}"
                    class="button block text-center mt-4"
                >Create Address</a>

                <a
                    href="{{ $customer->path() . '/addresses' }}"
                    class="button block text-center mt-4"
                >Edit or Delete Addresses</a>

            </div>

            <div>
                <div class="text-2xl mt-8 mb-0 font-bold text-center">Manage Invoices</div>
                <hr class="border-gray-500">
                <a
                    href="{{ $customer->path() . '/invoices' }}"
                    class="button block text-center mt-4"
                >View Customer Invoices</a>

                <a
                    href="{{ $customer->path() . '/invoices/create' }}"
                    class="button block text-center mt-4"
                >Create Customer Invoice</a>
            </div>
        </div>
    </div>
@endsection
