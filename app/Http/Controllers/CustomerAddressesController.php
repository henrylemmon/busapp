<?php

namespace App\Http\Controllers;

use Exception;
use App\Address;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerAddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $addresses = $customer->addresses;

        return view('addresses.index', compact('addresses', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Customer $customer)
    {
        return view('addresses.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Customer $customer)
    {
        $customer->addAddress(array_merge(
            $this->validateAddress(), ['billing_address' => false]
        ));

        return redirect($customer->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Address $address
     * @return void
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @param Address $address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Customer $customer, Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Customer $customer
     * @param Address $address
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Customer $customer, Address $address)
    {
        $address->update($this->validateAddress());

        return redirect($customer->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @param Address $address
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function destroy(Customer $customer, Address $address)
    {
        $address->delete();

        return redirect($customer->path());
    }

    public function validateAddress()
    {
        return request()->validate([
            'address' => 'required|max:35',
            'address2' => 'nullable|max:20',
            'city' => 'required|max:25',
            'state' => 'required|max:2',
            'zip' => 'nullable|max:20'
        ]);
    }
}
