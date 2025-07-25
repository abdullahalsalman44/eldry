<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Models\Notification;
class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function afterCreate(): void
    {
        $event = $this->record;

        $users = collect(); // مجموعة المستخدمين المستهدفين

        // حدد المستلمين بناءً على نوع الفئة
        switch ($event->target_type) {
            case 'doctor':
                $users = User::where('role', 'doctor')->get();
                break;

            case 'caregiver':
                $users = User::where('role', 'caregiver')->get();
                break;

            case 'resident':
                // المقيمون من خلال العلاقة الوسيطة
                if ($event->elderly_id) {
                    $users = User::whereHas('elderlyPeople', function ($query) use ($event) {
                        $query->where('elderly_people.id', $event->elderly_id);
                    })->get();
                }
                break;

            case 'all':
                $users = User::all();
                break;
        }

        // إرسال إشعار لكل مستخدم
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'حدث جديد: ' . $event->title,
                'message' => $event->description,
                'type' => 'event',
                'sent_at' => now(),
                'is_read' => false,
            ]);
        }
    }
}
