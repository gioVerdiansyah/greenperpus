<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
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
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("admin-ini"),
            "role" => "ADMIN"
        ]);
        User::create([
            "name" => "Oficcer",
            "email" => "office@gmail.com",
            "password" => Hash::make("officer-ini"),
            "role" => "OFFICER"
        ]);
        User::create([
            "name" => "User",
            "email" => "user@gmail.com",
            "password" => Hash::make("user-ini"),
            "role" => "USER"
        ]);
    }
}
