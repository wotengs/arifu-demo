<?php

namespace App\Filament\Widgets;

use App\Models\Learners;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class GrowthChartWidget extends ChartWidget
{
use InteractsWithPageFilters;

    protected static ?string $heading = 'Growth Rate';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getData(): array
    {

    $start = $this->filters['startDate'];
    $end = $this->filters['endDate'];

        // Retrieve the trend data for each month
        $data = Trend::model(Learners::class)
            ->between(
                start: $start ?  Carbon::parse($start) : now()->startOfYear(),
                end:  $end ?  Carbon::parse($end) : now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        // Calculate the cumulative sum
        $cumulativeData = $data->map(function (TrendValue $value, $index) use ($data) {
            return $data->take($index + 1)->sum(fn (TrendValue $v) => $v->aggregate);
        });

        // Define the color for the chart line and fill
        $color = '#4F46E5'; // You can change this to any color you prefer

        return [
            'datasets' => [
                [
                    'label' => 'Cumulative Learners',
                    'borderColor' => $color, // Set the color of the line
                    'backgroundColor' => $color, // Set the fill color to be the same as the border color
                    'fill' => true, // Set to true for a filled area below the line
                    'data' => $cumulativeData->values(),
                ],
            ],
           'labels' => $data->map(function (TrendValue $value) {
    $date = new \DateTime($value->date); // Convert string to DateTime object
    return $date->format('M'); // Format as 'Jan', 'Feb', etc.
}),

        ];
    }

    protected function getType(): string
    {
        return 'line'; // You can use 'area' or 'line' depending on your preference
    }
}
