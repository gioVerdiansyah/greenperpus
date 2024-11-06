<?php

namespace App\Filament\User\Resources\BorrowedResource\Pages;

use App\Filament\User\Resources\BorrowedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowed extends CreateRecord
{
    protected static string $resource = BorrowedResource::class;
}
