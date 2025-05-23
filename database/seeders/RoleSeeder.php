<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrateur',
                'description' => 'Gère les utilisateurs, les points de vente, les produits et supervise tout le stock'
            ],
            [
                'name' => 'agent_vente',
                'display_name' => 'Agent de vente',
                'description' => 'Effectue les ventes et consulte les stocks liés à son point de vente'
            ],
            [
                'name' => 'approvisionneur',
                'display_name' => 'Approvisionneur',
                'description' => 'Gère les entrées de stock dans un ou plusieurs points de vente'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
