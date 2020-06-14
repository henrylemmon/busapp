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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        return view('invoices.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Customer $customer)
    {
        $attributes = $this->validateRequest();

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Customer $customer, Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

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

    public function validateRequest()
    {
        return request()->validate([
            'billing_address_id' => 'required',
            'job_address_id' => 'required',
            'sales_person' => 'required',
            'billing_date' => 'nullable',
            'description' => 'nullable',
            'cost_description' => 'nullable',
            'completed' => 'nullable',
            'paid' => 'nullable',
            'total' => 'nullable'
        ]);
    }
}
