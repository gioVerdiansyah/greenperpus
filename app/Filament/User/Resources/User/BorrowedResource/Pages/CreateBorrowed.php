<?php

namespace App\Filament\User\Resources\User\BorrowedResource\Pages;

use App\Filament\User\Resources\User\BorrowedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowed extends CreateRecord
{
    protected static string $resource = BorrowedResource::class;
}
