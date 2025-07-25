<?php

namespace App\Filament\Resources\CaregiverResource\Pages;

use App\Filament\Resources\CaregiverResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCaregiver extends CreateRecord
{
    protected static string $resource = CaregiverResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['role'] = 'caregiver';
    return $data;
}

}
