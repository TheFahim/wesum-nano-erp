<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationArea>
 */
class PublicationAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'publication_id' => collect(Publication::pluck('id'))->random(),
            'name' => fake()->paragraph(),
            'title' => fake()->sentence(7),
            'link' => fake()->url(),
            'year' => fake()->year(),
            'author' => [
                'author_1' => fake()->name(),
                'author_2' => fake()->name(),
                'author_3' => fake()->name()
            ]



        ];
    }
}
