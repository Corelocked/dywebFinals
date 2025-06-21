<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['D', 'P', 'I']);
        $title = fake()->sentence();
        return [
            'title' => $title,
            'content' => fake()->paragraph(),
            'slug' => Str::slug($title),
            'publication_date' => $status == 'P' ? now() : null,
            'status' => $status,
            'featured_image_url' => fake()->imageUrl(640, 480, 'nature', true),
            'views_count' => fake()->numberBetween(0, 1000),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
