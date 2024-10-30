<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'email' => 'admin@admin.com',
             'password' => Hash::make('password')
         ]);

         User::factory()->create();

         $this->call([
             CountrySeeder::class,
             CategorySeeder::class,
             StatusSeeder::class,
             ProductSeeder::class
         ]);
    }
}
