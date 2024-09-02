<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LearnersAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'Learners Dashboard';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.learners-analytics';

    public static function getNavigationLabel(): string
    {
        return 'Learners Analytics';
    }


    public static function shouldRegisterNavigation(): bool
    {
        return true;  // Ensure this returns true to show in navigation
    }
}
