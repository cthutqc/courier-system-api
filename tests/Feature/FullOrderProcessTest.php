<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Partner;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FullOrderProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testOrder()
    {
        $customer = Customer::factory()->create();

        $this->actingAs($customer)->postJson('api/v1/customer/settings', [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'region' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->streetAddress,
            'house' => 4,
            'flat' => 123,
        ]);

        $category = Category::find(1);

        $product = Product::with('product_prices')->where('category_id', $category->id)->inRandomOrder()->first();

        $price = $product->product_prices->where('rate_id', 1)->first();

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

        $this->actingAs($customer)->postJson('api/v1/customer/recharge-balance', [
            'amount' => 10000,
        ]);

        $response = $this->actingAs($customer)->postJson('api/v1/customer/orders', [
            'product_id' => $product->id,
            'rate_id' => $price->rate_id,
            'desired_pick_up_date' => fake()->time,
            'desired_delivery_date' => fake()->time,
            'text' => fake()->text,
            'sender_id' => $customer->id,
            'sender_type' => 'customer',
            'receiver_id' => $partner->id,
            'receiver_type' => 'partner',
            'door_to_door' => false,
        ]);

        $order = Order::find($response['order']['id']);

        echo 'Отправитель: ' . $order->sender->name . ' ' . $order->sender->last_name . ' адрес ' . $order->sender->street . PHP_EOL;

        echo 'Получатель: ' . $order->receiver->name . ' ' . $order->receiver->last_name . ' адрес ' .  $order->receiver->street . PHP_EOL;

        echo 'Заказ #'. $order->id .' отправлен на проверку админом в : ' . $order->created_at . PHP_EOL;

        $admin = User::find(1);


        $this->actingAs($admin)->putJson('api/v1/admin/orders/' . $order->id . '/accepted');

        $order = Order::find(1);

        $order->setStatus(OrderStatus::ACCEPTED);

        echo 'Заказ #'. $order->id .' одобрен админом в ' . $order->updated_at . PHP_EOL;

        $courier = Courier::factory()->create();

        $this->actingAs($courier)->postJson('api/v1/courier/settings', [
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'middle_name' => fake()->name,
            'region' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->streetAddress,
            'house' => 4,
            'flat' => 123,
            'passport_series' => fake()->randomNumber(4),
            'passport_number' => fake()->randomNumber(6),
            'passport_issued_by' => fake()->title,
            'passport_issued_date' => fake()->date('d.m.Y'),
        ]);


        $this->actingAs($courier)->getJson('api/v1/courier/orders?accepted=true');

        $this->actingAs($courier)->putJson('api/v1/courier/orders/' . $order->id . '/start');

        $order = Order::find(1);

        echo 'Баланс заказчика до доставки ' . Customer::find($customer->id)->balance . PHP_EOL;

        echo 'Баланс курьера до доставки ' . Courier::find($courier->id)->balance . PHP_EOL;

        echo 'Стоимость доставки ' . $order->price . PHP_EOL;

        echo 'Заказ #'. $order->id .' начали доставлять в ' . $order->start_at . PHP_EOL;

        $this->actingAs($courier)->putJson('api/v1/courier/orders/' . $order->id . '/stop');

        $order = Order::find(1);

        echo 'Заказ #'. $order->id .' закончили доставлять в ' . $order->stop_at . PHP_EOL;

        echo 'Баланс заказчика после доставки ' . Customer::find($customer->id)->balance . PHP_EOL;

        echo 'Баланс курьера после доставки ' . Courier::find($courier->id)->balance . PHP_EOL;

        dd();
    }
}
