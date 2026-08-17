<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lagloiredivine.cm'],
            [
                'name' => 'Administrateur La Gloire Divine',
                'password' => Hash::make('ChangeMoi123!'),
                'phone' => '682600401',
                'sex' => 'M',
                'date_of_birth' => '1990-01-01',
                'role' => 'admin',
            ]
        );

        $this->command->warn('⚠ Identifiant admin créé : admin@lagloiredivine.cm / ChangeMoi123! — à changer immédiatement.');
    }
}
