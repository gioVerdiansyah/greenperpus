<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Livewire\BookReviews;
use App\Models\Book;
use App\Models\BookReview;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make("thumbnail")
                    ->image()
                    ->maxSize(2048)
                    ->directory("book_thumbnail")
                    ->required(),
                TextInput::make("title")->required(),
                Select::make("book_category_id")
                    ->relationship("categories", "name")
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make("name")->required()
                    ])
                    ->required(),
                TextInput::make("writer")->required(),
                TextInput::make("publisher")->required(),
                TextInput::make("year_publish")->required()->integer(),
                Textarea::make("description")->required(),
                TextInput::make("stock")->required()->integer(),
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
                TextColumn::make("writer"),
                TextColumn::make("publisher"),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->icon("heroicon-o-eye"),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infoList(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Grid::make()->columns(3)
                                ->schema([
                                    ImageEntry::make("thumbnail"),
                                    Group::make()
                                        ->schema([
                                            TextEntry::make("title"),
                                            TextEntry::make("writer"),
                                            TextEntry::make("categories")
                                                ->badge()
                                                ->getStateUsing(fn(Book $record) => $record->categories->pluck('name')),
                                        ]),
                                    Group::make()
                                        ->schema([
                                            TextEntry::make("publisher"),
                                            TextEntry::make("year_publish"),
                                            TextEntry::make("stock")
                                        ]),
                                ])
                        ])->from("lg"),
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
            'view' => Pages\BookDetail::route('/{record}'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return "Management";
    }
}
