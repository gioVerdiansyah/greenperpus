<?php

namespace App\Filament\Resources\OfficerResource\Pages;

use App\Filament\Resources\OfficerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOfficer extends CreateRecord
{
    protected static string $resource = OfficerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = "OFFICER";
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return parent::getResource()::getUrl('index');
    }
}
