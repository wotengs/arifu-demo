<?php

namespace App\Filament\Resources\LessonsResource\Pages;

use App\Filament\Resources\LessonsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLessons extends CreateRecord
{
    protected static string $resource = LessonsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
