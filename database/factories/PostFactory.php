<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        $title = $this->faker->words(8, true);
        $body = $this->faker->text(2000);

        $readingSpeed = 200;
        $words = str_word_count($body);
        $readingTime = ceil($words / $readingSpeed);

        $categoryImages = [
            1 => '/images/categories/default-tech.jpg',
            2 => '/images/categories/default-travel.jpg',
            3 => '/images/categories/default-culinary.jpg',
            4 => '/images/categories/default-fashion.jpg',
            5 => '/images/categories/default-health.jpg',
            6 => '/images/categories/default-science.jpg',
            7 => '/images/categories/default-entertainment.jpg',
            8 => '/images/categories/default-lifestyle.jpg',
            9 => '/images/categories/default-business.jpg',
            10 => '/images/categories/default-education.jpg',
            11 => '/images/categories/default-sport.jpg',
            12 => '/images/categories/default-music.jpg',
            13 => '/images/categories/default-arts.jpg',
            14 => '/images/categories/default-diy.jpg',
            15 => '/images/categories/default-games.jpeg',
        ];

        $categoryId = $this->faker->numberBetween(1, 15);

        $imagePath = $categoryImages[$categoryId];

        return [
            'title' => $title,
            'excerpt' => $this->faker->sentence(40),
            'body' => '<p>'.$body.'</p>',
            'image_path' => $imagePath,
            'slug' => Str::slug($title),
            'is_published' => true,
            'user_id' => 1,
            'category_id' => $categoryId,
            'read_time' => $readingTime,
            'change_user_id' => 1,
        ];
    }
}
