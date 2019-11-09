<?php

namespace App\Http\Controllers;

use App\Address;
use App\Invoice;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class XInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function index(Customer $customer)
    {
        $pdf = \PDF::loadView('invoices/invoice-pdf', compact('customer'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Customer $customer
     * @param Address $address
     * @return Response
     */
    public function create(Customer $customer, Address $address)
    {
        return view('invoices.create', compact('customer', 'address'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Customer $customer
     * @param Address $address
     * @return void
     */
    public function store(Customer $customer, Address $address)
    {
        $invoice = [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'description' => request('description'),
            'cost_description' => request('cost_description'),
            'cost' => request('cost')
        ];

        Invoice::create($invoice);
    }

    /**
     * Display the specified resource in PDF format.
     *
     * @param Customer $customer
     * @param Address $address
     * @param Invoice $invoice
     * @return Response
     */
    public function show(Customer $customer, Address $address, Invoice $invoice)
    {
        $pdf = \PDF::loadView('invoices/invoice-pdf', compact('customer', 'address'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Invoice $invoice
     * @return Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
