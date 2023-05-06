<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Rate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::factory()->create([
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'email' => 'customer@test.com',
            'phone' => fake()->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
            'type' => 'customer',
            'active' => true,
        ]);

        $customer->contact_information()->save(ContactInformation::factory()->create());

        $customer->deposit(10000);

        $partner = Partner::create([
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'region' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->streetAddress,
            'house' => 4,
            'flat' => 123,
            'entrance' => 5,
            'intercom' => 234,
        ]);

        $product = Product::take(1)->inRandomOrder()->first();

        $rate_id = Rate::take(1)->inRandomOrder()->first()->id;

        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'rate_id' => $rate_id,
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
            'price' => ProductPrice::query()
                ->where('product_id', $product->id)
                ->where('rate_id', $rate_id)
                ->first()
                ->amount,
            'status' => OrderStatus::ACCEPTED,
            'door_to_door' => true,
        ]);

        $order->sender()->associate($customer);

        $order->receiver()->associate($partner);

        $order->save();
    }
}
