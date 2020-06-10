<?php

namespace App\Http\Controllers;

use App\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $attributes = $this->validateRequest();

        $customer = Customer::create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'telephone' => $attributes['telephone'],
            'email' => $attributes['email']
        ]);

        $customer->addAddress(array_merge(
            [
                'address' => $attributes['address'],
                'address2' => $attributes['address2'],
                'city' => $attributes['city'],
                'state' => $attributes['state'],
                'zip' => $attributes['zip']
            ],
            ['billing_address' => true]
        ));

        return redirect($customer->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Customer $customer)
    {
        $attributes = $this->validateCustomer();

        $this->changeBillingAddress($customer, request('new_billing_address_id'));

        $customer->update($attributes);

        return redirect($customer->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect('/customers');
    }

    public function changeBillingAddress($customer, $id)
    {
        if ($customer->billingAddress()) {
        $customer->billingAddress()
            ->update(['billing_address' => false]);
    }

        $customer->addresses()
            ->where('id', $id)
            ->update(['billing_address' => true]);
    }

    public function validateCustomer()
    {
        return request()->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'telephone' => 'required|max:25',
            'email' => 'nullable|max:50|email',
        ]);
    }

    public function validateRequest()
    {
        return request()->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'telephone' => 'required|max:25',
            'email' => 'nullable|max:50|email',
            'address' => 'required|max:35',
            'address2' => 'nullable|max:20',
            'city' => 'required|max:25',
            'state' => 'required|max:2',
            'zip' => 'nullable|max:20'
        ]);
    }
}
