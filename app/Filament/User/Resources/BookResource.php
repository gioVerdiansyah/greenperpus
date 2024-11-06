<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BookResource\Pages;
use App\Filament\User\Resources\BookResource\RelationManagers;
use App\Livewire\BookReviews;
use App\Models\Book;
use App\Models\BookCollection;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("thumbnail"),
                TextColumn::make("title")
                    ->limit(20)
                    ->searchable(),
                TextColumn::make("stock"),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                Action::make("borrow")
                    ->icon("heroicon-o-archive-box-arrow-down")
                    ->color("info")
                    ->form([
                        DatePicker::make("return_date")->required()->date(),
                        TextInput::make("total")
                            ->required()
                            ->integer()
                            ->maxValue(fn(Book $book) => $book->stock)
                    ])
                    ->action(function (array $data, Book $book) {
                        Borrowing::create([
                            "user_id" => auth()->user()->id,
                            "book_id" => $book->id,
                            "return_date" => $data['return_date'],
                            "total" => $data['total']
                        ]);
                    })
                    ->visible(function (Book $record) {
                        $borrowed = !Borrowing::where("user_id", auth()->user()->id)->where("book_id", $record->id)->whereNull("return_at")->exists();
                        $stock = $record->stock > 0;
                        return $borrowed && $stock;
                    }),
                Action::make("favorite")
                    ->icon("heroicon-o-star")
                    ->action(function (Book $record) {
                        BookCollection::create([
                            "user_id" => auth()->user()->id,
                            "book_id" => $record->id,
                        ]);
                    })
                    ->visible(function (Book $record) {
                        return !BookCollection::where("user_id", auth()->user()->id)->where("book_id", $record->id)->exists();
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Grid::make()->columns(3)
                                ->schema([
                                    ImageEntry::make('thumbnail'),
                                    Group::make()
                                        ->schema([
                                            TextEntry::make("title"),
                                            TextEntry::make("writer"),
                                            TextEntry::make("categories")
                                                ->badge()
                                                ->getStateUsing(fn(Book $book) => $book->categories->pluck('name'))
                                        ]),
                                    Group::make()
                                        ->schema([
                                            TextEntry::make("publisher"),
                                            TextEntry::make("year_publish"),
                                            TextEntry::make("stock"),
                                        ]),
                                ]),
                        ])->from('lg'),
                        Section::make("Description")
                            ->schema([
                                TextEntry::make("description")
                                    ->prose()
                                    ->hiddenLabel()
                            ])->collapsible(),
                        Group::make()
                            ->schema(fn(Book $book) => [Livewire::make(BookReviews::class, ['id' => $book->id])])
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'detail' => Pages\BookDetail::route('/{record}'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return "Inventory";
    }
}
