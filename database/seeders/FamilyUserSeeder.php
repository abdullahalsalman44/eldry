<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FamilyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'karam',
            'email' => 'karam8alhady8@gmail.com',
            'password' => Hash::make('88888888'),
            'role' => 'admin',
            'active' => true,
        ]);
    }
}
