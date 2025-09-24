<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Elwin Syahrial',
            'username' => 'elwin',
            'email' => 'elwin@example.com',
            'password' => Hash::make('elwin')
        ])->assignRole(\BezhanSalleh\FilamentShield\Support\Utils::createRole());

        $this->command->info('User Seeding Completed.');
    }
}
