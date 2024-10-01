<?php

namespace App\Filament\Resources\LearnersResource\Pages;

use App\Filament\Resources\LearnersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearners extends EditRecord
{
    protected static string $resource = LearnersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
