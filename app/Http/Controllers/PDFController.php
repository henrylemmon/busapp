<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function create(Customer $customer, Invoice $invoice)
    {
        $pdf = \PDF::loadView('invoices/invoice-pdf', compact('invoice'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('invoice.pdf');
    }
}
