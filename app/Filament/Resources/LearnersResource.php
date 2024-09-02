<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearnersResource\Pages;
use App\Filament\Resources\LearnersResource\Widgets\AbandonedWidget;
use App\Filament\Resources\LearnersResource\Widgets\CompletionRateWidget;
use App\Filament\Resources\LearnersResource\Widgets\SecondGrowthChartWidget;
use App\Filament\Resources\LearnersResource\Widgets\StartedWidget;
use App\Filament\Resources\LearnersResource\Widgets\TotalLearnersWidget;
use App\Models\Learners;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearnersResource extends Resource
{
    protected static ?string $model = Learners::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'Learners Dashboard';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // //TextColumn::make('id'),
                // TextColumn::make('name'),
                // TextColumn::make('email'),
                // TextColumn::make('phone_number'),
                // //TextColumn::make('email_verified_at'),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone_number')
                ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('programs_completed')
                ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearners::route('/'),
            'create' => Pages\CreateLearners::route('/create'),
            //'edit' => Pages\EditLearners::route('/{record}/edit'),
        ];
    }
}
