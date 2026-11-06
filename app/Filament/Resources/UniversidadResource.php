<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniversidadResource\Pages;
use App\Helpers\UniversidadHelper;
use App\Models\Universidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UniversidadResource extends Resource
{
    protected static ?string $model = Universidad::class;

    protected static ?string $modelLabel = 'Universidad';

    protected static ?string $pluralModelLabel = 'Universidades';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_universidad')
                    ->label('Nombre de la universidad')
                    ->placeholder('Universidad Nacional Autónoma de México')
                    ->maxLength(50)
                    ->required(),
                Forms\Components\TextInput::make('pais')
                    ->label('País')
                    ->placeholder('México')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\TextInput::make('ciudad')
                    ->label('Ciudad')
                    ->placeholder('Ciudad de México')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\Select::make('tipo')
                    ->label('Tipo')
                    ->options(UniversidadHelper::tipos())
                    ->required(),
                Forms\Components\Toggle::make('estado_convenio')
                    ->label('Convenio activo')
                    ->helperText('Indica si actualmente existe un convenio vigente con la universidad')
                    ->default(false),
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

                        TextEntry::make('nombre_universidad')
                            ->label('Nombre'),

                        TextEntry::make('pais')
                            ->label('País'),

                        TextEntry::make('ciudad')
                            ->label('Ciudad'),

                        TextEntry::make('tipo')
                            ->label('Tipo'),

                        TextEntry::make('estado_convenio')
                            ->label('Convenio')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Activo' : 'Inactivo')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre_universidad')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pais')
                    ->label('País')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ciudad')
                    ->label('Ciudad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('estado_convenio')
                    ->label('Convenio')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo de universidad')
                    ->options(UniversidadHelper::tipos()),
                Tables\Filters\TernaryFilter::make('estado_convenio')
                    ->label('Convenio')
                    ->placeholder('Todos')
                    ->trueLabel('Con convenio')
                    ->falseLabel('Sin convenio'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
                Tables\Actions\DeleteAction::make()->label('')->extraAttributes(['class' => 'hidden'])
                    ->modalHeading('Eliminar universidad')
                    ->modalDescription('¿Estás seguro de que deseas eliminar esta universidad? Esta acción enviará el registro a la papelera.')
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\DeleteAction $action, Universidad $record) {
                        if ($record->carreras()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede eliminar la universidad')
                                ->body('Esta universidad tiene una o más carreras registradas.')
                                ->send();

                            $action->cancel();
                        }
                    }),
                Tables\Actions\RestoreAction::make()->label('Recuperar')
                    ->modalHeading('Recuperar universidad')
                    ->modalDescription('¿Estás seguro de que deseas restaurar esta universidad?')
                    ->modalSubmitActionLabel('Sí, recuperar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente')
                    ->modalHeading('Borrar universidad definitivamente')
                    ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta universidad? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Sí, borrar definitivamente')
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\ForceDeleteAction $action, Universidad $record) {
                        if ($record->carreras()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede borrar definitivamente')
                                ->body('Esta universidad tiene una o más carreras registradas.')
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make()
                        ->modalHeading('Recuperar universidades seleccionadas')
                        ->modalDescription('¿Estás seguro de que deseas restaurar las universidades seleccionadas?')
                        ->modalSubmitActionLabel('Sí, recuperar')
                        ->modalCancelActionLabel('No, cancelar'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->modalHeading('Borrar universidades definitivamente')
                        ->modalDescription('¿Estás seguro de que deseas borrar definitivamente las universidades seleccionadas? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Sí, borrar definitivamente')
                        ->modalCancelActionLabel('No, cancelar')
                        ->before(function (Tables\Actions\ForceDeleteBulkAction $action, Collection $records) {
                            $conCarreras = $records->filter(fn (Universidad $record) => $record->carreras()->exists());

                            if ($conCarreras->isNotEmpty()) {
                                Notification::make()
                                    ->danger()
                                    ->title('Acción cancelada')
                                    ->body('No se pueden borrar porque tienen carreras registradas: ' . $conCarreras->pluck('nombre_universidad')->join(', ') . '.')
                                    ->send();

                                $action->cancel();
                            }
                        }),
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
            'index' => Pages\ListUniversidads::route('/'),
            'create' => Pages\CreateUniversidad::route('/create'),
            'edit' => Pages\EditUniversidad::route('/{record}/edit'),
        ];
    }
}
