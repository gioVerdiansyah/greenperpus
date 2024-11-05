<?php

namespace App\Filament\User\Resources\User\BookCollectionResource\Pages;

use App\Filament\User\Resources\User\BookCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookCollection extends EditRecord
{
    protected static string $resource = BookCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
