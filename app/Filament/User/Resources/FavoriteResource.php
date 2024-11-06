<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\FavoriteResource\Pages;
use App\Models\BookCollection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FavoriteResource extends Resource
{
    protected static ?string $model = BookCollection::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Favorite';
    protected static ?string $Label = 'Favorite';
    protected static ?string $pluralLabel = 'Favorite';
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
                TextColumn::make("book.title")
                    ->label("Book"),
                TextColumn::make("book.writer")
                    ->label("Writer"),
                TextColumn::make("book.publisher")
                    ->label("Publisher"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('unfavorite')
                    ->label("Unfavorite")
                    ->color("primary")
                    ->icon("heroicon-o-star")
                    ->action(function (BookCollection $record) {
                        $record->delete();
                    })
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
            'index' => Pages\ListFavorites::route('/'),
            'create' => Pages\CreateFavorite::route('/create'),
            'edit' => Pages\EditFavorite::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return "Inventory";
    }
}
