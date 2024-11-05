<?php

namespace App\Filament\Resources\OfficerResource\Pages;

use App\Filament\Resources\OfficerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOfficer extends CreateRecord
{
    protected static string $resource = OfficerResource::class;

    public function getTitle(): string
    {
        return "New Officer";
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = "OFFICER";
        return $data;
    }
}
