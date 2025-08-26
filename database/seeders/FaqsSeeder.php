<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqsSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'Qual a capacidade máxima do espaço?',
                'answer' => 'O Espaço 637 tem capacidade para até 500 pessoas, com diferentes configurações para eventos menores.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'question' => 'Vocês fornecem buffet?',
                'answer' => 'Sim! Oferecemos buffet completo com cardápios personalizados para todos os tipos de eventos.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'question' => 'Há estacionamento disponível?',
                'answer' => 'Sim, temos amplo estacionamento gratuito para todos os convidados.',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'question' => 'Posso fazer uma visita antes de contratar?',
                'answer' => 'Claro! Agendamos visitas de segunda a sexta das 9h às 18h e sábados das 9h às 16h.',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'question' => 'Vocês oferecem decoração?',
                'answer' => 'Sim, oferecemos serviços de decoração personalizada para criar o ambiente ideal para seu evento.',
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'question' => 'Há Wi-Fi disponível?',
                'answer' => 'Sim, oferecemos Wi-Fi premium gratuito para todos os convidados durante o evento.',
                'sort_order' => 6,
                'status' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
