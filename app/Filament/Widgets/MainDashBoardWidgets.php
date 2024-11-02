<?php

namespace App\Filament\Widgets;

use App\Models\Learners;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use function Livewire\before;

class MainDashBoardWidgets extends BaseWidget
{

  use InteractsWithPageFilters;

  protected static ?int $sort = 1;

    protected function getStats(): array
    {

            $start = $this->filters['startDate'];
            $end = $this->filters['endDate'];

//dd($this->filters['startDate']);

        return [
          Stat::make('New learners Last Month', Learners:: when($start,
          fn($query) => $query -> whereDate('created_at', '>',$start))
          ->
          when($end,
          fn($query) => $query -> whereDate('created_at', '<=',$end))

          ->count() )
       ->icon('heroicon-o-user-group'),


       Stat::make('Active learners Last Month', Learners:: when($start,
       fn($query) => $query -> whereDate('created_at', '>',$start))
       ->
       when($end,
       fn($query) => $query -> whereDate('created_at', '<=',$end))

       ->count() )
       ->icon('heroicon-o-user-plus'),


       Stat::make('Messages Pulled Last Month', Learners:: when($start,
       fn($query) => $query -> whereDate('created_at', '>',$start))
       ->
       when($end,
       fn($query) => $query -> whereDate('created_at', '<=',$end))

       ->count() )
        ->icon('heroicon-o-chat-bubble-bottom-center-text'),


          Stat::make('Cost Per Learner Last Month', Learners:: when($start,
          fn($query) => $query -> whereDate('created_at', '>',$start))
          ->
          when($end,
          fn($query) => $query -> whereDate('created_at', '<=',$end))

          ->count() )
        ->icon('heroicon-o-currency-dollar')




        ];
    }
}
