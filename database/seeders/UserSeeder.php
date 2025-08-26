<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_group_id' => 1, // Developer
            'name' => 'Desenvolvedor',
            'email' => 'developer@innsystem.com.br',
            'password' => Hash::make('123456'),
            'password_code' => null,
            'document' => null,
            'phone' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_group_id' => 2, // Admin
            'name' => 'Administrador',
            'email' => 'contato@espaco637.com.br',
            'password' => Hash::make('123456'),
            'password_code' => null,
            'document' => null,
            'phone' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
