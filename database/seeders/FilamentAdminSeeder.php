<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FilamentAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Filament',
            'email' => 'filadmin@coinbees.com',
            'password' => Hash::make('admin123')
        ]);
    }
}
