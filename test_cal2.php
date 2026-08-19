<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$eventos = App\Models\Calendario::where('id_conselho', 14)->where('id_assunto', 7)->get()->toArray();

echo json_encode($eventos);
