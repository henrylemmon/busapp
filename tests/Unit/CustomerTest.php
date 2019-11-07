<?php

namespace Tests\Unit;

use App\Address;
use App\Customer;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $customer = factory(Customer::class)->create();

        $this->assertEquals('/customers/' . $customer->id, $customer->path());
    }

    /** @test */
    public function it_has_a_full_name()
    {
        $customer = factory(Customer::class)->create([
            'first_name' => 'Hash',
            'last_name' => 'Tag'
        ]);

        $this->assertEquals('Hash Tag', $customer->fullName());
    }

    /** @test */
    public function it_can_add_a_job_address()
    {
        $customer = factory(Customer::class)->create();

        $addressAttributes = factory(Address::class)->raw();

        $customer->addAddress($addressAttributes);

        $this->assertCount(1, $customer->addresses);
    }

    /** @test */
    public function it_has_addresses()
    {
        $customer = factory(Customer::class)->create();

        $this->assertInstanceOf(Collection::class, $customer->addresses);
    }

    /** @test */
    public function it_has_a_billing_address()
    {
        $customer = factory(Customer::class)->create();

        factory(Address::class)
            ->state('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);

        $this->assertInstanceOf(Address::class, $customer->billingAddress());
    }
}
