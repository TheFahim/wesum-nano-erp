<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'email' => [
                'email_1' => fake()->email(),
                'email_2' => fake()->email()
            ],
            'phone' => [
                'phone_1' => fake()->phoneNumber(),
                'phone_2' => fake()->phoneNumber(),
            ]
        ];
    }
}
