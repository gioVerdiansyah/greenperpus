<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("admin-ini"),
            "role" => "ADMIN"
        ]);
        User::create([
            'name' => "Officer",
            "email" => "officer@gmail.com",
            "password" => bcrypt("officer-ini"),
            "role" => "OFFICER"
        ]);
        User::create([
            'name' => "User",
            "email" => "user@gmail.com",
            "password" => bcrypt("user-ini"),
            "role" => "USER"
        ]);
    }
}
