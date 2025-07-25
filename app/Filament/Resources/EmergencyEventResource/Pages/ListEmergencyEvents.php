<?php

namespace App\Filament\Resources\EmergencyEventResource\Pages;

use App\Filament\Resources\EmergencyEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmergencyEvents extends ListRecords
{
    protected static string $resource = EmergencyEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
