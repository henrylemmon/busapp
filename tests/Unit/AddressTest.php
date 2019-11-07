<?php

namespace Tests\Unit;

use App\Address;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $address = factory(Address::class)
            ->states('belongsToCustomer')
            ->create();

        $this->assertInstanceOf(Customer::class, $address->customer);
    }

    /** @test */
    public function it_has_a_path()
    {
        $customer = factory(Customer::class)->create();

        $address = factory(Address::class)
            ->create(['customer_id' => $customer->id]);

        $this->assertEquals(
            '/customers/' . $customer->id . '/addresses/' . $address->id, $address->path()
        );
    }
}
