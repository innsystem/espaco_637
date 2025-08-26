<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SlidersSeeder extends Seeder
{
    public function run()
    {
        $sliders = [
            [
                'title' => 'Espaço 637',
                'subtitle' => 'Onde cada momento se torna inesquecível',
                'href' => null,
                'target' => '_self',
                'image' => 'galerias/espaco637/01.jpg',
                'date_start' => null,
                'date_end' => null,
                'status' => 1,
            ],
            [
                'title' => 'Noites Mágicas',
                'subtitle' => 'Eventos únicos em ambiente rústico',
                'href' => null,
                'target' => '_self',
                'image' => 'galerias/espaco637/02.jpg',
                'date_start' => null,
                'date_end' => null,
                'status' => 1,
            ],
            [
                'title' => 'Eventos Únicos',
                'subtitle' => 'Casamentos, aniversários e celebrações especiais',
                'href' => null,
                'target' => '_self',
                'image' => 'galerias/espaco637/03.jpg',
                'date_start' => null,
                'date_end' => null,
                'status' => 1,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
