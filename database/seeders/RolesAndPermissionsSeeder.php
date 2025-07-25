<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الأدوار إذا لم تكن موجودة
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $caregiverRole = Role::firstOrCreate(['name' => 'caregiver']);
        $familyRole = Role::firstOrCreate(['name' => 'family']);


        Permission::firstOrCreate(['name' => 'create_room']);
        Permission::firstOrCreate(['name' => 'edit_room']);
        Permission::firstOrCreate(['name' => 'delete_room']);

        // جلب دور الأدمن (أو إنشاؤه)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // ربط الصلاحيات بدور الأدمن
        $adminRole->givePermissionTo([
            'create_room',
            'edit_room',
            'delete_room',
        ]);

        // تعيين الدور admin
        $adminUser = User::where('email', 'karam8alhady8@gmail.com')->first();
        if ($adminUser && !$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // تعيين الدور doctor
        $doctorUser = User::where('email', 'karam@gmail.com')->first();
        if ($doctorUser && !$doctorUser->hasRole('doctor')) {
            $doctorUser->assignRole($doctorRole);
        }

        // ملاحظة: لا يتم تعيين caregiver هنا لأنه لا يدخل إلى الداشبورد
    }
}
