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

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            //->login()
            ->userMenuItems([
                \Filament\Navigation\MenuItem::make()
                    ->label('Alterar Senha')
                    ->url(fn () => env('SSO_PROVIDER_URL') . '/admin/profile')
                    ->icon('heroicon-o-key'),
            ])
            ->tenant(\App\Models\Conselho::class)
            ->tenantProfile(\App\Filament\User\Pages\Tenancy\EditConselhoProfile::class)
            ->font('Instrument Sans')
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
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->widgets([
                \App\Filament\User\Widgets\ConselhoInfoWidget::class,
                //AccountWidget::class,
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
