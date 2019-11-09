<?php

namespace Tests\Unit;

use App\Address;
use App\Invoice;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
        ]);

        $this->assertInstanceOf(Customer::class, $invoice->customer);
    }

    /** @test */
    public function it_has_a_path()
    {
        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
        ]);

        $this->assertEquals($customer->path() . '/invoices/' . $invoice->id, $invoice->path());
    }
}
