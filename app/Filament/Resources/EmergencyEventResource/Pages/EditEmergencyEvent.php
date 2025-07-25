<?php

namespace App\Filament\Resources\EmergencyEventResource\Pages;

use App\Filament\Resources\EmergencyEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmergencyEvent extends EditRecord
{
    protected static string $resource = EmergencyEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
