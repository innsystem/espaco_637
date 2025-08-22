<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'id' => 1,
                'title' => 'Loja Virtual - Starting',
                'slug' => 'loja-virtual-starting',
                'description' => '<li>Visitas <b>Ilimitadas</b></li>
<li>Produtos <b>Ilimitados</b></li>
<li>Pedidos <b>Ilimitados</b></li>
<li>Suporte E-mail + WhatsApp</li>
<li>Modelos de Visuais (5) + Personalização *</li>
<li>Pack 5 artes digitais <b>BRINDE</b></li>',
                'status' => 1,
                'sort_order' => 1,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 100.00,
                'quarterly_price' => 270.00,
                'semiannual_price' => 0.00,
                'annual_price' => 1020.00,
                'biennial_price' => 0.00
            ],
            [
                'id' => 2,
                'title' => 'Hospedagem de Site',
                'slug' => 'hospedagem-de-site',
                'description' => '<li>Espaço em Disco <b>10GB</b></li>
<li>Contas de Email <b>5</b></li>
<li>Tráfego Mensal <b>Ilimitado</b></li>
<li>Banco de Dados <b>5</b></li>
<li>Suporte técnico 24/7</li>
<li>Certificado SSL <b>Gratuito</b></li>',
                'status' => 1,
                'sort_order' => 2,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 20.00,
                'quarterly_price' => 54.00,
                'semiannual_price' => 0.00,
                'annual_price' => 204.00,
                'biennial_price' => 0.00
            ],
            [
                'id' => 3,
                'title' => 'Catálogo Virtual',
                'slug' => 'catalogo-virtual',
                'description' => '<li>Produtos <b>Ilimitados</b></li>
<li>Categorias <b>Ilimitadas</b></li>
<li>Vitrine Digital</li>
<li>Compartilhamento via WhatsApp</li>
<li>Personalização de Marca</li>',
                'status' => 1,
                'sort_order' => 3,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 0.00,
                'quarterly_price' => 0.00,
                'semiannual_price' => 0.00,
                'annual_price' => 0.00,
                'biennial_price' => 0.00
            ],
            [
                'id' => 4,
                'title' => 'Loja Virtual - Rocket',
                'slug' => 'loja-virtual-rocket',
                'description' => '<li>Todos os recursos do Starting</li>
<li>Marketing Automático</li>
<li>Integração Multi-plataforma</li>
<li>Relatórios Avançados</li>
<li>App Personalizado</li>
<li>Suporte Prioritário</li>',
                'status' => 1,
                'sort_order' => 4,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 200.00,
                'quarterly_price' => 540.00,
                'semiannual_price' => 0.00,
                'annual_price' => 2040.00,
                'biennial_price' => 0.00
            ],
            [
                'id' => 5,
                'title' => 'Internet',
                'slug' => 'internet',
                'description' => '<li>Conexão de alta velocidade</li>
<li>Suporte técnico</li>
<li>Instalação inclusa</li>',
                'status' => 1,
                'sort_order' => 5,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 25.00,
                'quarterly_price' => 0.00,
                'semiannual_price' => 0.00,
                'annual_price' => 0.00,
                'biennial_price' => 0.00
            ],
            [
                'id' => 6,
                'title' => 'WhatsApp',
                'slug' => 'whatsapp',
                'description' => '<li>Acesso via API oficial</li>
<li>Mensagens ilimitadas</li>
<li>Automações básicas</li>
<li>Suporte ao cliente</li>',
                'status' => 1,
                'sort_order' => 6,
                'is_recurring' => true,
                'single_payment_price' => 0.00,
                'monthly_price' => 9.90,
                'quarterly_price' => 29.70,
                'semiannual_price' => 0.00,
                'annual_price' => 118.80,
                'biennial_price' => 0.00
            ],
        ];

        foreach ($services as $serviceData) {
            // Verificar se o serviço já existe
            $service = Service::find($serviceData['id']);

            if (!$service) {
                Service::create($serviceData);
            } else {
                // Se já existe, atualizar
                $service->update($serviceData);
            }
        }
    }
}
