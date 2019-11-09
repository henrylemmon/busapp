<?php

namespace App\Http\Controllers;

use App\Address;
use App\Invoice;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function index(Customer $customer)
    {
        return view('invoices.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function create(Customer $customer)
    {
        return view('invoices.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Customer $customer
     * @param Address $address
     * @return void
     */
    public function store(Customer $customer)
    {
        $attributes = [
            'billing_address_id' => $customer->billingAddress()->id,
            'job_address_id' => request('job_address_id'),
            'sales_person' => request('sales_person'),
            'billing_date' => request('billing_date'),
            'description' => request('description'),
            'cost_description' => request('cost_description'),
            'completed' => request('completed') ? true : false,
            'paid' => request('paid') ? true : false,
            'total' => request('total')
        ];

        $customer->invoices()->create($attributes);

        return redirect($customer->path() . '/invoices');
    }
    /*
'billing_address_id'
'job_address_id'
'sales_person', 25
'date', 15
'description', 300
'cost_description', 100
'completed', bool
'paid', bool
'cost', 10
*/

    /**
     * Display the specified resource in PDF format.
     *
     * @param Customer $customer
     * @param Invoice $invoice
     * @return void
     */
    public function show(Customer $customer, Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

/*$pdf = \PDF::loadView('invoices/invoice-pdf', compact('customer', 'address'))
->setPaper('letter', 'portrait');

return $pdf->stream('invoice.pdf');*/

/*$pdf = \PDF::loadView('invoices/invoice-pdf', compact('customer'))
->setPaper('letter', 'portrait');

return $pdf->stream('invoice.pdf');*/

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
