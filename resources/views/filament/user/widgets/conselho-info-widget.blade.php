<x-filament-widgets::widget>
    @if($conselho)
        <div style="display: flex; flex-direction: column; gap: 1.5rem; font-family: sans-serif; margin-bottom: 2rem; border-bottom: 1px solid #e4e4e7; padding-bottom: 2rem; --tw-space-y-reverse: 0;
        margin-block-start: calc(calc(var(--spacing) * 8) /* 2rem = 32px */ * var(--tw-space-y-reverse));
        margin-block-end: calc(calc(var(--spacing) * 8) /* 2rem = 32px */ * calc(1 - var(--tw-space-y-reverse)));">
            <!-- converter space-y-8 para css puro -->
            
            <!-- Card de Cabeçalho -->
            <div style="background-color: #ffffff; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border: 1px solid #e4e4e7; padding: 2rem; display: flex; flex-wrap: wrap; align-items: flex-start; gap: 1.5rem;">
                
                <!-- Logo -->
                <div style="width: 9rem; height: 9rem; flex-shrink: 0; background-color: #fafafa; border-radius: 0.5rem; border: 1px solid #e4e4e7; display: flex; align-items: center; justify-content: center; padding: 0.5rem; overflow: hidden;">
                    @if($conselho->logotipo)
                        <img src="{{ Storage::url($conselho->logotipo) }}" alt="Logo {{ $conselho->nome }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @else
                        <span style="font-size: 2.25rem; font-weight: 700; color: #d4d4d8;">
                            {{ collect(explode(' ', $conselho->nome))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(3)->implode('') }}
                        </span>
                    @endif
                </div>

                <!-- Info -->
                <div style="flex: 1; min-width: 250px;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #18181b; margin: 0 0 1rem 0; line-height: 1.2;">{{ $conselho->nome }}</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <!-- Row 1: Address and Phone -->
                        <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">
                            @if($conselho->endereco)
                                <div style="display: flex; align-items: center; gap: 1rem; color: #3f3f46;">
                                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: #fef2f2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span style="font-size: 0.875rem; font-weight: 500;">{{ $conselho->endereco }}</span>
                                </div>
                            @endif

                            @if($conselho->telefone)
                                <div style="display: flex; align-items: center; gap: 1rem; color: #3f3f46;">
                                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: #fef2f2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <span style="font-size: 0.875rem; font-weight: 500;">{{ $conselho->telefone }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Row 2: Email and Socials -->
                        <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center;">
                            @if($conselho->email)
                                <div style="display: flex; align-items: center; gap: 1rem; color: #3f3f46;">
                                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; background-color: #fef2f2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span style="font-size: 0.875rem; font-weight: 500;">{{ $conselho->email }}</span>
                                </div>
                            @endif

                            <div style="display: flex; align-items: center; gap: 2.5rem;">
                                @if($conselho->facebook)
                                    <a href="{{ $conselho->facebook }}" target="_blank" style="color: #b00e0b; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 2px solid transparent; transition: border-color 0.2s;">
                                        <!-- logotipo do facebook -->
                                         <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.733 0-1.325.593-1.325 1.326v21.348c0 .733.593 1.326 1.325 1.326h11.495v-9.294h-3.128v-3.622h3.128v-2.672c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.466.099 2.797.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.591l-.467 3.622h-3.124v9.294h6.116c.73 0 1.323-.593 1.323-1.326v-21.348c0-.733-.593-1.326-1.324-1.326z"></path></svg>    
                                        Facebook
                                    </a>
                                @endif
                                @if($conselho->instagram)
                                    <a href="{{ $conselho->instagram }}" target="_blank" style="color: #b00e0b; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 2px solid transparent; transition: border-color 0.2s;">
                                        <!-- logotipo do instagram -->
                                        <svg style="width: 1.25rem; height: 1.25rem; color: #b00e0b;" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3h-8.5zm10.71-.21a1.08 1.08 0 11-2.16-.002c0 .597.483 1.08 1.08 1.08s1.08-.483 1.08-1.08zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 1.5a3.5 3.5 0 100 7A3.5 3.5 0 0012 8z"></path></svg>
                                        Instagram
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Composição -->
            <div style="background-color: #ffffff; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border: 1px solid #e4e4e7; padding: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 650; color: #27272a; margin: 0 0 2rem 0;">Composição Atual</h3>
                
                @if($membrosAtivos->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                        @foreach($membrosAtivos as $membro)
                            <div style="background-color: rgba(250, 250, 250, 0.5); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #f4f4f5; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; transition: border-color 0.2s;">
                                <p style="font-weight: 700; color: #b00e0b; font-size: 1rem; text-transform: uppercase; margin: 0 0 0.25rem 0; line-height: 1.2;">{{ $membro->nome }}</p>
                                
                                <p style="font-size: 0.875rem; font-weight: 600; color: oklch(37% 0.013 285.805); margin: 0 0 0.25rem 0;">{{ $membro->funcao ?: 'Membro' }}</p>
                                
                                @if($membro->vigencia_inicio && $membro->vigencia_fim)
                                    <p style="font-size: 10px; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: -0.025em; margin: 0; padding-bottom: 0.2rem;">
                                        Vigência: {{ \Carbon\Carbon::parse($membro->vigencia_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($membro->vigencia_fim)->format('d/m/Y') }}
                                    </p>
                                @endif
                                
                                    <p style="font-size: 11px; font-weight: 500; color: #9f9fa9; text-transform: uppercase; letter-spacing: 0.1em; margin: 0; border-top-style: var(--tw-border-style); border-top-width: 1px; border-color: #e4e4e7; padding-top: 0.2rem;">
                                        {{ $membro->segmento ?: 'Não informado' }}
                                    </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="background-color: #fafafa; padding: 1.5rem; border-radius: 0.5rem; border: 1px dashed #d4d4d8; text-align: center; color: #71717a; font-style: italic;">
                        Nenhum membro ativo cadastrado no momento.
                    </div>
                @endif

                @if($membrosInativos->count() > 0)
                    <div style="margin-top: 2.5rem; border-top: 1px solid #f4f4f5; padding-top: 1.5rem;">
                         <p style="font-size: 0.75rem; font-weight: 700; color: #a1a1aa; margin-bottom: 1rem; text-transform: uppercase;">Histórico de Membros Anteriores</p>
                         <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; opacity: 0.6;">
                            @foreach($membrosInativos as $membro)
                                <div style="background-color: rgba(250, 250, 250, 0.5); padding: 1.25rem; border-radius: 0.5rem; border: 1px solid #e4e4e7; display: flex; flex-direction: column; gap: 0.25rem;">
                                    <p style="font-weight: 700; color: #52525b; font-size: 1rem; text-transform: uppercase; margin: 0;">{{ $membro->nome }}</p>
                                    <p style="font-size: 0.875rem; font-weight: 600; color: #71717a; margin: 0;">{{ $membro->funcao }}</p>
                                    <p style="font-size: 10px; color: #a1a1aa; text-transform: uppercase; margin: 0;">
                                        Vigência: {{ \Carbon\Carbon::parse($membro->vigencia_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($membro->vigencia_fim)->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div style="background-color: #ffffff; border-radius: 0.75rem; padding: 3rem; text-align: center; border: 1px dashed #d4d4d8;">
            <p style="color: #71717a; font-weight: 500;">Nenhum conselho vinculado ao seu usuário.</p>
        </div>
    @endif
</x-filament-widgets::widget>
