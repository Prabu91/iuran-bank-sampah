<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Petugas
        User::create([
            'name' => 'Bank Sampah Bersinar',
            'username' => 'banksampahbersinar',
            'email' => 'bsb1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // Viewer
        User::create([
            'name' => 'Viewer 1',
            'username' => 'viewer1',
            'email' => 'viewer1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'viewer',
        ]);
    }
}
