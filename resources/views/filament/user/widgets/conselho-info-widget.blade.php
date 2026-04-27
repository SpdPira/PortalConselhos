<x-filament-widgets::widget>
    <x-filament::section>
        @if($conselho)
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <div class="w-32 h-32 rounded bg-zinc-50 border border-zinc-200 flex items-center justify-center p-2 shrink-0">
                    @if($conselho->logotipo)
                        <img src="{{ Storage::url($conselho->logotipo) }}" class="max-w-full max-h-full object-contain">
                    @else
                        <span class="text-zinc-400 text-sm text-center">Sem logotipo</span>
                    @endif
                </div>
                
                <div class="flex-1 space-y-4">
                    <div>
                        <h2 class="text-2xl font-bold text-primary">{{ $conselho->nome }}</h2>
                        <p class="text-zinc-600 mt-1 text-sm">{{ $conselho->descricao }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-zinc-50 p-4 rounded border border-zinc-100">
                        <div><strong class="text-zinc-900 block mb-1">Endereço:</strong> {{ $conselho->endereco ?: 'Não informado' }}</div>
                        <div><strong class="text-zinc-900 block mb-1">Telefone:</strong> {{ $conselho->telefone ?: 'Não informado' }}</div>
                        <div><strong class="text-zinc-900 block mb-1">E-mail:</strong> {{ $conselho->email ?: 'Não informado' }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-bold text-zinc-800 mb-4 border-b border-zinc-200 pb-2">Diretoria Atual</h3>
                @if(count($membros) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($membros as $membro)
                            <div class="p-4 border border-zinc-200 rounded-lg bg-white shadow-sm hover:border-primary transition-colors">
                                <div class="font-bold text-zinc-900">{{ $membro->nome }}</div>
                                <div class="text-sm font-semibold text-primary mt-1">{{ $membro->funcao }}</div>
                                <div class="text-xs text-zinc-500 mt-2 flex justify-between">
                                    <span>{{ $membro->segmento }}</span>
                                    <span>{{ \Carbon\Carbon::parse($membro->vigencia_fim)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 italic">Nenhum membro da diretoria atual encontrado.</p>
                @endif
            </div>
        @else
            <div class="p-4 text-center text-zinc-500">
                Nenhum conselho vinculado ao seu usuário.
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
