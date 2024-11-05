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

    public function getTitle(): string
    {
        return "Edit Officer";
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['role'] = "OFFICER";
        return $data;
    }
}
