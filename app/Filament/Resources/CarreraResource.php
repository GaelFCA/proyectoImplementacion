<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarreraResource\Pages;
use App\Models\Carrera;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarreraResource extends Resource
{
    protected static ?string $model = Carrera::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Carreras';
    protected static ?string $pluralModelLabel = 'Carreras';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre de la Carrera')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('duracion')
                    ->label('Duración (Semestres/Años)')
                    ->numeric()
                    ->required(),
                    
                Forms\Components\Select::make('universidad_id')
                    ->label('Universidad')
                    ->relationship('universidad', 'nombre_universidad')
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('#')
                ->sortable()
                ->toggleable(),
            
            Tables\Columns\TextColumn::make('nombre')
                ->label('Carrera')
                ->searchable()
                ->wrap()
                ->action(
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Vista de carrera')
                        ->infolist([
                            Section::make('Detalles de la Carrera')
                                ->schema([
                                    TextEntry::make('id')->label('ID'),
                                    TextEntry::make('nombre')->label('Nombre de la Carrera'),
                                    TextEntry::make('duracion')->label('Duración'),
                                    TextEntry::make('universidad.nombre_universidad')->label('Universidad Perteneciente'),
                                ])->columns(2),
                        ])
                ),
                
            Tables\Columns\TextColumn::make('duracion')
                ->label('Duración')
                ->sortable()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('universidad.nombre_universidad')
                ->label('Universidad')
                ->searchable()
                ->sortable()
                ->toggleable(),
        ])
        ->filters([
            TrashedFilter::make(),
        ])
        ->actions([
            Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Editar'),
            Tables\Actions\RestoreAction::make()->hiddenLabel()->tooltip('Restaurar'),
        ])
        ->bulkActions([]);
}
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarreras::route('/'),
            'create' => Pages\CreateCarrera::route('/create'),
            'edit' => Pages\EditCarrera::route('/{record}/edit'),
        ];
    }
}