<?php

namespace App\Filament\User\Resources\FavoriteResource\Pages;

use App\Filament\User\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFavorite extends CreateRecord
{
    protected static string $resource = FavoriteResource::class;
}
