<?php

namespace App\Filament\User\Resources\User;

use App\Filament\User\Resources\User\BorrowedResource\Pages;
use App\Models\Borrowing;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BorrowedResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

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
                TextColumn::make("status")
                    ->color(function ($state) {
                        return match ($state) {
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'primary',
                        };
                    }),
                TextColumn::make('return_date')
                    ->date("D d/m/Y"),
                TextColumn::make('created_at')
                    ->label("Borrowed At")
                    ->date("D d/m/Y")
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make("return_book")
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function (Borrowing $record) {
                        $record->update(['return_at' => now()]);
                    })
                    ->visible(fn($record) => $record->status == 'approved' && $record->return_at == null),
                Tables\Actions\DeleteAction::make()->visible(fn($record) => $record->return_at != null),
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
            'index' => Pages\ListBorroweds::route('/'),
            'create' => Pages\CreateBorrowed::route('/create'),
            'edit' => Pages\EditBorrowed::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string|null
    {
        return "Inventory";
    }
}
