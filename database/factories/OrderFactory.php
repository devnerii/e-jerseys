<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $payments_status = ['new', 'paid', 'unpaid', 'cancelled'];
        $status = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];

        return [
            'subtotal' => fake()->randomFloat(2, 100, 1000),
            'payment_status' => fake()->randomElement($payments_status),
            'payment_id' => fake()->randomAscii(20),
            'shipment_fee' => fake()->randomFloat(2, 10, 40),
            'status' => fake()->randomElement($status),
            'user_id' => User::inRandomOrder()->first()->id,
            'address' => fake()->streetAddress(),
            'complement' => fake()->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'acronym_state' => fake()->stateAbbr(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'created_at' => fake()->dateTimeBetween('30 days ago', 'now'),
        ];
    }
}
