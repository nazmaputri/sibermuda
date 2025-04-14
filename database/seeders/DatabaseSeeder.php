<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RatingKursus;
use App\Models\Rating;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('password'), 
            'role'      => 'admin',
            'status'    => 'active',
        ]);
    }
}
