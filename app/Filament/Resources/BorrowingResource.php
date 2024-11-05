<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowingResource\Pages;
use App\Filament\Resources\BorrowingResource\RelationManagers;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\HeaderActionsPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

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
                TextColumn::make("user.name")->label("Borrowing"),
                TextColumn::make("book.name"),
                TextColumn::make("created_at")
                    ->label("Borrowed at")
                    ->date("d/m/y h:i:s"),
                TextColumn::make("return_date")
                    ->date("d/m/y h:i:s")
                    ->label("Return date"),
                TextColumn::make("status"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make("approve")
                    ->color("success")
                    ->modalHeading("Alert conformation")
                    ->modalSubheading("Are you sure to approve?")
                    ->modalButton("Yes, No")
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => "approved"]);
                    })
                    ->visible(fn($record) => $record->status === "pending"),
                Action::make("rejected")
                    ->color("danger")
                    ->modalHeading("Alert conformation")
                    ->modalSubheading("Are you sure to reject?")
                    ->modalButton("Yes, No")
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => "rejected"]);
                    })
                    ->visible(fn($record) => $record->status === "pending"),
                DeleteAction::make()->visible(fn($record) => $record->status != "pending")
            ])
            ->headerActions([
                Action::make("print")
                    ->label("Generate Report")
                    ->icon("heroicon-o-printer")
                    ->color("primary")
                    ->action(function () {
                        $data = Borrowing::all();

                        $pdf = Pdf::loadView("generate_report", ["data" => $data]);

                        return response()->streamDownload(
                            fn() => print ($pdf->output()),
                            "borrowing_report.pdf"
                        );
                    })
                    ->visible(Borrowing::count() > 0)
            ], )
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
            'index' => Pages\ListBorrowings::route('/'),
            'create' => Pages\CreateBorrowing::route('/create'),
            'edit' => Pages\EditBorrowing::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string|null
    {
        return "Management Book";
    }
}
