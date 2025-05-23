<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
        ]);
        
        // Récupération des rôles
        $adminRole = Role::where('name', 'admin')->first();
        $agentVenteRole = Role::where('name', 'agent_vente')->first();
        $approvisionneur = Role::where('name', 'approvisionneur')->first();
        
        // Création d'un utilisateur admin par défaut
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@zamastock.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach($adminRole);
        
        // Création d'un utilisateur agent de vente
        $agentVente = User::factory()->create([
            'name' => 'Agent de Vente',
            'email' => 'agent@zamastock.com',
            'password' => bcrypt('password'),
        ]);
        $agentVente->roles()->attach($agentVenteRole);
        
        // Création d'un utilisateur approvisionneur
        $appro = User::factory()->create([
            'name' => 'Approvisionneur',
            'email' => 'appro@zamastock.com',
            'password' => bcrypt('password'),
        ]);
        $appro->roles()->attach($approvisionneur);
    }
}