<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $product = \App\Models\Product::inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 3);

        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'total_price' => $quantity * $product->price,
        ];
    }
}
