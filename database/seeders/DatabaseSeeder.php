<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(BookCategorySeeder::class);
        $this->call(BookSeeder::class);
    }
}
