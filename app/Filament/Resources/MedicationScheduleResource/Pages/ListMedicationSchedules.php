<?php

namespace App\Filament\Resources\MedicationScheduleResource\Pages;

use App\Filament\Resources\MedicationScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicationSchedules extends ListRecords
{
    protected static string $resource = MedicationScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
