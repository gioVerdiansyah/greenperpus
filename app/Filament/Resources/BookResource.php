<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use App\Models\BookCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                Select::make('book_category_id')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                    ])
                    ->required(),

                TextInput::make('writer')->required()->maxLength(255),
                TextInput::make('publisher')->required()->maxLength(255),
                TextInput::make('year_publish')->required()->integer()->maxLength(4),
                FileUpload::make("thumbnail")
                    ->directory('book_thumbnail')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("thumbnail"),
                TextColumn::make('name')->searchable(),
                TextColumn::make('formatted_categories')
                    ->formatStateUsing(fn ($state) => Str::limit($state, 10))
                    ->label("Category"),
                TextColumn::make('writer')->searchable(),
                TextColumn::make('publisher')->searchable(),
                TextColumn::make('year_publish')->sortable(),
                TextColumn::make("created_at")
                    ->label("Created")
                    ->date("D F Y")
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup():string|null
    {
        return "Management Book";
    }
}
