<?php

namespace App\Filament\Resources\MedicalNoteResource\Pages;

use App\Filament\Resources\MedicalNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Notification;

class CreateMedicalNote extends CreateRecord
{
    protected static string $resource = MedicalNoteResource::class;

    protected function afterCreate(): void
    {
        // تحديد الطبيب
        if (auth()->check()) {
            $this->record->update([
                'doctor_id' => auth()->id(),
            ]);
        }

        // إرسال إشعار إذا كانت الملاحظة حرجة
        if ($this->record->is_critical) {
            // حدد الجهة المستفيدة من التنبيه: الإدارة أو الأطباء أو جميعهم
            // هنا نرسل للإدارة مثلاً (كل من دوره admin)
            $adminUsers = \App\Models\User::where('role', 'admin')->get();

            foreach ($adminUsers as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'تنبيه: حالة حرجة',
                    'message' => 'تمت إضافة ملاحظة طبية حرجة للمقيم: ' . $this->record->elderly->full_name,
                    'type' => 'critical_medical_note',
                    'sent_at' => now(),
                    'is_read' => false,
                ]);
            }
        }
    }
}
