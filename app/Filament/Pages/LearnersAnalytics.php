<?php

namespace App\Filament\Pages;

use App\Filament\Resources\LearnersResource\Widgets\TotalnActiveLearnersChartWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;

class LearnersAnalytics extends Page
{

    use HasFiltersForm;
    
    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'Learners Dashboard';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.learners-analytics';

    public static function getNavigationLabel(): string
    {
        return 'Learners Analytics';
    }


    public static function shouldRegisterNavigation(): bool
    {
        return true;  // Ensure this returns true to show in navigation
    }

    
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('startDate')
                ->placeholder('Select Year')
                ->format('Y')
                ->minDate(now()->startOfYear()->subYears(100))
                ->maxDate(now()->startOfYear()),
            DatePicker::make('endDate')
                ->placeholder('Select Year')
                ->format('Y')
                ->minDate(now()->endOfYear()->subYears(100))
                ->maxDate(now()->endOfYear()),
        ]);
    }

    protected function getfooterWidgets(): array
    {
        return [
            TotalnActiveLearnersChartWidget::class,
        ];
    }



}
