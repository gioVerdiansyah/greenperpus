<?php

namespace App\Filament\User\Resources\BorrowedResource\Pages;

use App\Filament\User\Resources\BorrowedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorroweds extends ListRecords
{
    protected static string $resource = BorrowedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
