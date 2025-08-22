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
                'title' => 'Madeiras Naturais',
                'slug' => 'madeiras-naturais',
                'description' => 'Madeiras naturais de alta qualidade para acabamentos premium',
                'image' => null,
                'order' => 1,
                'status' => 1,
            ],
            [
                'title' => 'Madeiras Compostas',
                'slug' => 'madeiras-compostas',
                'description' => 'Madeiras compostas e engineered para aplicações versáteis',
                'image' => null,
                'order' => 2,
                'status' => 1,
            ],
            [
                'title' => 'Madeiras Européias',
                'slug' => 'madeiras-europeias',
                'description' => 'Madeiras importadas da Europa com qualidade superior',
                'image' => null,
                'order' => 3,
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}