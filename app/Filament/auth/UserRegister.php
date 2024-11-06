<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Register;

class UserRegister extends Register
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = "USER";
        return $data;
    }
}
