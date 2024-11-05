<?php

namespace App\Filament\User\Resources\User\BookCollectionResource\Pages;

use App\Filament\User\Resources\User\BookCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookCollections extends ListRecords
{
    protected static string $resource = BookCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
