<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficerResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OfficerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = "Officers data";
    protected static ?string $Label = "Officer";
    protected static ?string $pluralLabel = "Officer";

    public static function canAccess():bool
    {
        return auth()->user()->role == "ADMIN";
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")->required(),
                TextInput::make("email")
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make("password")
                    ->required()
                    ->password()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")->searchable(),
                TextColumn::make("email")->searchable(),
                TextColumn::make("created_at")->date("d/m/y")
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

    public static function getEloquentQuery():Builder
    {
        return parent::getEloquentQuery()->where("role", "OFFICER");
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
            'index' => Pages\ListOfficers::route('/'),
            'create' => Pages\CreateOfficer::route('/create'),
            'edit' => Pages\EditOfficer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string|null
    {
        return "Officer";
    }
}
