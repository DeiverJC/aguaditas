<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryAdjustment>
 */
class InventoryAdjustmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['input', 'output']),
            'description' => $this->faker->sentence(),
            'status' => 'draft',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
