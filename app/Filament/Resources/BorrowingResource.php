<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowingResource\Pages;
use App\Filament\Resources\BorrowingResource\RelationManagers;
use App\Models\Book;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowingResource extends Resource
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
                TextColumn::make("user.name")
                    ->label("User"),
                TextColumn::make("book.title")
                    ->label("Book"),
                TextColumn::make("total"),
                TextColumn::make("book.stock"),
                TextColumn::make("return_date")
                    ->date("d/m/y"),
                TextColumn::make("created_at")
                    ->label("Borrowed At")
                    ->date("d/m/y"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make("approve")
                    ->color("success")
                    ->requiresConfirmation()
                    ->action(function (Borrowing $record) {
                        Book::where("id", $record->book_id)->update(["stock" => Book::where("id", $record->book_id)->first()->stock - $record->total]);
                        $record->update(['status' => "APPROVED"]);
                    })
                    ->visible(fn(Borrowing $record) => $record->status == "PENDING"),
                Action::make("reject")
                    ->color("danger")
                    ->requiresConfirmation()
                    ->action(fn(Borrowing $record) => $record->update(['status' => "REJECTED"]))
                    ->visible(fn(Borrowing $record) => $record->status == "PENDING"),
                DeleteAction::make()->visible(fn(Borrowing $record) => $record->status != "PENDING")
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
            'index' => Pages\ListBorrowings::route('/'),
        ];
    }
    public static function getNavigationGroup(): string
    {
        return "Management";
    }
}
