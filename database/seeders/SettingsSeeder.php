<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'logo', 'value' => null],
            ['key' => 'favicon', 'value' => null],
            ['key' => 'meta_title', 'value' => 'Espaço 637 - Eventos Rústicos e Cervejaria Artesanal'],
            ['key' => 'meta_keywords', 'value' => 'eventos, casamentos, aniversários, cervejaria artesanal, rancho americano, espaço rústico, Ribeirão Preto'],
            ['key' => 'meta_description', 'value' => 'Espaço 637 - Local único para eventos especiais com cervejaria artesanal, inspirado no estilo rancho americano. Ideal para casamentos, aniversários e eventos corporativos.'],
            ['key' => 'script_head', 'value' => ''],
            ['key' => 'script_body', 'value' => ''],
            ['key' => 'site_name', 'value' => 'Espaço 637'],
            ['key' => 'site_proprietary', 'value' => 'Espaço 637 LTDA'],
            ['key' => 'site_document', 'value' => '12.345.678/0001-90'],
            ['key' => 'site_email', 'value' => 'contato@espaco637.com.br'],
            ['key' => 'telephone', 'value' => '(16) 4002-8922'],
            ['key' => 'cellphone', 'value' => '(16) 99999-9999'],
            ['key' => 'address', 'value' => 'Rodovia Anhanguera, Km 637, Ribeirão Preto, SP'],
            ['key' => 'hour_open', 'value' => '08:00 às 18:00'],
            ['key' => 'client_id', 'value' => Str::uuid()],
            ['key' => 'client_secret', 'value' => Str::random(40)],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
