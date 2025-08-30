<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\IncomeTypesSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IncomeTypesSeeder::class,
            UsersTableSeeder::class,
            CategoriesSeeder::class,
        ]);
    }
}
