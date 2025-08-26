<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    public function run()
    {
        $statistics = [
            [
                'title' => 'Eventos Realizados',
                'value' => '200+',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Mil Metros Quadrados',
                'value' => '8',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Capacidade Máxima',
                'value' => '500',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Avaliação Média',
                'value' => '4.9',
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        foreach ($statistics as $statistic) {
            Statistic::create($statistic);
        }
    }
}
