<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireImportAnswersResultResource\Pages;
use App\Filament\Resources\QuestionnaireImportAnswersResultResource\RelationManagers;
use App\Models\QuestionnaireImportAnswersResult;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;

class QuestionnaireImportAnswersResultResource extends Resource
{
    protected static ?string $model = QuestionnaireImportAnswersResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('questionnaire')
                    ->relationship('questionnaire', 'id'),
                Forms\Components\Select::make('admin_id')
                ->relationship('admin', 'id')->nullable(),
                Forms\Components\TextInput::make('result'),
                Forms\Components\KeyValue::make('data')->columnSpan(2),
                Forms\Components\KeyValue::make('log')->columnSpan(2),
            ])->disabled();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable(),
                Tables\Columns\TextColumn::make('questionnaire.name'),
                Tables\Columns\TextColumn::make('admin.name'),
            ])
            ->filters([
                Filter::make('is_featured')
                    ->query(fn (Builder $query): Builder => $query->where('root_questionnaire_import_answers_result_id', null))->default()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionnaireImportAnswersResults::route('/'),
            'create' => Pages\CreateQuestionnaireImportAnswersResult::route('/create'),
            'view' => Pages\ViewQuestionnaireImportAnswersResult::route('/{record}'),
            'edit' => Pages\EditQuestionnaireImportAnswersResult::route('/{record}/edit'),
        ];
    }
}
