<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\BookCollectionResource\Pages;
use App\Models\User\BookCollection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookCollectionResource extends Resource
{
    protected static ?string $model = \App\Models\BookCollection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Favorite Books";
    protected static ?string $Label = "Favorite";
    protected static ?string $pluralLabel = "Favorite Books";
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
                ImageColumn::make("book.thumbnail")
                    ->label("Thumbnail"),
                TextColumn::make("book.name")
                    ->label("Book"),
                TextColumn::make("book.created_at")
                    ->label("Collection At")
                    ->date("D d/m/Y"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make("unfavorite")
                    ->icon("heroicon-o-bookmark")
                    ->label("Unfavorite")
                    ->color('primary')
                    ->action(fn($record) => $record->delete()),
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
            'index' => Pages\ListBookCollections::route('/'),
            'create' => Pages\CreateBookCollection::route('/create'),
            'edit' => Pages\EditBookCollection::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string|null
    {
        return "Inventory";
    }
}
