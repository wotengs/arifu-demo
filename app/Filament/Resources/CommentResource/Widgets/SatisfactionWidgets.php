<?php
namespace App\Filament\Resources\CommentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Satisfactions;
use Illuminate\Support\Facades\DB;

class SatisfactionWidgets extends BaseWidget
{

       protected function getCards(): array
    {
        $startOfMonth = now()->subMonth()->startOfMonth();
        $endOfMonth = now();

        return [
            Stat::make('Very Satisfied', Satisfactions::where('satisfaction_level', 1)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count())
                ->description('A Month Ago From Now')
                ->descriptionIcon('heroicon-o-face-smile'),
                
            Stat::make('A little satisfied', Satisfactions::where('satisfaction_level', 2)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count())
                ->description('A Month Ago From Now')
                ->descriptionIcon('heroicon-o-face-smile'),

            Stat::make('Not so satisfied', Satisfactions::where('satisfaction_level', 3)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count())
                ->description('A Month Ago From Now')
                ->descriptionIcon('heroicon-o-face-frown'),

            Stat::make('Not at all satisfied', Satisfactions::where('satisfaction_level', 4)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count())
                ->description('A Month Ago From Now')
                ->descriptionIcon('heroicon-o-face-frown'),
        ];
    }
}
