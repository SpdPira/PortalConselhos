<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conselho;
use App\Models\ConselhoComposicao;
use App\Models\Assunto;
use App\Models\Calendario;
use App\Models\CalendarioAnexo;
use Carbon\Carbon;

class FakeDataSeeder extends Seeder
{
    public function run()
    {
        $conselhos = Conselho::all();
        $assuntos = Assunto::all();
        
        $nomes = ['João Silva', 'Maria Santos', 'Carlos Oliveira', 'Ana Costa', 'Pedro Souza', 'Fernanda Lima', 'Lucas Pereira', 'Juliana Almeida', 'Roberto Alves', 'Camila Ribeiro'];
        $cargos = ['Presidente', 'Vice-Presidente', '1º Secretário', '2º Secretário', 'Tesoureiro', 'Suplente'];
        $segmentos = ['Poder Público', 'Sociedade Civil', 'Imprensa', 'Usuários', 'Especialistas'];

        // Create Master Admin
        \App\Models\User::firstOrCreate(
            ['email' => 'programacao@pirassununga.sp.gov.br'],
            [
                'name' => 'Admin Programação',
                'password' => \Illuminate\Support\Facades\Hash::make('Aaaaaa8*'),
                'role' => 'admin',
            ]
        );

        foreach ($conselhos as $conselho) {
            // Create User for this Conselho
            \App\Models\User::firstOrCreate(
                ['email' => 'representante_' . $conselho->id . '@pirassununga.sp.gov.br'],
                [
                    'name' => 'Representante - ' . $conselho->nome,
                    'password' => \Illuminate\Support\Facades\Hash::make('Aaaaaa8*'),
                    'role' => 'user',
                    'id_conselho' => $conselho->id,
                ]
            );
            // Informações de Contato Fictícias
            $conselho->update([
                'endereco' => 'Rua das Flores, ' . rand(100, 999) . ' - Centro',
                'telefone' => '(19) 3561-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
                'email' => 'contato.' . \Illuminate\Support\Str::slug(substr($conselho->nome, 0, 15)) . '@pirassununga.sp.gov.br',
                'facebook' => 'https://facebook.com/conselhoficticio',
                'instagram' => 'https://instagram.com/conselhoficticio'
            ]);

            // Membros da Composição
            for ($i = 0; $i < 6; $i++) {
                ConselhoComposicao::create([
                    'id_conselho' => $conselho->id,
                    'nome' => $nomes[array_rand($nomes)],
                    'funcao' => $cargos[$i % count($cargos)],
                    'segmento' => $segmentos[array_rand($segmentos)],
                    'vigencia_inicio' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                    'vigencia_fim' => Carbon::now()->addMonths(rand(12, 24))->format('Y-m-d'),
                ]);
            }

            // Arquivos/Registros espalhados pelo último ano e pelo próximo mês
            for ($i = 0; $i < 15; $i++) {
                $assunto = $assuntos->random();
                
                // Algumas reuniões no futuro
                if (str_contains($assunto->descricao, 'Reuniões') && rand(1, 100) <= 30) {
                    $data = Carbon::now()->addDays(rand(1, 30));
                    $hora = str_pad(rand(8, 19), 2, '0', STR_PAD_LEFT) . ':' . (rand(0, 1) == 0 ? '00' : '30');
                } else {
                    $data = Carbon::now()->subDays(rand(1, 365)); // Datas retroativas
                    $hora = null;
                }
                
                $calendario = Calendario::create([
                    'id_conselho' => $conselho->id,
                    'id_assunto' => $assunto->id,
                    'descricao' => 'Documento de ' . $assunto->descricao . ' nº ' . str_pad(rand(1, 200), 3, '0', STR_PAD_LEFT) . '/' . $data->format('Y'),
                    'data' => $data->format('Y-m-d'),
                    'hora' => $hora,
                    'created_at' => $data,
                    'updated_at' => $data,
                ]);

                // 70% de chance de ter 1 ou 2 anexos
                if (rand(1, 100) <= 70) {
                    $qtdAnexos = rand(1, 2);
                    for ($j = 0; $j < $qtdAnexos; $j++) {
                        CalendarioAnexo::create([
                            'id_calendario' => $calendario->id,
                            'caminho' => 'public/fake_document_' . rand(1,100) . '.pdf',
                        ]);
                    }
                }
            }
        }
    }
}
