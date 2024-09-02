<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ProgramsAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'Program Dashboard';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.programs-analytics';

    public static function getNavigationLabel(): string
    {
        return 'Programs Analytics';
    }


    public static function shouldRegisterNavigation(): bool
    {
        return true;  // Ensure this returns true to show in navigation
    }
}
