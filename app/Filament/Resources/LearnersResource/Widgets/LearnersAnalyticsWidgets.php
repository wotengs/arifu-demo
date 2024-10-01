<?php

namespace App\Filament\Resources\LearnersResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Learners;
use Illuminate\Support\Facades\DB;

class LearnersAnalyticsWidgets extends BaseWidget
{

    //protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now();

        return [
            Stat::make('Total Learners', Learners::count()) // Corrected usage
                ->description('Subscribed')
                ->descriptionIcon('heroicon-o-users'),

            Stat::make('New Learners', Learners::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count()) // Corrected query
                ->description('This Month')
                ->descriptionIcon('heroicon-o-user-group'),
        ];
    }
}
