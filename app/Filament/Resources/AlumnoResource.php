<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoResource\Pages;
use App\Models\Alumno;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumnoResource extends Resource
{
    protected static ?string $model = Alumno::class;

    protected static ?string $modelLabel = 'Alumno';

    protected static ?string $pluralModelLabel = 'Alumnos';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_cuenta')
                    ->label('Número de cuenta')
                    ->placeholder('322001045')
                    ->required()
                    ->length(9)
                    ->unique(Alumno::class, 'numero_cuenta', ignoreRecord: true)
                    ->validationMessages([
                            'unique' => 'Este número de cuenta ya se encuentra registrado.',
                            'required' => 'El número de cuenta es obligatorio.',
                            'length' => 'El número de cuenta debe tener exactamente 9 dígitos.',
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
                Forms\Components\TextInput::make('creditos')
                    ->label('Créditos')
                    ->minValue(0)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('semestre')
                    ->label('Semestre')
                    ->minValue(1)
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('regularidad')
                    ->required(),
                Forms\Components\Select::make('carrera_id')
                    ->label('Carrera')
                    ->relationship('carrera', 'nombre')
                    ->searchable()
                    ->preload()
                    ->live()
                    // Al cambiar de carrera, se quitan las materias que ya no son válidas para la nueva carrera
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        $validas = Materia::query()
                            ->whereIn('id', $get('materias') ?? [])
                            ->where(fn (Builder $query) => $query
                                ->where('carrera_id', $state)
                                ->orWhere('tipo', 'like', '%optativa%'))
                            ->pluck('id')
                            ->all();

                        $set('materias', $validas);
                    })
                    ->required(),
                Forms\Components\Select::make('condiciones')
                    ->label('Condiciones')
                    ->relationship(
                        'condiciones',
                        'nombre',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNotIn('nombre', ['Regular', 'Irregular', 'regular', 'irregular']),
                    )
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('materias')
                    ->label('Materias inscritas')
                    ->relationship(
                        'materias',
                        'nombre',
                        // Regla de negocio: materias de su carrera, o de otras carreras solo si son optativas
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query
                            ->where(fn (Builder $query) => $query
                                ->where('materias.carrera_id', $get('carrera_id'))
                                ->orWhere('materias.tipo', 'like', '%optativa%')),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Materia $record) => "#{$record->id} - {$record->nombre} ({$record->tipo})")
                    ->multiple()
                    ->searchable(['materias.id', 'materias.nombre'])
                    ->preload()
                    ->disabled(fn (Get $get) => blank($get('carrera_id')))
                    ->rule(fn (Get $get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                        $invalidas = Materia::query()
                            ->whereIn('id', $value ?? [])
                            ->where('carrera_id', '!=', $get('carrera_id'))
                            ->where('tipo', 'not like', '%optativa%')
                            ->pluck('nombre');

                        if ($invalidas->isNotEmpty()) {
                            $fail('Solo puedes inscribir materias optativas de otras carreras. No válidas: ' . $invalidas->join(', ') . '.');
                        }
                    })
                    ->helperText('Se muestran las materias de la carrera del alumno y las optativas de otras carreras. Primero selecciona la carrera.'),
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
                        TextEntry::make('numero_cuenta')
                            ->label('Número de cuenta'),

                        TextEntry::make('nombre_completo')
                            ->label('Nombre')
                            ->getStateUsing(fn ($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),

                        TextEntry::make('carrera.nombre')
                            ->label('Carrera'),

                        TextEntry::make('semestre')
                            ->label('Semestre'),

                        TextEntry::make('creditos')
                            ->label('Créditos'),

                        TextEntry::make('regularidad')
                            ->label('Regularidad')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Regular' : 'Irregular')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                        TextEntry::make('condiciones.nombre')
                            ->label('Condiciones')
                            ->badge()
                            ->state(fn ($record) => $record->condiciones
                                ->reject(fn ($c) => in_array(mb_strtolower($c->nombre), ['regular', 'irregular']))
                                ->pluck('nombre')
                            )
                            ->placeholder('Sin condiciones'),

                        TextEntry::make('materias.nombre')
                            ->label('Materias inscritas')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->placeholder('Sin materias inscritas'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_cuenta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre del alumno')
                    ->sortable(['nombre', 'a_paterno', 'a_materno'])
                    ->searchable(['nombre', 'a_paterno', 'a_materno'])
                    ->getStateUsing(fn($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),
                Tables\Columns\TextColumn::make('creditos')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('semestre')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('regularidad')->label('Es regular')
                    ->boolean(),
                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->sortable(),
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
                Tables\Filters\TernaryFilter::make('regularidad')
                    ->label('Regularidad')
                    ->placeholder('Todos')
                    ->trueLabel('Regulares')
                    ->falseLabel('Irregulares'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
                Tables\Actions\DeleteAction::make()->label('')->extraAttributes(['class' => 'hidden'])
                    ->modalHeading('Eliminar alumno')
                    ->modalDescription('¿Estás seguro de que deseas eliminar este alumno? Esta acción enviará el registro a la papelera.')
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\RestoreAction::make()->label('Recuperar')
                    ->modalHeading('Recuperar alumno')
                    ->modalDescription('¿Estás seguro de que deseas restaurar este alumno?')
                    ->modalSubmitActionLabel('Sí, recuperar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente')
                    ->modalHeading('Borrar alumno definitivamente')
                    ->modalDescription('¿Estás seguro de que deseas borrar definitivamente este alumno? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Sí, borrar definitivamente')
                    ->modalCancelActionLabel('No, cancelar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make()
                        ->modalHeading('Recuperar alumnos seleccionados')
                        ->modalDescription('¿Estás seguro de que deseas restaurar los alumnos seleccionados?')
                        ->modalSubmitActionLabel('Sí, recuperar')
                        ->modalCancelActionLabel('No, cancelar'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->modalHeading('Borrar alumnos definitivamente')
                        ->modalDescription('¿Estás seguro de que deseas borrar definitivamente los alumnos seleccionados? Esta acción no se puede deshacer.')
                        ->modalSubmitActionLabel('Sí, borrar definitivamente')
                        ->modalCancelActionLabel('No, cancelar'),
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
            'index' => Pages\ListAlumnos::route('/'),
            'create' => Pages\CreateAlumno::route('/create'),
            'edit' => Pages\EditAlumno::route('/{record}/edit'),
        ];
    }
}
