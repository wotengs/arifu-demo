<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentResource extends Resource
{

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Infolists\Components\TextEntry::make('learner.name'),
            Infolists\Components\TextEntry::make('comment')
                ->columnSpanFull(),
        ]);
}

    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Learners Dashboard';

    protected static ?string $modelLabel = 'FeedBack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            //     DatePicker::make('startDate')
            //     ->placeholder('Select Year')
            //     ->format('Y')
            //     ->minDate(now()->startOfYear()->subYears(100)) // Set minimum year
            //     ->maxDate(now()->startOfYear()),
            //     // ->columnSpan(1)
            //     // ->extraAttributes(['style' => 'text-align: right']),
            // DatePicker::make('endDate')
            //     ->placeholder('Select Year')
            //     ->format('Y')
            //     ->minDate(now()->endOfYear()->subYears(100)) // Set minimum year
            //     ->maxDate(now()->endOfYear()), // Set maximum year
            //     // ->columnSpan(1)
            //     // ->extraAttributes(['style' => 'text-align: right;']),
    
            
            ]);
    }

    public static function table(Table $table): Table
    {

        
        return $table
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
                // TextColumn::make('phone_number'),
                //TextColumn::make('email_verified_at'),
            ])
            ->filters([
                SelectFilter::make('program')
                ->relationship('program', 'name')
                     ->multiple()
               ->searchable()
              ->preload()
                ->attribute('program_id'),
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
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

       public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
        //     'create' => Pages\CreateComment::route('/create'),
        //    'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
