<?php

namespace App\Filament\User\Resources\User\BorrowedResource\Pages;

use App\Filament\User\Resources\User\BorrowedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrowed extends EditRecord
{
    protected static string $resource = BorrowedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
