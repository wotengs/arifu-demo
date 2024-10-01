<?php

namespace App\Filament\Exports;

use App\Models\Learners;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LearnersExporter extends Exporter
{
    protected static ?string $model = Learners::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('name'),
            ExportColumn::make('email'),
            ExportColumn::make('phone_number'),
            ExportColumn::make('programs_completed'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your learners export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
