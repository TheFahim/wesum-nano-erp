<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'author' => fake()->name(),
            'cover_image' => fake()->imageUrl(),
            'images' => [
                'image_1' => fake()->imageUrl(),
                'image_2' => fake()->imageUrl(),
                'image_3' => fake()->imageUrl(),
            ],
            'type' => fake()->randomElement([1,2]),
            'link' => fake()->url()
        ];
    }
}
