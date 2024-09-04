<?php


namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Filament\Resources\CommentResource\Widgets\SatisfactionWidgets;
use App\Filament\Resources\ProgramResource\Widgets\LearnersInProgramWidget;
use Filament\Forms\Components\DatePicker;

class ProgramsAnalytics extends Page
{
    use HasFiltersForm;

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
            SatisfactionWidgets::class,
            LearnersInProgramWidget::class,
        ];
    }

 
}
