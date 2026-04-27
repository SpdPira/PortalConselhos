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
            'Antecipação ISS Constr Civil PF',
            'Casa dos Conselhos Municipais',
            'Conselho de Acompanhamento e Controle Social do FUNDEB (Decreto)',
            'Conselho de Alimentação Escolar - CAE',
            'Conselho Diretor do Fundo de Assistência ao Esporte (FAE)',
            'Conselho Diretor do Fundo Especial de Bombeiros - FEBOM',
            'Conselho Municipal de Assistência Social - SMAS',
            'Conselho Municipal de Bem Estar Animal - COMBEA',
            'Conselho Municipal de Defesa Civil',
            'Conselho Municipal de Desenvolvimento Rural',
            'Conselho Municipal de Educação - CME',
            'Conselho Municipal de Meio Ambiente - CMMA',
            'Conselho Municipal de Políticas Culturais - CMPC',
            'Conselho Municipal de Políticas Sobre Drogas  - COMAD',
            'Conselho Municipal de Regulação e Controle Social',
            'Conselho Municipal de Saúde - CMS',
            'Conselho Municipal de Turismo - COMTUR',
            'Conselho Municipal do Plano Diretor',
            'Conselho Municipal dos Contribuintes',
            'Conselho Municipal dos Direitos da Criança e do Adoslescente - CMDCA',
            'Conselho Municipal dos Direitos do Idoso de Pirassununga - CMDPI'
        ];

        foreach ($conselhos as $nome) {
            Conselho::create(['nome' => $nome]);
        }
    }
}
