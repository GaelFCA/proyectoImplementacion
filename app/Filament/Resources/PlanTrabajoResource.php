<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanTrabajoResource\Pages;
use App\Models\PlanTrabajo;
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
                ->sortable()
                ->toggleable(), // Permite alternar la columna
            
            Tables\Columns\TextColumn::make('descripcion')
                ->label('Descripción')
                ->wrap()
                ->searchable()
                ->action(
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Vista de plan trabajo')
                        ->infolist([
                            Section::make('Detalles del Plan de Trabajo')
                                ->schema([
                                    TextEntry::make('id')->label('ID'),
                                    TextEntry::make('descripcion')->label('Descripción')->columnSpanFull(),
                                    TextEntry::make('url')
                                        ->label('Enlace')
                                        ->color('primary')
                                        ->url(fn (PlanTrabajo $record): string => $record->url, true),
                                ])->columns(2),
                        ])
                ),
            
            Tables\Columns\TextColumn::make('url')
                ->label('Enlace / URL')
                ->color('primary')
                ->searchable()
                ->url(fn (PlanTrabajo $record): string => $record->url, true)
                ->toggleable(), // Permite alternar la columna
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
            'index' => Pages\ListPlanTrabajos::route('/'),
            'create' => Pages\CreatePlanTrabajo::route('/create'),
            'edit' => Pages\EditPlanTrabajo::route('/{record}/edit'),
        ];
    }
}