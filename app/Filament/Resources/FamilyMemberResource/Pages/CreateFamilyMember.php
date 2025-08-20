<?php

namespace App\Filament\Resources\FamilyMemberResource\Pages;

use Filament\Actions;
use App\Models\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FamilyMemberResource;

class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function afterCreate(): void
    {
        $this->record->assignRole('family'); // ✅
    }
}
