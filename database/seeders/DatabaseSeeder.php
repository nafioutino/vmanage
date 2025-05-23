<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
        
        // Création d'un utilisateur admin par défaut
        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@zamastock.com',
            'password' => bcrypt('password'),
        ]);
        
        $user->roles()->attach(\App\Models\Role::where('name', 'admin')->first());
    }
}

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
