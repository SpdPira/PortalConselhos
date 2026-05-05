<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conselho;

class ConselhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conselhos = [
            'Conselho Municipal de Bem Estar Animal - COMBEA',
            'Conselho Municipal de Políticas Sobre Drogas  - COMAD',
            'Conselho Municipal de Saúde - CMS',
            'Conselho Municipal de Turismo - COMTUR',

        ];

        foreach ($conselhos as $nome) {
            Conselho::create(['nome' => $nome]);
        }
    }
}
