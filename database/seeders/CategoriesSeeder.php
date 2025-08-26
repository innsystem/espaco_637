<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'title' => 'Casamentos',
                'slug' => 'casamentos',
                'description' => 'Eventos de casamento e cerimônias',
                'order' => 1,
                'status' => 1
            ],
            [
                'title' => 'Aniversários',
                'slug' => 'aniversarios',
                'description' => 'Festas de aniversário e celebrações',
                'order' => 2,
                'status' => 1
            ],
            [
                'title' => 'Eventos Corporativos',
                'slug' => 'eventos-corporativos',
                'description' => 'Reuniões, treinamentos e eventos empresariais',
                'order' => 3,
                'status' => 1
            ],
            [
                'title' => 'Formaturas',
                'slug' => 'formaturas',
                'description' => 'Cerimônias de formatura e colação de grau',
                'order' => 4,
                'status' => 1
            ],
            [
                'title' => 'Confraternizações',
                'slug' => 'confraternizacoes',
                'description' => 'Eventos de confraternização e reuniões sociais',
                'order' => 5,
                'status' => 1
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
