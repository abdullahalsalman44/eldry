<?php

namespace App\Filament\Resources\CaregiverResource\Pages;

use App\Filament\Resources\CaregiverResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaregiver extends EditRecord
{
    protected static string $resource = CaregiverResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
{
    $data['role'] = 'caregiver';
    return $data;
}


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
