<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Électronique',
                'description' => 'Produits électroniques et accessoires',
            ],
            [
                'name' => 'Vêtements',
                'description' => 'Vêtements et accessoires de mode',
            ],
            [
                'name' => 'Alimentation',
                'description' => 'Produits alimentaires et boissons',
            ],
            [
                'name' => 'Maison',
                'description' => 'Articles pour la maison et le jardin',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
