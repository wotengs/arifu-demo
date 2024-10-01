<?php

namespace App\Filament\Resources\ProgramResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Program;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Models\Satisfactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LearnersInProgramWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Learners By Program $ Satisfaction';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get the start and end date from filters
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        // Assuming 'created_at' is the date field in the pivot table for learners_program
        $query = DB::table('learners_program')
            ->select('program_id', DB::raw('count(*) as learners_count'))
            ->groupBy('program_id')
            ->orderBy('learners_count', 'desc')
            ->limit(5);

        // Apply date range filtering
        if ($start && $end) {
            $query->whereBetween('created_at', [
                Carbon::parse($start)->startOfYear(),
                Carbon::parse($end)->endOfYear(),
            ]);
        }

        $topPrograms = $query->get();

        $programIds = $topPrograms->pluck('program_id');
        $programNames = Program::whereIn('id', $programIds)->pluck('name', 'id');

        $datasets = [
            'Very Satisfied' => ['color' => 'green', 'data' => []],
            'A Little Satisfied' => ['color' => 'yellow', 'data' => []],
            'Not So Satisfied' => ['color' => 'orange', 'data' => []],
            'Not At All Satisfied' => ['color' => 'red', 'data' => []],
            'Didn\'t Reply' => ['color' => 'grey', 'data' => []],
        ];

        $labels = [];

        foreach ($topPrograms as $program) {
            $programId = $program->program_id;
            $totalLearners = $program->learners_count;

            $satisfactionLevels = Satisfactions::where('program_id', $programId)
                ->select('satisfaction_level', DB::raw('count(*) as count'))
                ->groupBy('satisfaction_level')
                ->pluck('count', 'satisfaction_level');

            // Default values for missing satisfaction levels
            $satisfactionLevels = $satisfactionLevels->merge([
                1 => 0, // Very Satisfied
                2 => 0, // A Little Satisfied
                3 => 0, // Not So Satisfied
                4 => 0, // Not At All Satisfied
                5 => 0  // Didn't Reply
            ]);

            $datasets['Very Satisfied']['data'][] = $satisfactionLevels[1] ?? 0;
            $datasets['A Little Satisfied']['data'][] = $satisfactionLevels[2] ?? 0;
            $datasets['Not So Satisfied']['data'][] = $satisfactionLevels[3] ?? 0;
            $datasets['Not At All Satisfied']['data'][] = $satisfactionLevels[4] ?? 0;
            $datasets['Didn\'t Reply']['data'][] = $totalLearners - $satisfactionLevels->sum();

            $labels[] = $programNames[$programId] ?? 'Unknown Program';
        }

        // Format the chart data
        $chartData = [
            'labels' => $labels,
            'datasets' => array_map(function ($label, $dataset) {
                return [
                    'label' => $label,
                    'backgroundColor' => $dataset['color'],
                    'data' => $dataset['data'],
                    'stack' => 'stack1' // Ensure all datasets use the same stack
                ];
            }, array_keys($datasets), $datasets),
        ];

        return [
            'datasets' => $chartData['datasets'],
            'labels' => $chartData['labels'],
            'options' => [
                'scales' => [
                    'x' => [
                        'stacked' => true,
                        'beginAtZero' => true
                    ],
                    'y' => [
                        'stacked' => true,
                        'beginAtZero' => true
                    ],
                ],
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'top',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Use 'bar' for the bar chart
    }
}
