<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Partner;
use App\Models\PersonalInformation;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(10)->create()->each(function ($customer){

            $customer->contact_information()->save(ContactInformation::factory()->create());

            $customer->personal_information()->save(PersonalInformation::factory()->create());

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
        });
    }
}
