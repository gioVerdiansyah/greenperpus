<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BorrowedResource\Pages;
use App\Filament\User\Resources\BorrowedResource\RelationManagers;
use App\Models\BookReview;
use App\Models\Borrowed;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\RatingTheme;

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
                TextColumn::make("user.name")
                    ->label("User"),
                TextColumn::make("book.title")
                    ->label("Book"),
                TextColumn::make("total"),
                TextColumn::make("book.stock"),
                TextColumn::make("status")
                    ->color(function ($record) {
                        return match ($record->status) {
                            'APPROVED' => "success",
                            'REJECTED' => "danger",
                            default => "primary"
                        };
                    }),
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
                Action::make("return_book")
                    ->color("info")
                    ->form([
                        Textarea::make("review_book")->required(),
                        Rating::make("rating")->theme(RatingTheme::HalfStars)->default(2.5)->required()
                    ])
                    ->action(function (array $data, Borrowing $record) {
                        BookReview::create([
                            "user_id" => auth()->user()->id,
                            "book_id" => $record->book_id,
                            "review" => $data['review_book'],
                            "rating" => $data['rating']
                        ]);

                        $record->update(["return_at" => now()]);
                    })
                    ->visible(fn(Borrowing $record) => $record->status == "APPROVED" && $record->return_at == null),
                DeleteAction::make()->visible(fn(Borrowing $record) => $record->return_at != null)
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

    public static function getNavigationGroup(): string
    {
        return "Inventory";
    }
}
