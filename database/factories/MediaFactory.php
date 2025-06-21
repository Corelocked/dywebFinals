<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_name' => fake()->words(rand(1, 3), true),
            'file_type' => fake()->randomElement(['image', 'video', 'audio']),
            'file_size' => fake()->numberBetween(1000, 5000000), // Size in bytes
            'upload_date' => now(),
            'url' => fake()->imageUrl(640, 480, 'nature', true),
            'description' => fake()->sentence(rand(1, 5)),
        ];
    }
}
