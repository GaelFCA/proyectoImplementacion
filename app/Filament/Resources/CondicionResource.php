<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CondicionResource\Pages;
use App\Models\Condicion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    protected static ?string $modelLabel = 'Condición';

    protected static ?string $pluralModelLabel = 'Condiciones';

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->placeholder('Regularidad')
                    
                    ->required(),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->required()
                    ->helperText('Describe de qué trata la condición')
                    ->placeholder('El alumno no tiene materias reprobadas y cumple con los créditos actuales a su semestre según la planeación')
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
                            ->label('Descripción'),
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
                Tables\Actions\DeleteAction::make()->label("")->extraAttributes(['class' => 'hidden'])
                    ->modalHeading('Eliminar condición') 
                    ->modalDescription('¿Estás seguro de que deseas eliminar esta condición? Esta acción enviará el registro a la papelera.')
                    ->modalSubmitActionLabel('Sí, eliminar') 
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\DeleteAction $action, Condicion $record) {
                        if ($record->alumnos()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede eliminar la condición')
                                ->body('Esta condición está asignada a uno o más alumnos en el sistema.')
                                ->send();

                            $action->cancel();
                        }
                    }),
                Tables\Actions\RestoreAction::make()->label('Recuperar')
                    ->modalHeading('Recuperar condición')
                    ->modalDescription('¿Estás seguro de que deseas restaurar esta condición?')
                    ->modalSubmitActionLabel('Sí, recuperar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente')
                    ->modalHeading('Borrar condición definitivamente')
                    ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta condición? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Sí, borrar definitivamente')
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\ForceDeleteAction $action, Condicion $record) {
                        if ($record->alumnos()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede borrar definitivamente')
                                ->body('Esta condición está asignada a uno o más alumnos en el sistema.')
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    
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