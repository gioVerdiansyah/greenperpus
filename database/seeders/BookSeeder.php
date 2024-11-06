<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = now();
        for ($i = 1; $i <= 30; $i++) {
            Book::create([
                'thumbnail' => fake()->imageUrl(),
                'title' => fake()->sentence(),
                "description" => fake()->text(),
                "writer" => fake()->name(),
                "publisher" => fake()->company(),
                "year_publish" => fake()->year(),
                "stock" => fake()->numberBetween(5, 20)
            ]);

            $date = $date->addMonth();
        }
    }
}
