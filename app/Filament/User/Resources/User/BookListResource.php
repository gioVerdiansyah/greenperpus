<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\BookListResource\Pages;
use App\Filament\User\Resources\User\BookListResource\RelationManagers;
use App\Models\Book;
use App\Models\BookCollection;
use App\Models\Borrowing;
use App\Models\User\BookList;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class BookListResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function canCreate(): bool
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
                TextColumn::make('name')->searchable(),
                TextColumn::make('formatted_categories')
                    ->formatStateUsing(fn($state) => Str::limit($state, 10))
                    ->label("Category"),
                TextColumn::make('writer')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make("borrow")
                    ->color("info")
                    ->form([
                        DatePicker::make("return_date")
                            ->required()
                    ])
                    ->action(function (array $data, Book $record) {
                        Borrowing::create(
                            [
                                "user_id" => auth()->user()->id,
                                "return_date" => $data['return_date'],
                                "book_id" => $record->id
                            ]
                        );
                    })
                    ->visible(function (Book $book) {
                        return !Borrowing::where("user_id", auth()->user()->id)->where("book_id", $book->id)->whereNull('return_at')->exists();
                    }),

                Action::make("favorite")
                    ->icon('heroicon-o-bookmark')
                    ->color('primary')
                    ->action(function (Book $book) {
                        BookCollection::create([
                            'user_id' => auth()->user()->id,
                            "book_id" => $book->id
                        ]);
                    })->visible(function (Book $book) {
                        return !BookCollection::where("user_id", auth()->user()->id)->where('book_id', $book->id)->exists();
                    })
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListBookLists::route('/'),
            'edit' => Pages\EditBookList::route('/{record}'),
        ];
    }
}
