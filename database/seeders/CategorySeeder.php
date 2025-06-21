<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 categories with random names
        Category::factory()
            ->count(5)
            ->create()
            ->each(function ($category) {
                // Optionally, you can set additional properties or relationships here
                $category->category_name = 'Category ' . $category->id; // Example of setting a name
                $category->save();
            });
    }
}
