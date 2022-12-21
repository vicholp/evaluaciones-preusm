<?php

namespace App\Filament\Resources\QuestionnaireImportAnswersResultResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ChildsRelationManager extends RelationManager
{
    protected static string $relationship = 'childs';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\KeyValue::make('log')->columnSpan(2),
            ])->disabled();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rut')->name('data.rut'),
                Tables\Columns\TextColumn::make('result'),
                Tables\Columns\TextColumn::make('updated_at')->sortable()->hidden(),
            ])
            ->filters([
                Filter::make('was_not_successful')
                    ->query(fn (Builder $query): Builder => $query->whereNot('result', 'success'))
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detailt'),
            ])
            ->poll('5s')
            ->defaultSort('updated_at', 'desc');
    }
}
