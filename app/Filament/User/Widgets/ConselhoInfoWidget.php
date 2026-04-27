<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;

class ConselhoInfoWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.conselho-info-widget';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $conselho = filament()->getTenant();

        return [
            'conselho' => $conselho,
            'membros' => $conselho ? $conselho->composicoes()->where('vigencia_fim', '>=', now())->get() : [],
        ];
    }
}
