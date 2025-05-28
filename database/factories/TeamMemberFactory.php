<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamMember>
 */
class TeamMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TeamMember::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'designation' => fake()->jobTitle(),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'social' => [
                'facebook' => fake()->url(),
                'twitter' => fake()->url(),
                'linked_in' => fake()->url()
            ],
            'member_type' => fake()->randomElement([1,2])
        ];
    }
}
