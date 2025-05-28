<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => collect(Service::pluck('id'))->random(),
            'name' => fake()->sentence(2),
            'files' => [
                'r1' => fake()->url(),
                'r2' => fake()->url(),
                'r3' => fake()->url()
            ]
        ];
    }
}
