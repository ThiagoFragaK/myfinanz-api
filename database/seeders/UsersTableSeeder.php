<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('finanz456');
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => $password,
            'code' => Str::random(5),
        ]);

        User::create([
            'name' => 'userin',
            'email' => 'userin@example.com',
            'password' => $password,
            'code' => Str::random(5),
        ]);
    }
}
