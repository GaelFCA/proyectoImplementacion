<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanTrabajoResource\Pages;
use App\Models\PlanTrabajo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanTrabajoResource extends Resource
{
    protected static ?string $model = PlanTrabajo::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase'; 
    protected static ?string $navigationLabel = 'Planes de Trabajo';
    protected static ?string $pluralModelLabel = 'Planes de Trabajo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->label('Enlace / URL')
                    ->url()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->wrap() 
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('url')
                    ->label('Enlace / URL')
                    ->copyable() 
                    ->searchable(),
            ])
            ->filters([
                // Filtros vacíos para no causar error de SoftDeletes
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hiddenLabel() // Quita la palabra "Editar"
                    ->tooltip('Editar'),
                    
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel() // Quita la palabra "Borrar"
                    ->tooltip('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanTrabajos::route('/'),
            'create' => Pages\CreatePlanTrabajo::route('/create'),
            'edit' => Pages\EditPlanTrabajo::route('/{record}/edit'),
        ];
    }
}