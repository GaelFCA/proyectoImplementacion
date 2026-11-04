<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CondicionResource\Pages;
use App\Filament\Resources\CondicionResource\RelationManagers;
use App\Models\Condicion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

use Illuminate\Database\Eloquent\SoftDeletingScope;

class CondicionResource extends Resource
{
    protected static ?string $model = Condicion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->placeHolder('Regularidad')
                    ->required(),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->helperText('Describe de que trata tu condicion')
                    ->placeHolder('El alumno no tiene materias reprobadas y cumple con los creditos actuales a su semestre segun la planeacion')
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns(1)
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('id')
                            ->label('#'),

                        TextEntry::make('nombre')
                            ->label('Nombre'),

                        TextEntry::make('descripcion')
                            ->label('Descripcion'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(null)
            ->recordAction(Tables\Actions\ViewAction::class)
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
                Tables\Actions\DeleteAction::make()->label("")
                    ->modalHeading('Eliminar condición') 
                    ->modalDescription('¿Estás seguro de que deseas eliminar esta condición? Esta acción enviará el registro a la papelera.') // Texto secundario
                    ->modalSubmitActionLabel('Sí, eliminar') 
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\RestoreAction::make()->label('Recuperar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
            'index' => Pages\ListCondicions::route('/'),
            'create' => Pages\CreateCondicion::route('/create'),
            'edit' => Pages\EditCondicion::route('/{record}/edit'),
        ];
    }
}