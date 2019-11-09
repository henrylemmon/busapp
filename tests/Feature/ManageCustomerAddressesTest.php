<?php

namespace Tests\Feature;

use App\Address;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCustomerAddressesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_addresses()
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

        $this->get($customer->path() . '/addresses')
            ->assertRedirect('login');

        $this->get($customer->path() . '/addresses/create')
            ->assertRedirect('login');

        /*no show*/

        $this->get($jobAddress->path() . '/edit')
            ->assertRedirect('login');

        $this->patch($jobAddress->path(), [])
            ->assertRedirect('login');

        $this->post($customer->path() . '/addresses', [])
            ->assertRedirect('login');

        $this->delete($billingAddress->path())
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_add_an_addresses_to_a_customer()
    {
        $customer = factory(Customer::class)->create();
        $addressAttributes = factory(Address::class)->raw();

        $this->signIn();

        $this->followingRedirects()
            ->post($customer->path() . '/addresses', $addressAttributes)
            ->assertSee(e($addressAttributes['address']))
            ->assertSee(e($addressAttributes['city']))
            ->assertSee(e($addressAttributes['state']));

        $this->assertDatabaseHas('addresses', $addressAttributes);
        $this->assertDatabaseHas('addresses', ['billing_address' => false]);
    }

    /** @test */
    public function a_user_can_see_those_job_addresses()
    {
        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);
        $this->assertDatabaseHas('addresses', ['billing_address' => true]);

        $this->assertDatabaseMissing('addresses', ['billing_address' => false]);

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);
        $this->assertDatabaseHas('addresses', ['billing_address' => false]);

        $this->signIn();

        $this->get($customer->path())
            ->assertSee(e($customer->fullName()))
            ->assertSee(e($customer->billingAddress()->address))
            ->assertSee(e($customer->addresses[0]->address))
            ->assertSee(e($customer->addresses[1]->address));
    }

    /** @test */
    public function a_user_can_edit_a_job_address()
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

        $newJobAddress = factory(Address::class)->raw();

        $this->signIn();

        $this->get($jobAddress->path(). '/edit')
            ->assertStatus(200);

        $this->patch($jobAddress->path(), $newJobAddress)
            ->assertRedirect($customer->path());

        $this->get($customer->path())
            ->assertSee(e($newJobAddress['address']))
            ->assertSee(e($newJobAddress['city']))
            ->assertSee(e($newJobAddress['state']));
    }

    /** @test */
    public function a_user_can_edit_an_billing_address()
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

        $newBillingAddress = factory(Address::class)->raw();

        $this->signIn();

        $this->get($billingAddress->path(). '/edit')
            ->assertStatus(200);

        $this->patch($billingAddress->path(), $newBillingAddress)
            ->assertRedirect($customer->path());

        $this->get($customer->path())
            ->assertSee(e($newBillingAddress['address']))
            ->assertSee(e($newBillingAddress['city']))
            ->assertSee(e($newBillingAddress['state']));
    }

    /** @test */
    public function a_user_can_change_customers_billing_address()
    {
        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);
        $this->assertEquals(1, $billingAddress->id);

        $jobAddress = factory(Address::class)
            ->states('notBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);
        $this->assertEquals(2, $jobAddress->id);

        $this->assertEquals(1, $customer->billingAddress()->id);

        $this->signIn();

        $this->patch($customer->path(), array_merge(
            factory(Customer::class)->raw(), ['new_billing_address_id' => $jobAddress->id]
        ));

        $this->assertEquals(2, $customer->billingAddress()->id);
    }

    /** @test */
    public function a_user_can_delete_one_or_all_addresses()
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

        $this->signIn();

        $this->delete($jobAddress->path());
        $this->assertDatabaseMissing('addresses', $jobAddress->only('id'));

        $this->delete($billingAddress->path());
        $this->assertDatabaseMissing('addresses', $billingAddress->only('id'));

        $this->assertEquals(0, $customer->addresses->count());
    }
}
