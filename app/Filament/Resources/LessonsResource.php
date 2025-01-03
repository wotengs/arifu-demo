<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonsResource\Pages;
use App\Filament\Resources\LessonsResource\RelationManagers\AuthorsRelationManager;
use App\Models\Lessons;
use App\Models\Program;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class LessonsResource extends Resource
{
    protected static ?string $model = Lessons::class;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('english'),
                Infolists\Components\TextEntry::make('swahili')
                    ->columnSpanFull(),
            ]);
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Program Dashboard';
    
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('#')
                            ->required()
                            ->numeric(),
                    Select::make('program_id')
                        ->label('Program Name')
                        ->relationship('program', 'name')
                        ->searchable(),
                    ColorPicker::make('color')
                        ->label('Color Coding')
                        ->required(),
                    TextInput::make('english')
                        ->required(),
                    TextInput::make('swahili')
                        ->required(),
                ])->columnSpan(2)->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                TextColumn::make('program.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable()->wrap()->limit(45),
                TextColumn::make('english')
                    ->sortable()
                    ->searchable()
                    ->toggleable()->wrap()->limit(45),
                TextColumn::make('swahili')
                    ->sortable()
                    ->searchable()
                    ->toggleable()->wrap()->limit(45),
    //                  IconColumn::make('sent')
    // ->boolean(),
            ])
            ->filters([
    //             Filter::make('sent')
    //             ->toggle()
    //            // ->label('Status')
    // ->query(fn (Builder $query): Builder => $query->where('sent', true)),
    // TernaryFilter::make('sent'),
    SelectFilter::make('program')
    ->relationship('program', 'name')
                ->multiple()
                ->searchable()
    ->preload()
                ->attribute('program_id'),
            ])
            ->actions([
                
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
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
            AuthorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLessons::route('/create'),
            'edit' => Pages\EditLessons::route('/{record}/edit'),
        ];
    }
}
