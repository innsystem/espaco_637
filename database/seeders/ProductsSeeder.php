<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o status ativo
        $activeStatus = Status::where('name', 'Habilitado')->first();
        
        if (!$activeStatus) {
            // Se não encontrar, usar o primeiro status disponível
            $activeStatus = Status::first();
        }

        $products = [
            [
                'title' => 'Lager',
                'description' => 'Refrescante, leve e fácil de beber. A queridinha de quem gosta de sabor suave e equilibrado, perfeita para qualquer ocasião.',
                'image' => 'products/lager.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'Light',
                'description' => 'Uma versão ainda mais leve e delicada, com baixo teor alcoólico. Ideal para quem busca refrescância sem abrir mão da cerveja.',
                'image' => 'products/light.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'IPA (India Pale Ale)',
                'description' => 'Marcante e aromática, com amargor característico e notas cítricas e frutadas. Para quem gosta de sabor intenso e personalidade.',
                'image' => 'products/ipa.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'Dry Stout',
                'description' => 'Escura e cremosa, com notas de café e chocolate. Uma experiência encorpada e elegante para paladares exigentes.',
                'image' => 'products/dry-stout.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'Summer Ale',
                'description' => 'Clara, leve e super refrescante, com toques cítricos. A escolha perfeita para dias quentes e momentos descontraídos.',
                'image' => 'products/summer-ale.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'Witbier',
                'description' => 'Cerveja de trigo belga, aromática e leve, com notas de especiarias e casca de laranja. Refrescância com um toque sofisticado.',
                'image' => 'products/witbier.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ],
            [
                'title' => 'Session IPA',
                'description' => 'Mantém o sabor e aroma intenso da IPA, mas com menor teor alcoólico. Equilíbrio perfeito entre potência e drinkabilidade.',
                'image' => 'products/session-ipa.jpg',
                'price' => 0,
                'stock' => 0,
                'status' => $activeStatus ? $activeStatus->id : 1
            ]
        ];

        foreach ($products as $productData) {
            Product::create([
                'category_id' => null, // Produtos sem categoria específica
                'title' => $productData['title'],
                'slug' => Str::slug($productData['title']),
                'description' => $productData['description'],
                'image' => $productData['image'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'status' => $productData['status']
            ]);
        }
    }
}
