<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
class EditInquiry extends EditRecord
{
    protected static string $resource = InquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }



    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['response'])) {
            $data['status'] = 'answered';
            $data['response_by'] = Auth::id();
        }

        return $data;
    }


    protected function afterSave(): void
{
    if ($this->record->status === 'answered') {
        Notification::create([
            'user_id' => $this->record->user_id,
            'title' => 'تم الرد على استفسارك',
            'message' => 'تم الرد على استفسارك من قبل الإدارة.',
            'type' => 'inquiry_reply',
            'sent_at' => now(),
            'is_read' => false,
        ]);
    }
}

}
