<?php

namespace Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
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
            'email' => 'elwin@example.com',
            'username' => 'elwin',
            'password' => Hash::make('elwin'),
        ])->assignRole(Utils::createRole());

        $this->command->info('User Seeding Completed.');
    }
}
