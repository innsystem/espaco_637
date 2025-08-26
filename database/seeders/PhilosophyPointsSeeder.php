<?php

namespace Database\Seeders;

use App\Models\PhilosophyPoint;
use Illuminate\Database\Seeder;

class PhilosophyPointsSeeder extends Seeder
{
    public function run()
    {
        $philosophyPoints = [
            [
                'title' => 'Paixão',
                'description' => 'Amamos o que fazemos e isso se reflete em cada detalhe',
                'icon' => 'fas fa-heart',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Qualidade',
                'description' => 'Compromisso com a excelência em todos os aspectos',
                'icon' => 'fas fa-star',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Família',
                'description' => 'Tratamos cada cliente como parte da nossa família',
                'icon' => 'fas fa-users',
                'sort_order' => 3,
                'status' => true,
            ],
        ];

        foreach ($philosophyPoints as $point) {
            PhilosophyPoint::create($point);
        }
    }
}
