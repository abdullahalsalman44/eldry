<?php

namespace App\Filament\Resources\ElderlyPersonResource\Pages;

use App\Filament\Resources\ElderlyPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElderlyPeople extends ListRecords
{
    protected static string $resource = ElderlyPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
