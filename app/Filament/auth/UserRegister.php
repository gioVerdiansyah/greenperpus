<?php
namespace App\Filament\Auth;

use Filament\Pages\Auth\Register;

class UserRegister extends Register
{
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = "USER";
        return $data;
    }
}
