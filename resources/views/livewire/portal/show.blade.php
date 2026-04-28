<div class="space-y-8 pb-12">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-8 flex flex-col md:flex-row items-center md:items-start gap-6">
        <div class="w-32 h-32 flex-shrink-0 bg-zinc-100 rounded flex items-center justify-center border border-zinc-300">
            @if($conselho->logotipo)
                <img src="{{ Storage::url($conselho->logotipo) }}" alt="Logo {{ $conselho->nome }}" class="max-w-full max-h-full object-contain">
            @else
                <span class="text-4xl font-bold text-zinc-400">
                    {{ collect(explode(' ', $conselho->nome))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(3)->implode('') }}
                </span>
            @endif
        </div>
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-3xl font-bold text-zinc-900 mb-4">{{ $conselho->nome }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-zinc-600 text-sm">
                @if($conselho->endereco)
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>{{ $conselho->endereco }}</span>
                    </div>
                @endif
                @if($conselho->telefone)
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>{{ $conselho->telefone }}</span>
                    </div>
                @endif
                @if($conselho->email)
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ $conselho->email }}</span>
                    </div>
                @endif
                @if($conselho->facebook || $conselho->instagram)
                    <div class="flex items-start gap-4">
                        @if($conselho->facebook)
                            <a href="{{ $conselho->facebook }}" target="_blank" class="text-primary hover:text-danger flex items-center gap-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.733 0-1.325.593-1.325 1.326v21.348c0 .733.593 1.326 1.325 1.326h11.495v-9.294h-3.128v-3.622h3.128v-2.672c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.466.099 2.797.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.591l-.467 3.622h-3.124v9.294h6.116c.73 0 1.323-.593 1.323-1.326v-21.348c0-.733-.593-1.326-1.324-1.326z"></path></svg>
                                Facebook
                            </a>
                        @endif
                        @if($conselho->instagram)
                            <a href="{{ $conselho->instagram }}" target="_blank" class="text-primary hover:text-danger flex items-center gap-1">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3h-8.5zm10.71-.21a1.08 1.08 0 11-2.16-.002c0 .597.483 1.08 1.08 1.08s1.08-.483 1.08-1.08zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 1.5a3.5 3.5 0 100 7A3.5 3.5 0 0012 8z"></path></svg>
                                Instagram
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Composição -->
    @if($conselho->composicoes->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-8">
        @php
            $membrosAtivos = $conselho->composicoes->filter(function($membro) {
                if (!$membro->vigencia_fim) return true;
                return \Carbon\Carbon::parse($membro->vigencia_fim)->isFuture();
            })->sortBy('nome');
            
            $membrosInativos = $conselho->composicoes->diff($membrosAtivos)->sortByDesc('vigencia_fim');
        @endphp

        <h3 class="text-xl font-bold text-zinc-800 mb-6 border-b border-zinc-100 pb-2">Composição Atual</h3>
        
        @if($membrosAtivos->count() > 0)
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($membrosAtivos as $membro)
                    <li class="bg-zinc-50 p-4 rounded border border-zinc-200 shadow-sm flex flex-col gap-1 hover:border-primary transition-colors">
                        <p class="font-bold text-primary text-base uppercase">{{ $membro->nome }}</p>
                        @if($membro->funcao)
                            <p class="text-sm font-semibold text-zinc-700">{{ $membro->funcao }}</p>
                        @endif
                        @if($membro->vigencia_inicio && $membro->vigencia_fim)
                            <p class="text-xs text-zinc-500">Vigência: {{ \Carbon\Carbon::parse($membro->vigencia_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($membro->vigencia_fim)->format('d/m/Y') }}</p>
                        @endif
                        @if($membro->segmento)
                            <p class="text-xs font-medium text-zinc-400 mt-2 uppercase tracking-wide border-t border-zinc-200 pt-2">{{ $membro->segmento }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-zinc-500 italic">Nenhum membro ativo no momento.</p>
        @endif

        @if($membrosAtivos->count() === 0)
            <p class="text-zinc-500 italic">Nenhum membro ativo no momento.</p>
        @endif
    </div>
    @endif

    <!-- Calendário de Eventos -->
    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-8 mb-8">
        <div class="flex items-center justify-between mb-6 border-b border-zinc-100 pb-4">
            <h3 class="text-xl font-bold text-zinc-800">Calendário de Atividades</h3>
            <div class="flex items-center gap-4">
                <button wire:click="prevMonth" class="p-2 rounded bg-primary hover:bg-danger text-white transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="text-lg font-semibold text-primary capitalize w-40 text-center">
                    {{ \Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, 1)->translatedFormat('F Y') }}
                </span>
                <button wire:click="nextMonth" class="p-2 rounded bg-primary hover:bg-danger text-white transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
<div class="w-[77%] mx-auto">
        <div class="grid grid-cols-7 gap-px bg-zinc-200 border border-zinc-200 rounded-lg overflow-hidden">
            <!-- Dias da Semana -->
            @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $diaSemana)
                <div class="bg-zinc-50 p-0 text-center text-[9px] sm:text-[9px] font-semibold text-zinc-500 uppercase tracking-wider">
                    {{ $diaSemana }}
                </div>
            @endforeach

            <!-- Dias do Mês -->
            @foreach($this->calendarDays as $day)
                <div class="bg-white h-14 sm:h-14 p-1 flex flex-col relative {{ $day['empty'] ? 'opacity-40 bg-zinc-50' : '' }} {{ isset($day['isToday']) && $day['isToday'] ? 'ring-2 ring-inset ring-primary bg-red-50/10' : '' }}">
                    @if(!$day['empty'])
                        <!-- Número do dia -->
                        <span class="text-[9px] mt-[-4px] me-[-4px] sm:text-[9px] font-bold self-end mb-0 shrink-0 {{ isset($day['isToday']) && $day['isToday'] ? 'text-white bg-primary w-5 h-5 flex items-center justify-center rounded-full' : 'text-zinc-600' }}">
                            {{ $day['day'] }}
                        </span>
                        
                        <!-- Eventos -->
                        <div class="flex-1 overflow-y-auto custom-scrollbar text-center">
                            @foreach($day['events'] as $evento)
                                @php
                                    $assuntoNome = mb_strtolower($evento->assunto->descricao);
                                    $bgColor = 'bg-zinc-100 text-zinc-700 border-zinc-200'; // Default cinza
                                    
                                    if (str_contains($assuntoNome, 'reunião') || str_contains($assuntoNome, 'reuniao')) {
                                        $bgColor = 'bg-red-100 text-red-800 border-red-200'; // Primary/Vermelho
                                    } elseif (str_contains($assuntoNome, 'pauta')) {
                                        $bgColor = 'bg-emerald-100 text-emerald-800 border-emerald-200'; // Verde
                                    } elseif (str_contains($assuntoNome, 'resoluç')) {
                                        $bgColor = 'bg-amber-100 text-amber-800 border-amber-200'; // Laranja
                                    }
                                @endphp
                                <div class="text-[9px] text-center sm:text-[9px] p-0 rounded border {{ $bgColor }} leading-snug cursor-help break-words" title="{{ $evento->descricao }}">
                                    @if($evento->hora)
                                        <span class="font-bold flex justify-center items-center">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($evento->hora)->format('H:i') }}
                                        </span>
                                    @endif
                                    <span class="font-medium block leading-tight">
                                        {{ str_replace(['Reuniões Ordinárias', 'Reuniões Extraordinárias'], ['Reunião Ordinária', 'Reunião Extraordinária'], $evento->assunto->descricao) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

    <!-- Arquivos e Registros (Filtros de Tabela Antigos) -->
    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-8">
        <h3 class="text-xl font-bold text-zinc-800 mb-6 border-b border-zinc-100 pb-2">Buscar Arquivos e Registros Anteriores</h3>
        
        <!-- Filtros (Livewire) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 bg-zinc-50 p-4 rounded border border-zinc-200">
            <div>
                <label for="assunto" class="block text-sm font-medium text-zinc-700 mb-1">Assunto</label>
                <select wire:model.live="assunto_id" id="assunto" class="w-full rounded-md border-zinc-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-zinc-800 p-2 border">
                    <option value="">Todos</option>
                    <option value="ex-membros" class="font-bold text-primary italic">-- EX-MEMBROS --</option>
                    @foreach($assuntos as $assunto)
                        <option value="{{ $assunto->id }}">{{ $assunto->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="ano" class="block text-sm font-medium text-zinc-700 mb-1">Ano</label>
                <select wire:model.live="ano" id="ano" class="w-full rounded-md border-zinc-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-zinc-800 p-2 border">
                    <option value="">Todos</option>
                    @foreach($anosDisponiveis as $a)
                        <option value="{{ $a }}">{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="mes" class="block text-sm font-medium text-zinc-700 mb-1">Mês</label>
                <select wire:model.live="mes" id="mes" class="w-full rounded-md border-zinc-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-zinc-800 p-2 border">
                    <option value="">Todos</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Lista -->
        <div class="relative min-h-[100px]">
            <div wire:loading.delay class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>

            @php
                $icones = [
                    'Legislação' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>',
                    'Pautas' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>',
                    'Atas' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
                    'Resoluções' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    'Recomendações' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    'Reuniões Ordinárias' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
                    'Reuniões Extraordinárias' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    'Ex-Membros' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>'
                ];
                $defaultIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>';
            @endphp

            <div class="overflow-x-auto border border-zinc-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-100 text-zinc-700 text-sm font-semibold border-b border-zinc-200">
                            <th class="p-4 w-32">Data</th>
                            <th class="p-4 w-48">Assunto</th>
                            <th class="p-4">Descrição</th>
                            <th class="p-4 w-40 text-center">Anexos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white">
                        @forelse($calendarios as $calendario)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="p-4 text-sm text-zinc-600 font-medium whitespace-nowrap">
                                    {{ $calendario->created_at->format('d/m/Y') }}
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded bg-zinc-100 flex items-center justify-center text-primary flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $icones[$calendario->assunto->descricao] ?? $defaultIcon !!}
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold uppercase tracking-wider text-primary truncate">
                                            {{ $calendario->assunto->descricao }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-zinc-800">
                                    {{ $calendario->descricao ?: 'Registro' }}
                                </td>
                                <td class="p-4">
                                    @if($calendario->anexos->count() > 0)
                                        <div class="flex flex-col gap-1">
                                            @foreach($calendario->anexos as $anexo)
                                                <a href="{{ Storage::url($anexo->caminho) }}" target="_blank" class="inline-flex items-center justify-center gap-1 text-xs text-white bg-primary hover:bg-danger px-2 py-1.5 border border-primary rounded shadow-sm w-full transition-colors" title="Ver Anexo">
                                                    <svg class="w-3.5 h-3.5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    <span>Baixar</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-xs text-zinc-400 italic text-center">
                                            Sem anexos
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-zinc-500 bg-zinc-50">
                                    Nenhum registro encontrado para os filtros selecionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
