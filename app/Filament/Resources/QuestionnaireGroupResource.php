<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireGroupResource\Pages;
use App\Filament\Resources\QuestionnaireGroupResource\RelationManagers;
use App\Models\QuestionnaireGroup;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireGroupResource extends Resource
{
    protected static ?string $model = QuestionnaireGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'grupo de cuestionarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('period_id')
                    ->relationship('period', 'name'),
                Forms\Components\Select::make('questionnaire_class_id')
                    ->relationship('questionnaireClass', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->maxLength(500),
                Forms\Components\TextInput::make('position')
                    ->required(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('period_id'),
                Tables\Columns\TextColumn::make('questionnaireClass.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionnairesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionnaireGroups::route('/'),
            'create' => Pages\CreateQuestionnaireGroup::route('/create'),
            'view' => Pages\ViewQuestionnaireGroup::route('/{record}'),
            'edit' => Pages\EditQuestionnaireGroup::route('/{record}/edit'),
        ];
    }
}
