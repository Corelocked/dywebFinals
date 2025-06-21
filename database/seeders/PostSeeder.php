<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Post; // Import the Post model
use App\Models\User; // Import the User model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostSeeder extends Seeder
{
    use HasFactory;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 posts with random users and tags
        $users = User::all();

        Post::factory()
            ->count(10)
            ->create()
            ->each(function ($post) use ($users) {
                // Attach a random user to the post
                $post->user()->associate($users->random())->save();
            });

        Post::all()->each(function ($post) {
            $post->slug = Str::slug($post->title, '-');
            $post->save();
        });

        //attach categories to posts
        $categories = Category::all();
        Post::all()->each(function ($post) use ($categories) {
            $post->categories()->attach($categories->random(rand(1, 3))->pluck('id'));
        });


    }
}
