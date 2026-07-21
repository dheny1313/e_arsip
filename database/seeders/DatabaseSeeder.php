<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Database\Seeders\SheieldSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SheieldSeeder::class,
            // User::factory(10)->create();

            // User::factory()->create([
            //   'name' => 'Admin',
            // 'email' => 'admin@arsip.com',
            // 'password' => Hash::make('password'),
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ]);
    }
}
