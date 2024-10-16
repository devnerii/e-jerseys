<?php

namespace App\Providers\Filament;

use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;

class GerenciamentoPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $Settings = null;
        try {
            $Settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
        } catch (Exception $e) {

        }

        return $panel
            ->default()
            ->id('gerenciamento')
            ->path('gerenciamento')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([

            ])
            ->brandLogo(
                $Settings?->site_logo ?
                    asset('storage/'.$Settings->site_logo) : null
            )
            ->favicon($Settings?->site_favicon ?
            asset('storage/'.$Settings->site_favicon) : null)
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
            ])
            ->plugins([
                FilamentGeneralSettingsPlugin::make()
                    ->canAccess(fn () => auth()->user()->id === 1)
                    ->setSort(9)
                    ->setIcon('heroicon-o-cog')
                    ->setTitle('Configurações')
                    ->setNavigationLabel('Configurações')
                    ->setNavigationGroup('Aparência'),
            ]);
    }
}
