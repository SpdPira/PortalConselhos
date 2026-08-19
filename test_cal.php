<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = App\Models\Conselho::find(17);
$eventos = App\Models\Calendario::with(['assunto', 'anexos'])
    ->where('id_conselho', $c->id)
    ->where('id_assunto', 7)
    ->latest(\Illuminate\Support\Facades\DB::raw('COALESCE(data, created_at)'))
    ->get()
    ->toArray();

echo json_encode($eventos);
