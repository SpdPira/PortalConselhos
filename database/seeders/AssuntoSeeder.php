<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assunto;

class AssuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assuntos = [
            ['descricao' => 'Legislação'],
            ['descricao' => 'Pautas'],
            ['descricao' => 'Atas'],
            ['descricao' => 'Resoluções'],
            ['descricao' => 'Recomendações'],
            ['descricao' => 'Reuniões Ordinárias'],
            ['descricao' => 'Reuniões Extraordinárias'],
        ];

        Assunto::insert($assuntos);
    }
}
