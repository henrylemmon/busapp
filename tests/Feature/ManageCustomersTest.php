<?php

namespace Tests\Feature;

use App\Address;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_customers()
    {
        $customer = factory(Customer::class)->create();

        $this->get('/customers')
            ->assertRedirect('login');

        $this->get('/customers/create')
            ->assertRedirect('login');

        $this->get($customer->path())
            ->assertRedirect('login');

        $this->get($customer->path() . '/edit')
            ->assertRedirect('login');

        $this->patch($customer->path(), [])
            ->assertRedirect('login');

        $this->post('/customers', [])
            ->assertRedirect('login');

        $this->delete($customer->path())
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_customer_with_a_billing_address()
    {
        $newCustomer = factory(Customer::class)->raw();
        $newCustomerAddress = factory(Address::class)->raw();
        $attributes = array_merge($newCustomer, $newCustomerAddress);

        $this->signIn();

        $this->get('/customers/create')
            ->assertStatus(200);

        $response = $this->post('/customers', $attributes);

        $response->assertRedirect(Customer::where($newCustomer)->first()->path());

        $this->get(Customer::where($newCustomer)->first()->path())
            ->assertSee(e($attributes['first_name']))
            ->assertSee(e($attributes['last_name']))
            ->assertSee(e($attributes['telephone']))
            ->assertSee(e($attributes['address']))
            ->assertSee(e($attributes['city']))
            ->assertSee(e($attributes['state']));

        $this->assertDatabaseHas('customers', $newCustomer);
        $this->assertDatabaseHas('addresses', $newCustomerAddress);
        $this->assertDatabaseHas('addresses', ['billing_address' => true]);
    }

    /** @test */
    public function a_user_can_view_a_list_of_customers()
    {
        $customer = factory(Customer::class)->create([
            'first_name' => 'Henry',
            'last_name' => 'Lemmon'
        ]);
        $customer2 = factory(Customer::class)->create([
            'first_name' => 'John',
            'last_name' => 'Simmons'
        ]);

        $this->signIn();

        $this->get('/customers')
            ->assertSee($customer->fullName())
            ->assertSee($customer2->fullName());
    }

    /** @test */
    public function a_user_can_view_a_single_customers_details()
    {
        $customer = factory(Customer::class)->create();

        $billingAddress = factory(Address::class)
            ->states('isBillingAddress')
            ->create([
                'customer_id' => $customer->id
            ]);
        $this->assertDatabaseHas('addresses', ['billing_address' => true]);

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
            ->assertSee(e($customer->addresses[1]->address));

        $this->assertEquals($billingAddress->address, $customer->billingAddress()->address);
        $this->assertEquals($billingAddress->address, $customer->addresses[0]->address);
        $this->assertEquals($jobAddress->address, $customer->addresses[1]->address);
    }

    /** @test */
    public function a_user_can_edit_a_customer_and_select_another_billing_address()
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

        $this->get($customer->path().'/edit')
            ->assertStatus(200);

        $this->followingRedirects()
            ->patch($customer->path(), $attributes = [
                'first_name' => 'newFirst',
                'last_name' => 'newLast',
                'telephone' => '1234561234',
                'new_billing_address_id' => $jobAddress->id
            ])
            ->assertSee($attributes['first_name'])
            ->assertSee($attributes['last_name'])
            ->assertSee($attributes['telephone']);

        $this->assertEquals($customer->billingAddress()->address, $jobAddress->address);
    }

    /** @test */
    public function a_user_can_delete_a_customer()
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

        $this->delete($customer->path())
            ->assertRedirect('/customers');

        $this->assertDatabaseMissing('customers', ['first_name' => $customer->first_name]);
        $this->assertDatabaseMissing('addresses', ['address' => $billingAddress->address]);
        $this->assertDatabaseMissing('addresses', ['address' => $jobAddress->address]);
    }

    // create customer validation

    /** @test */
    public function a_customer_requires_a_first_name()
    {
        $customer = factory(Customer::class)->raw([
            'first_name' => ''
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function first_name_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->raw([
            'first_name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllX'
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function a_customer_requires_a_last_name()
    {
        $customer = factory(Customer::class)->raw([
            'last_name' => ''
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function last_name_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->raw([
            'last_name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllX'
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function a_customer_requires_a_telephone()
    {
        $customer = factory(Customer::class)->raw([
            'telephone' => ''
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('telephone');
    }

    /** @test */
    public function telephone_cannot_be_more_than_25_chars()
    {
        $customer = factory(Customer::class)->raw([
            'telephone' => 'llllllllllllllllllll00000X'
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('telephone');
    }

    /** @test */
    public function email_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->raw([
            'email' => 'Xllllllll@lllllllllllllllllllllllllllllllllllll.com'
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_must_be_formatted_as_an_email()
    {
        $customer = factory(Customer::class)->raw([
            'email' => 'henrylemmonicloud.com'
        ]);
        $billingAddress = factory(Address::class)->raw();
        $newCustomer = array_merge($customer, $billingAddress);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_customer_requires_address()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'address' => ''
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('address');
    }

    /** @test */
    public function address_cannot_be_more_than_35_chars()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'address' => 'lllllllllllllllllllllllllllllllllllX',
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('address');
    }

    /** @test */
    public function address2_cannot_be_more_than_20_chars()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'address2' => 'llllllllllllllllllllX'
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('address2');
    }

    /** @test */
    public function a_customer_requires_a_city()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'city' => ''
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function city_cannot_be_more_than_25_chars()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'city' => 'lllllllllllllllllllllllllX'
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function a_customer_requires_a_state()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'state' => ''
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('state');
    }

    /** @test */
    public function state_cannot_be_more_than_2_chars()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'state' => 'CAX'
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('state');
    }

    /** @test */
    public function zip_cannot_be_more_than_20_chars()
    {
        $customer = factory(Customer::class)->raw();
        $address = factory(Address::class)->raw([
            'zip' => 'llllllllllllllllllllX'
        ]);
        $newCustomer = array_merge($customer, $address);

        $this->signIn();

        $this->post('/customers', $newCustomer)
            ->assertSessionHasErrors('zip');
    }

    // edit customer validation

    /** @test */
    public function to_edit_a_customer_requires_a_first_name()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'first_name' => ''
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function to_edit_a_customer_first_name_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'first_name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllX'
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function to_edit_a_customer_a_customer_requires_a_last_name()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'last_name' => ''
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function to_edit_a_customer_last_name_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'last_name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllX'
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function to_edit_a_customer_a_customer_requires_a_telephone()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'telephone' => ''
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('telephone');
    }

    /** @test */
    public function to_edit_a_customer_telephone_cannot_be_more_than_25_chars()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'telephone' => 'llllllllllllllllllll00000X'
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('telephone');
    }

    /** @test */
    public function to_edit_a_customer_email_cannot_be_more_than_50_chars()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'email' => 'Xllllllll@lllllllllllllllllllllllllllllllllllll.com'
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function to_edit_a_customer_email_must_be_formatted_as_an_email()
    {
        $customer = factory(Customer::class)->create();
        $changedCustomer = factory(Customer::class)->raw([
            'email' => 'henrylemmonicloud.com'
        ]);

        $this->signIn();

        $this->patch($customer->path(), $changedCustomer)
            ->assertSessionHasErrors('email');
    }
}
