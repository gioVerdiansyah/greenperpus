<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        for($i = 1; $i <= 30; $i ++){
            Book::create([
                "thumbnail" => fake()->imageUrl,
                "name" => fake()->userName(),
                "writer" => fake()->name(),
                "publisher" => fake()->company(),
                "year_publish" => fake()->year(),
                "created_at" => $now,
                "updated_at" => $now
            ]);
            $now = $now->addMonth();
        }

        $books = Book::all();
        $categories = BookCategory::all();

        foreach ($books as $book) {
            $randomCategories = $categories->random(rand(1, 3))->pluck('id');
            $book->categories()->attach($randomCategories);
        }
    }
}
