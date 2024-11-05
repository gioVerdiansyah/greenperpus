<?php

namespace App\Filament\User\Resources\User\BookCollectionResource\Pages;

use App\Filament\User\Resources\User\BookCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookCollection extends CreateRecord
{
    protected static string $resource = BookCollectionResource::class;
}
