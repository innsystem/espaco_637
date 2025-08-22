<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        // Get categories
        $naturais = Category::where('slug', 'madeiras-naturais')->first();
        $compostas = Category::where('slug', 'madeiras-compostas')->first();
        $europeias = Category::where('slug', 'madeiras-europeias')->first();

        $products = [
            [
                'category_id' => $naturais->id,
                'title' => 'Carvalho Vermelho',
                'slug' => 'carvalho-vermelho',
                'description' => 'Madeira de carvalho vermelho americano, conhecida por sua durabilidade e bela textura avermelhada. Ideal para móveis finos e acabamentos internos.',
                'image' => 'products/product_1752672977.jpg',
                'price' => 250.00,
                'stock' => 50,
                'status' => 1,
            ],
            [
                'category_id' => $naturais->id,
                'title' => 'Nogueira Americana',
                'slug' => 'nogueira-americana',
                'description' => 'Madeira de nogueira americana premium, com tonalidade escura e veios únicos. Perfeita para projetos de alto padrão.',
                'image' => 'products/product_1752671618.jpg',
                'price' => 320.00,
                'stock' => 30,
                'status' => 1,
            ],
            [
                'category_id' => $naturais->id,
                'title' => 'Carvalho Branco',
                'slug' => 'carvalho-branco',
                'description' => 'Carvalho branco americano de primeira qualidade, com tonalidade clara e grãos bem definidos. Excelente para acabamentos refinados.',
                'image' => 'products/product_1752672921.jpg',
                'price' => 280.00,
                'stock' => 45,
                'status' => 1,
            ],
            [
                'category_id' => $europeias->id,
                'title' => 'Carvalho Europeu',
                'slug' => 'carvalho-europeu',
                'description' => 'Carvalho europeu importado, caracterizado por sua densidade superior e coloração uniforme. Muito utilizado em vinícolas e projetos especiais.',
                'image' => 'products/product_1752672722.jpg',
                'price' => 380.00,
                'stock' => 25,
                'status' => 1,
            ],
            [
                'category_id' => $compostas->id,
                'title' => 'Freijó',
                'slug' => 'freijo',
                'description' => 'Madeira de freijó brasileira, conhecida por sua versatilidade e resistência. Amplamente utilizada em móveis e construção civil.',
                'image' => 'products/product_1752672735.jpg',
                'price' => 180.00,
                'stock' => 75,
                'status' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}