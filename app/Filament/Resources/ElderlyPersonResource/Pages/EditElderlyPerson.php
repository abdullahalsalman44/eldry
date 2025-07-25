<?php

namespace App\Filament\Resources\ElderlyPersonResource\Pages;

use App\Filament\Resources\ElderlyPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElderlyPerson extends EditRecord
{
    protected static string $resource = ElderlyPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
