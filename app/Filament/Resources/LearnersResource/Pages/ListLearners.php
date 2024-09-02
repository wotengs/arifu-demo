<?php

namespace App\Filament\Resources\LearnersResource\Pages;


use App\Filament\Resources\LearnersResource;
use App\Filament\Resources\LearnersResource\Widgets\LearnersAnalyticsWidgets;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLearners extends ListRecords
{
    protected static string $resource = LearnersResource::class;

    protected function getHeaderWidgets(): array
    {
        
        return [
            LearnersAnalyticsWidgets::class,
         ];
    }
}
