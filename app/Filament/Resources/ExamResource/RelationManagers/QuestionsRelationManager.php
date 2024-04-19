<?php

namespace App\Filament\Resources\ExamResource\RelationManagers;

use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('pivot.score')
                    ->summarize(Tables\Columns\Summarizers\Sum::make())
                    ->label('Score'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Question')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->required(),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('score')
                                    ->label('Score')
                                    ->numeric()
                                    ->default(10)
                                    ->minValue(1)
                                    ->required(),
                                Forms\Components\TextInput::make('sort_value')
                                    ->label('Sort Value')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                            ]),
                    ])
                    ->preloadRecordSelect()
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
