<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('learner.name'),
                Infolists\Components\TextEntry::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('comment')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('learner.name')
                ->label('Name')
                ->sortable()
                    ->searchable()
                    ->toggleable(),
                    TextColumn::make('program.name')
                    ->label('Program')
                    ->sortable()
                        ->searchable()
                        ->toggleable(),
                    TextColumn::make('learner.phone_number')
                    ->label('Phone')
                        ->searchable()
                        ->toggleable(),
                TextColumn::make('comment')
                ->label('FeedBack')
                    ->searchable()
                    ->toggleable(),
                    TextColumn::make('created_at')
                    ->label('Published On')
                    ->date()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
                SelectFilter::make('program')
                ->relationship('program', 'name')
                            ->multiple()
                            ->searchable()
                ->preload()
                            ->attribute('program_id'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                     Tables\Actions\DeleteAction::make(),
                 ])->color('info'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
