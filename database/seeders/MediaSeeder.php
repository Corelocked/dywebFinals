<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Media seeding logic goes here
        // For example, you can create media records using a factory
        Media::factory()->count(10)->create();

        // If you have specific media files to attach, you can do that here
        // Example:
        // $media = new Media();
        // $media->file_path = 'path/to/media/file.jpg';
        // $media->save();
        
        // You can also associate media with other models if needed
        // $post = Post::first();
        // $post->media()->attach($media->id);
        // Note: Make sure to import the necessary models at the top of this file
        // Example of attaching media to a post
    }
}
