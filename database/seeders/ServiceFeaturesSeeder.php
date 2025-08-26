<?php

namespace Database\Seeders;

use App\Models\ServiceFeature;
use Illuminate\Database\Seeder;

class ServiceFeaturesSeeder extends Seeder
{
    public function run()
    {
        $serviceFeatures = [
            [
                'title' => 'Buffet Completo',
                'description' => 'Cardápios personalizados com opções para todos os gostos, desde pratos tradicionais até gastronomia contemporânea.',
                'icon' => 'fas fa-utensils',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Som & Iluminação',
                'description' => 'Sistema profissional de áudio e iluminação para criar a atmosfera perfeita para seu evento.',
                'icon' => 'fas fa-music',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Cenários Únicos',
                'description' => 'Ambiente rústico inspirado no rancho americano, com cenários naturais e decoração personalizada.',
                'icon' => 'fas fa-camera',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Capacidade Flexível',
                'description' => 'Estrutura adaptável para eventos de 50 a 500 pessoas, com diferentes configurações de espaço.',
                'icon' => 'fas fa-users',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'title' => 'Estacionamento',
                'description' => 'Amplo estacionamento gratuito para todos os convidados, com segurança 24 horas.',
                'icon' => 'fas fa-car',
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'title' => 'Decoração',
                'description' => 'Serviços de decoração personalizada para criar o ambiente ideal para sua celebração.',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 6,
                'status' => true,
            ],
            [
                'title' => 'Wi-Fi Premium',
                'description' => 'Internet de alta velocidade disponível para todos os convidados durante o evento.',
                'icon' => 'fas fa-wifi',
                'sort_order' => 7,
                'status' => true,
            ],
            [
                'title' => 'Segurança 24h',
                'description' => 'Equipe de segurança presente durante todo o evento para garantir tranquilidade.',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 8,
                'status' => true,
            ],
        ];

        foreach ($serviceFeatures as $feature) {
            ServiceFeature::create($feature);
        }
    }
}
