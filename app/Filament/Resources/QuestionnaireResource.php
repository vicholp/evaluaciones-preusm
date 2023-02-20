<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireResource\Pages;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'cuestionario';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('subject_id')
                    ->relationship('subject', 'name'),
                Select::make('questionnaire_group_id')
                    ->relationship('questionnaireGroup', 'id'),
                Forms\Components\TextInput::make('name')
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('subject.name')->sortable(),
                Tables\Columns\TextColumn::make('questionnaireGroup.name')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('questionnaireGroup.name');
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
            'index' => Pages\ListQuestionnaires::route('/'),
            'create' => Pages\CreateQuestionnaire::route('/create'),
            'view' => Pages\ViewQuestionnaire::route('/{record}'),
            'edit' => Pages\EditQuestionnaire::route('/{record}/edit'),
            'upload' => Pages\UploadQuestionnaireResults::route('/{record}/upload'),
            'upload-results' => Pages\QuestionnaireUploadAnswersResult::route('/{record}/upload/{result}'),
        ];
    }
}
