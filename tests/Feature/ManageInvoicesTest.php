<?php

namespace Tests\Feature;

use App\Invoice;
use App\Address;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageInvoicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_invoice()
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

        $this->post($customer->path() . '/invoices', $attributes = [
            'job_address_id' => $jobAddress->id,
            'sales_person' => 'Henry Lemmon',
            'billing_date' => '05/01/2019',
            'description' => 'Fake description',
            'cost_description' => 'Fake cost description',
            'completed' => true,
            'paid' => true,
            'total' => '2500.00'
        ])->assertRedirect($customer->path() . '/invoices');

        $this->assertDatabaseHas('invoices', $attributes);
        $this->assertDatabaseHas('invoices', ['billing_address_id' => $customer->billingAddress()->id]);
        $this->assertDatabaseHas('invoices', ['customer_id' => $customer->id]);
    }

    /** @test */
    public function a_user_can_view_a_list_of_invoices()
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

        $invoices = factory(Invoice::class, 3)->create([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
        ]);

        $this->get($customer->path() . '/invoices')
            ->assertSee(
                $invoices[0]->customer->fullName() . '_' . str_replace('-', '_', $invoices[0]->created_at->toDateString())
            )->assertSee(
                $invoices[1]->customer->fullName() . '_' . str_replace('-', '_', $invoices[1]->created_at->toDateString())
            )->assertSee(
                $invoices[2]->customer->fullName() . '_' . str_replace('-', '_', $invoices[2]->created_at->toDateString())
            );
    }

    /** @test */
    public function a_user_can_view_a_single_invoice()
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

        $this->get($invoice->path())
            ->assertSee($invoice->sales_person)
            ->assertSee($invoice->description)
            ->assertSee($invoice->cost_descriiption);
    }

    // Validation

    /** @test */
    public function it_must_have_a_sales_person()
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

        $invoiceAttributes = factory(Invoice::class)->raw([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => $jobAddress->id,
            'sales_person' => ''
        ]);

        $this->post($customer->path().'/invoices', $invoiceAttributes)
            ->assertSessionHasErrors('sales_person');
    }

    /** @test */
    public function it_must_have_a_job_address()
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

        $invoiceAttributes = factory(Invoice::class)->raw([
            'customer_id' => $customer->id,
            'billing_address_id' => $billingAddress->id,
            'job_address_id' => null
        ]);

        $this->post($customer->path().'/invoices', $invoiceAttributes)
            ->assertSessionHasErrors('job_address_id');
    }

    /** @test */
    public function it_must_have_a_billing_address()
    {
        $customer = factory(Customer::class)->create();

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $invoiceAttributes = factory(Invoice::class)->raw([
            'customer_id' => $customer->id,
            'billing_address_id' => null,
            'job_address_id' => $jobAddress->id
        ]);

        $this->post($customer->path().'/invoices', $invoiceAttributes)
            ->assertSessionHasErrors('billing_address_id');
    }
}
