<?php

namespace App\Filament\Resources\QuestionnaireGroupResource\RelationManagers;

use App\Filament\Resources\QuestionnaireResource;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class QuestionnairesRelationManager extends RelationManager
{
    protected static string $relationship = 'questionnaires';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('upload')
                    ->action(fn (Questionnaire $record) => redirect(QuestionnaireResource::getUrl('upload', $record)))
                    ->icon('heroicon-o-upload')
                    ->color('blue'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
