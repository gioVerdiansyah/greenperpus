<?php

namespace App\Filament\Resources\OfficerResource\Pages;

use App\Filament\Resources\OfficerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfficer extends EditRecord
{
    protected static string $resource = OfficerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['role'] = "OFFICER";
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return parent::getResource()::getUrl('index');
    }
}
