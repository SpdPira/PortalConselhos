<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Garante consistência do redirect_uri com o host/porta atual para evitar erro de "Invalid state"
        if (!app()->runningInConsole()) {
            config(['oidc-client.auth_server.redirect_uri' => request()->schemeAndHttpHost() . '/auth/callback']);
        }

        $this->app->bind(
            \Filament\Auth\Http\Responses\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );

        \Filament\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::HEAD_END,
            fn (): string => '<style>
                .fi-body,
                .fi-layout,
                .fi-main,
                .fi-app-layout,
                .fi-simple-layout,
                .fi-simple-page,
                .fi-main-ctn {
                    background-color: transparent !important;
                }
                .fi-layout {
                    position: relative !important;
                    z-index: 10 !important;
                }
                .fi-modal {
                    z-index: 99999 !important;
                }
                html {
                    background-color: #f1f5f9; /* f1f5f9 */
                }
                html.dark {
                    background-color: #1f1849; /*  */
                }
                /* Sobrescrever fundos e elementos no tema claro do Filament para escurecê-los com elegância */
                html:not(.dark) .blob-1 {
                    position: fixed;
                    top: 5%;
                    left: 5%;
                    width: 70%;
                    height: 80% !important;
                    border-radius: 9999px;
                    background-color: rgba(225, 225, 255); /* azul acinzentado */
                    filter: blur(130px);
                }
                html:not(.dark) .blob-2 {
                    position: fixed;
                    bottom: 0;
                    right: 5%;
                    width: 95%;
                    height: 50% !important;
                    border-radius: 9999px;
                    background-color: rgb(206, 206, 236); /* azul acinzentado */
                    filter: blur(130px);
                }
                html:not(.dark) .blob-3 {
                    position: fixed;
                    top: 5%;
                    right: 5%;
                    width: 70%;
                    height: 70% !important;
                    border-radius: 9999px;
                    background-color: rgb(225, 225, 225); /* cinza */
                    filter: blur(120px);
                }
                html:not(.dark) .fi-sidebar {
                    background-color: #314269 !important; /* Sidebar Slate 900 314269 */
                }
                html:not(.dark) .fi-sidebar-header {
                    border-bottom: 1px solid #eaedf3 !important; /* eaedf3 ñ muda nada */
                }

                html:not(.dark) .fi-sidebar-group-label {
                    color: #64748b !important; /* 64748b ñ muda nada */
                }
                html:not(.dark) .fi-main-sidebar,
                html:not(.dark) .fi-sidebar-open,
                html:not(.dark) .fi-sidebar {
                    height: 90vh !important;
                }
                html:not(.dark) .fi-main-sidebar,
                html:not(.dark) .fi-sidebar-open,
                html:not(.dark) .fi-sidebar-nav,
                html:not(.dark) .fi-sidebar-nav-groups,
                html:not(.dark) .fi-sidebar-group,
                html:not(.dark) .fi-collapsible,
                html:not(.dark) .fi-sidebar-group-items,
                html:not(.dark) .fi-sidebar-item,
                html:not(.dark) .fi-sidebar-item-btn,
                html:not(.dark) .fi-sidebar-item-has-url,
                html:not(.dark) .fi-active {
                    background-color: transparent !important; /* 64748b */
                }
                /* Ítens inativos (Normal) */
                html:not(.dark) .fi-sidebar-item-label {
                    color: #000000 !important;
                    font-weight: normal !important;
                }
                html:not(.dark) .fi-sidebar-item-icon {
                    color: #000000 !important;
                }
                
                /* Ítens ativos */
                html:not(.dark) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
                html:not(.dark) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
                html:not(.dark) .fi-sidebar-item-button[aria-current="page"] .fi-sidebar-item-label,
                html:not(.dark) .fi-sidebar-item-button[aria-current="page"] .fi-sidebar-item-icon {
                    color: blue !important; /* Azul */
                }

                /* Hover (Inativos) */
                html:not(.dark) .fi-sidebar-item-button:hover,
                html:not(.dark) .fi-sidebar-item-btn:hover {
                    background-color: #1f2d4d !important;
                }
                html:not(.dark) .fi-sidebar-item-button:hover .fi-sidebar-item-label,
                html:not(.dark) .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
                html:not(.dark) .fi-sidebar-item-btn:hover .fi-sidebar-item-label,
                html:not(.dark) .fi-sidebar-item-btn:hover .fi-sidebar-item-icon {
                    color: #ffffff !important;
                }

                /* Hover (Ativos) */
                html:not(.dark) .fi-sidebar-item.fi-active .fi-sidebar-item-button:hover .fi-sidebar-item-label,
                html:not(.dark) .fi-sidebar-item-button[aria-current="page"]:hover .fi-sidebar-item-label {
                    color: #ffffff !important;
                    font-weight: bold !important;
                }
                html:not(.dark) .fi-sidebar-item.fi-active .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
                html:not(.dark) .fi-sidebar-item-button[aria-current="page"]:hover .fi-sidebar-item-icon {
                    color: #ffffff !important;
                    stroke-width: 2.5 !important;
                }

                html:not(.dark) .fi-topbar {
                    background-color: #2f4b86 !important; /* Topbar Slate 900 */ /*  */
                    border-bottom: 1px solid #41587e !important; /*  */
                }
                html:not(.dark) .fi-section,
                html:not(.dark) .fi-ta-container,
                html:not(.dark) .fi-modal-window,
                html:not(.dark) .fi-fo-repeater-item,
                html:not(.dark) .fi-fo-repeater-item-has-header,
                /* html:not(.dark) .fi-simple-main, /* Adicionado o card central de Login/Profile */
                html:not(.dark) .fi-dropdown-panel {
                    background-color: #c4d2e6 !important; /* Cartões e Modais Slate 800 */ /* c4d2e6 */
                    border: 1px solid rgba(255, 255, 255, 0.1) !important; /*  */
                }

                html:not(.dark) .btn-conselho-info:hover {
                    background-color: #000066 !important;
                }

                html:not(.dark) .fi-btn.fi-color-primary {
                    background-color: #4668b9 !important;
                    color: #000000 !important; /*  */
                }
                html:not(.dark) .fi-btn.fi-color-primary:hover {
                    background-color: #4668b9 !important;
                    color: #ffffff !important; /*  */
                }
                html:not(.dark) .fi-btn:hover {
                    background-color: #7893d1 !important;
                    color: #ffffff !important; /*  */
                }
                html:not(.dark) .fi-ac-btn-action {
                    background-color: #7893d1 !important;
                    color: #000000 !important; /*  */
                }

                html:not(.dark) .fi-section-content-ctn,
                html:not(.dark) .fi-modal-content {
                    background-color: transparent !important; /* Cartões e Modais Slate 800 */ /* c4d2e6 */
                }
                html:not(.dark) thead tr {
                    background-color: #7893d1 !important;
                }

                /* --- Firefox --- */
                html:not(.dark) {
                    /* scrollbar-color: [cor-do-thumb] [cor-do-track] */
                    scrollbar-color: #000000 #7893d1 !important;
                    scrollbar-width: thin !important;
                }
                /* --- Chrome, Edge, Safari (WebKit) --- */
                /* 1. Ativa a scrollbar personalizada e define sua largura/altura */
                html:not(.dark) ::-webkit-scrollbar {
                    width: 10px !important;  /* Largura para scrollbar vertical */
                    height: 10px !important; /* Altura para scrollbar horizontal */
                }
                /* 2. O trilho (fundo da barra de rolagem) */
                html:not(.dark) ::-webkit-scrollbar-track {
                    background-color: #7893d1 !important;
                    border-radius: 4px !important; /* Opcional: cantos arredondados */
                }
                /* 3. O botão de arrastar (thumb) */
                html:not(.dark) ::-webkit-scrollbar-thumb {
                    background-color: #000000 !important;
                    border-radius: 6px !important; /* Deixa o botão arredondado e elegante */
                    border: 2px solid #7893d1 !important; /* Opcional: cria uma borda para dar respiro */
                }
                /* 4. Efeito de hover no botão de arrastar (opcional) */
                html:not(.dark) ::-webkit-scrollbar-thumb:hover {
                    background-color: #272727 !important; /* Escurece um pouco ao passar o mouse */
                }


                html:not(.dark) .fi-ta-ctn,
                html:not(.dark) .fi-ta-ctn-with-footer,
                html:not(.dark) .fi-ta-ctn-with-header {
                    background-color: #c4d2e6 !important; /* Cartões e Modais Slate 800 */ /* c4d2e6 */
                }
                html:not(.dark) svg.fi-icon.fi-size-md {
                    color: #000000 !important; /*  */
                }

                html:not(.dark) .fi-input-wrp {
                    background-color: #c4d2e6 !important; /* Inputs Slate 900 */ /* c4d2e6 */
                    border-color: rgba(255, 255, 255, 0.15) !important; /*  */
                }
                html:not(.dark) input,
                html:not(.dark) select,
                html:not(.dark) textarea {
                    color: #000000 !important;
                }
                html:not(.dark) input::placeholder,
                html:not(.dark) textarea::placeholder {
                    color: #334155 !important;
                    opacity: 1 !important;
                }
                /* Ajustar cores de textos no tema claro escurecido do Filament */
                html:not(.dark) .text-gray-950,
                html:not(.dark) .text-gray-900,
                html:not(.dark) .text-gray-800,
                html:not(.dark) .text-gray-700,
                html:not(.dark) .text-gray-600 {
                    color: #f8fafc !important; /* Slate 50 */ /*  */
                }
                html:not(.dark) .text-gray-500,
                html:not(.dark) .text-gray-400 {
                    color: #cbd5e1 !important; /* Slate 300 */ /*  */
                }
                /* Divisores de tabelas e listas */
                html:not(.dark) .border-gray-200,
                html:not(.dark) .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
                    border-color: rgba(255, 255, 255, 0.1) !important; /*  */
                }
                html:not(.dark) .fi-ta-cell,
                html:not(.dark) .fi-ta-header-cell {
                    border-top: 1px solid rgba(255, 255, 255, 0.1) !important; /*  */
                }
                /* Centralizar textos do FileUpload (FilePond) em aspect ratios de menor altura (ex: 16:1) */
                .filepond--drop-label label {
                    min-height: unset !important;
                }
                .filepond--root .filepond--drop-label {
                    background-color: #c4d2e6 !important;
                    position: absolute !important;
                    inset: 0 !important;
                    transform: none !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    text-align: center !important;
                }
            </style>',
        );

        \Filament\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::BODY_START,
            fn (): string => '
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <!-- degradê do tema claro -->
                <div class="fixed dark:hidden w-full h-full overflow-hidden inset-0">
                    <div class="blob-1"></div>
                    <div class="blob-3"></div>
                    <div class="blob-2"></div>
                </div>
                <!-- degradê do tema escuro original -->
                <div class="hidden dark:block">
                    <div class="absolute -top-[40%] -left-[20%] w-[80%] h-[80%] rounded-full bg-blue-800/30 blur-[120px]"></div>
                    <div class="absolute -bottom-[40%] -right-[20%] w-[80%] h-[80%] rounded-full bg-indigo-900/30 blur-[120px]"></div>
                </div>
            </div>
            ',
        );

        Filament::serving(function () {
            app()
                ->setLocale('pt_BR');
            $titleHtml =
                '<div style="margin-inline-start: -100%; margin-inline-end: auto; font-size: 20px; color: white; font-weight: bold;">' .  //margin-inline-end: calc(var(--spacing) * 105);
                    '<span>Portal dos Conselhos - Prefeitura de Pirassununga</span>' .
                '</div>';

            Filament::registerRenderHook('panels::global-search.before', fn() => $titleHtml);

        });

        \Filament\Forms\Components\FileUpload::configureUsing(function (\Filament\Forms\Components\FileUpload $component) {
            $component
                //->placeholder('Arraste e solte os arquivos ou Clique aqui')
                ->panelLayout('integrated')
                ->panelAspectRatio('13:1');
        });

        \App\Models\Calendario::observe(\App\Observers\CalendarioObserver::class);
        \App\Models\CalendarioAnexo::observe(\App\Observers\CalendarioAnexoObserver::class);
    }
}
