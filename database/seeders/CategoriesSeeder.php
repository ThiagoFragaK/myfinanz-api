<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Food', 'description' => 'Expenses for food and restaurants', 'icon' => 'Utensils'],
            ['name' => 'Transport', 'description' => 'Expenses for transportation', 'icon' => 'Car'],
            ['name' => 'Housing', 'description' => 'Rent, utilities, electricity, water', 'icon' => 'Home'],
            ['name' => 'Health', 'description' => 'Health plans, medications, medical appointments', 'icon' => 'Activity'],
            ['name' => 'Education', 'description' => 'School, courses and educational materials', 'icon' => 'Library'],
            ['name' => 'Entertainment', 'description' => 'Movies, shows and leisure', 'icon' => 'Popcorn'],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
