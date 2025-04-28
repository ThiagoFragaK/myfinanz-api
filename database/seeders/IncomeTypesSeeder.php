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
            ['name' => 'Regular'],
            ['name' => 'Ticket Food'],
            ['name' => 'Ticket Meals'],
        ]);
    }
}
