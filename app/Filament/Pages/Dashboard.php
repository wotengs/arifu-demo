<?php
 
namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected static ?int $navigationSort =4;
  
   public function filtersForm(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('startDate')
            ->placeholder('Select Year')
            ->format('Y')
            ->minDate(now()->startOfYear()->subYears(100)) // Set minimum year
            ->maxDate(now()->startOfYear()), // Set maximum year
            // ->columnSpan(1)
            // ->extraAttributes(['style' => 'text-align: right']),
        DatePicker::make('endDate')
            ->placeholder('Select Year')
            ->format('Y')
            ->minDate(now()->endOfYear()->subYears(100)) // Set minimum year
            ->maxDate(now()->endOfYear()), // Set maximum year
            // ->columnSpan(1)
            // ->extraAttributes(['style' => 'text-align: right;']),

        ]);

        
    }



 
}