<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ConselhoInfoWidget extends Widget
{
    protected string $view = 'filament.user.widgets.conselho-info-widget';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // enviar dados do usuário para o widget
        $user = Auth::user();

        $conselho = filament()->getTenant();
        
        if (!$conselho) {
            return [
                'conselho' => null,
                'membrosAtivos' => collect(),
                'membrosInativos' => collect(),
            ];
        }

        $membrosAtivos = $conselho->composicoes->filter(function($membro) {
            if (!$membro->vigencia_fim) return true;
            return \Carbon\Carbon::parse($membro->vigencia_fim)->endOfDay()->isFuture();
        })->sortBy('nome');
        
        $membrosInativos = $conselho->composicoes->diff($membrosAtivos)->sortByDesc('vigencia_fim');

        return [
            'user' => $user,
            'conselho' => $conselho,
            'membrosAtivos' => $membrosAtivos,
            'membrosInativos' => $membrosInativos,
        ];
    }
}
