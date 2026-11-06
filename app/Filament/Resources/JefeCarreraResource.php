<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JefeCarreraResource\Pages;
use App\Models\JefeCarrera;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JefeCarreraResource extends Resource
{
    protected static ?string $model = JefeCarrera::class;

    protected static ?string $modelLabel = 'Jefe de carrera';

    protected static ?string $pluralModelLabel = 'Jefes de carrera';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_trabajador')
                    ->label('Número de trabajador')
                    ->placeholder('750101')
                    ->required()
                    ->length(6)
                    ->unique(JefeCarrera::class, 'numero_trabajador', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Este número de trabajador ya se encuentra registrado.',
                        'required' => 'El número de trabajador es obligatorio.',
                        'length' => 'El número de trabajador debe tener exactamente 6 dígitos.',
                    ])
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\TextInput::make('a_paterno')
                    ->label('Apellido paterno')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\TextInput::make('a_materno')
                    ->label('Apellido materno')
                    ->maxLength(20)
                    ->required(),
                Forms\Components\Select::make('carrera_id')
                    ->label('Carrera')
                    ->relationship('carrera', 'nombre')
                    ->searchable()
                    ->preload()
                    ->unique(JefeCarrera::class, 'carrera_id', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Esta carrera ya tiene asignado un jefe de carrera.',
                        'required' => 'La carrera es obligatoria.',
                    ])
                    ->required(),
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
                        TextEntry::make('numero_trabajador')
                            ->label('Número de trabajador'),

                        TextEntry::make('nombre_completo')
                            ->label('Nombre del profesor')
                            ->state(fn ($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),

                        TextEntry::make('carrera.nombre')
                            ->label('Carrera que dirige'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_trabajador')
                    ->label('N° Trabajador')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre del profesor')
                    ->sortable(['nombre', 'a_paterno', 'a_materno'])
                    ->searchable(['nombre', 'a_paterno', 'a_materno'])
                    ->getStateUsing(fn ($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),
                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->label('Carrera')
                    ->sortable()
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
                Tables\Filters\SelectFilter::make('carrera_id')
                    ->label('Carrera')
                    ->relationship('carrera', 'nombre')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
                Tables\Actions\DeleteAction::make()->label('')->extraAttributes(['class' => 'hidden'])
                    ->modalHeading('Eliminar jefe de carrera')
                    ->modalDescription('¿Estás seguro de que deseas eliminar este jefe de carrera? Esta acción enviará el registro a la papelera.')
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\RestoreAction::make()->label('Recuperar')
                    ->modalHeading('Recuperar jefe de carrera')
                    ->modalDescription('¿Estás seguro de que deseas restaurar este jefe de carrera?')
                    ->modalSubmitActionLabel('Sí, recuperar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente')
                    ->modalHeading('Borrar jefe de carrera definitivamente')
                    ->modalDescription('¿Estás seguro de que deseas borrar definitivamente este jefe de carrera? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Sí, borrar definitivamente')
                    ->modalCancelActionLabel('No, cancelar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
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
            'index' => Pages\ListJefeCarreras::route('/'),
            'create' => Pages\CreateJefeCarrera::route('/create'),
            'edit' => Pages\EditJefeCarrera::route('/{record}/edit'),
        ];
    }
}
