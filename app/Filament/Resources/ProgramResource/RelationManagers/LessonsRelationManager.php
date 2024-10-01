<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Infolists;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('english'),
                Infolists\Components\TextEntry::make('swahili')
                    ->columnSpanFull(),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('#')
                        ->required()
                        ->numeric(),
                        TextInput::make('english')
                            ->required(),
                        TextInput::make('swahili')
                            ->required(),
                        ColorPicker::make('color')
                            ->label('Color Coding')
                            ->required(),
                    ]),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                ->sortable()
                ->searchable()
                ->toggleable(),
                TextColumn::make('#')
                ->sortable()
                ->searchable()
                ->toggleable(),
                ColorColumn::make('color')
                    ->label('Color Coding')
                    ->toggleable(),
                // TextColumn::make('program.name')->wrap()->limit(45)
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(),
                TextColumn::make('english')->wrap()->limit(45)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('swahili')->wrap()->limit(45)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                    IconColumn::make('sent')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('sent'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                 ])->color('info'),
                Action::make('Send')
                  ->url('/'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

    }
}
