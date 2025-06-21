<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'comment_content' => fake()->text(200),
            'comment_date' => fake()->dateTimeThisYear(),
            'reviewer_name' => fake()->name(),
            'reviewer_email' => fake()->unique()->safeEmail(),
            'is_hidden' => fake()->boolean(20),
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
        ];
    }
}