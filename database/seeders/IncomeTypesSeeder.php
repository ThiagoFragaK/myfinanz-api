<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('income_types')->insert([
            ['name' => 'Regular', 'created_at' => now()],
            ['name' => 'Ticket Food', 'created_at' => now()],
            ['name' => 'Ticket Meals', 'created_at' => now()],
        ]);
    }
}
