<?php

namespace App\Livewire;

use App\Models\BookReview;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Livewire\Component;
use Mokhosh\FilamentRating\Columns\RatingColumn;

class BookReviews extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public $id;

    public function mount(string $id)
    {
        $this->id = $id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => BookReview::where("book_id", $this->id))
            ->columns([
                TextColumn::make("user.name"),
                TextColumn::make("book.title"),
                TextColumn::make("review"),
                RatingColumn::make("rating")
            ]);
    }
    public function render()
    {
        return view('livewire.book-reviews');
    }
}
