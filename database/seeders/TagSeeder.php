<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagSeeder extends Seeder
{
    use HasFactory;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()
            ->count(10)
            ->create()
            ->each(function ($tag) {

                $tag->posts()->attach(Post::inRandomOrder()->take(rand(1, 3))->pluck('id'));
            });
    }
}
