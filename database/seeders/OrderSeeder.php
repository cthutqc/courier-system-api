<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory(20)->create()->each(function ($order){

           $order->product()->associate(Product::take(1)->inRandomOrder()->first());

           $order->status = OrderStatus::ACCEPTED;

           $order->customer()->associate(Customer::take(1)->inRandomOrder()->first());

           $order->save();
        });
    }
}
