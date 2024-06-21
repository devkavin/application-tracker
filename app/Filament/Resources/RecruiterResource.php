<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\RelationManagers\CompanyRelationManager;
use App\Filament\Resources\RecruiterResource\Pages;
use App\Filament\Resources\RecruiterResource\RelationManagers;
use App\Models\Recruiter;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecruiterResource extends Resource
{
    protected static ?string $model = Recruiter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Enter the recruiter name'),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Enter the recruiter email'),
                TextInput::make('phone')
                    ->label('Phone')
                    ->placeholder('Enter the recruiter phone'),
                Select::make('company_id')
                    ->label('Company')
                    ->placeholder('Select the recruiter company')
                    ->relationship('company', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // 'company' => CompanyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecruiters::route('/'),
            'create' => Pages\CreateRecruiter::route('/create'),
            'edit' => Pages\EditRecruiter::route('/{record}/edit'),
        ];
    }
}