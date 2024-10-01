<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use App\Filament\Resources\CommentResource\Widgets\SatisfactionWidgets;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderWidgets(): array
    {
        
        return [
            SatisfactionWidgets::class,
         ];
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //        Actions\CreateAction::make(),
    //     ];
    // }
}
