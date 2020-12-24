<?php

namespace Tests\Unit;

use App\Address;
use App\Invoice;
use App\Customer;
use Carbon\Carbon;
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

    /** @test */
    public function it_has_a_title()
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
                'customer_id' => $customer->id,
                'address' => '1122 Boogie Boogie Avenue'
            ]);

        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
        ]);

        $createdAt = Carbon::create(strval($invoice->created_at));

        $caption = strip_tags(implode(' ', array_slice(explode(' ', $invoice->description), 0, 6)));
        $descriptionCaption = preg_replace('/\s/', '_', $caption);

        $this->assertEquals(
            $invoice->title($jobAddress->id),
            $createdAt->isoFormat('MMM_Do_YYYY')
            . '_' . '1122_Boogie_Boogie_Avenue'
            . '_' .$descriptionCaption
        );
    }

    /** @test */
    public function it_has_a_job_address()
    {
        $this->withoutExceptionHandling();

        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id,
                'address' => '1122 Boogie Boogie Avenue'
            ]);

        $invoice = factory(Invoice::class)->create([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
        ]);

        $this->assertEquals($invoice->jobAddress(), $jobAddress);
    }
}
