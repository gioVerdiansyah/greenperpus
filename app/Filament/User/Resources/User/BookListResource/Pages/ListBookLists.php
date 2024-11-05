<?php

namespace App\Filament\User\Resources\User\BookListResource\Pages;

use App\Filament\User\Resources\User\BookListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookLists extends ListRecords
{
    protected static string $resource = BookListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
