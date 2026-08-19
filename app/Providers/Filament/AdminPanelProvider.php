<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            //->login()
            ->font('Instrument Sans')
            ->userMenuItems([
                \Filament\Navigation\MenuItem::make()
                    ->label('Alterar Senha')
                    ->url(fn () => env('SSO_PROVIDER_URL') . '/admin/profile')
                    ->icon('heroicon-o-key'),
            ])
            ->colors([
                'primary'       => Color::Blue,
                'danger'        => Color::generateV3Palette("#880000"),
                'info'          => Color::Gray,
                'success'       => Color::generateV3Palette("#369b36ff"),
                'warning'       => Color::Orange,
            ])
            ->assets([
                \Filament\Support\Assets\Css::make('filament-custom', resource_path('css/filament.css')),
            ])
            ->favicon(asset('assets/images/logo_pirassununga.png'))
            ->brandLogo(asset('assets/images/logo_pirassununga.png'))
            ->darkModeBrandLogo(asset('assets/images/logo_pirassununga.png'))
            ->brandLogoHeight('3rem')
            ->brandName('Portal dos Conselhos')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\EnsureTermsAccepted::class,
            ]);
    }
}
