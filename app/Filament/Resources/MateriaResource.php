<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriaResource\Pages;
use App\Helpers\MateriaHelper;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MateriaResource extends Resource
{
    protected static ?string $model = Materia::class;

    protected static ?string $modelLabel = 'Materia';

    protected static ?string $pluralModelLabel = 'Materias';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre de la materia')
                    ->placeholder('Diseño de Algoritmos')
                    ->maxLength(100)
                    ->required(),

                Forms\Components\TextInput::make('semestre')
                    ->label('Semestre')
                    ->placeholder('1')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(8)
                    ->required(),

                Forms\Components\Select::make('tipo')
                    ->label('Tipo de asignatura')
                    ->options(MateriaHelper::tipos())
                    ->required(),

                Forms\Components\Select::make('carrera_id')
                    ->relationship('carrera', 'nombre')
                    ->label('Licenciatura / Carrera')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('plan_trabajo_id')
                    ->relationship('planTrabajo', 'descripcion')
                    ->label('Plan de trabajo')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(Materia::class, 'plan_trabajo_id', ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Este plan de trabajo ya está asignado a otra materia.',
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns(2)
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('id')
                            ->label('#'),

                        TextEntry::make('nombre')
                            ->label('Materia'),

                        TextEntry::make('semestre')
                            ->label('Semestre'),

                        TextEntry::make('tipo')
                            ->label('Tipo'),

                        TextEntry::make('carrera.nombre')
                            ->label('Licenciatura'),

                        TextEntry::make('planTrabajo.descripcion')
                            ->label('Plan de trabajo'),

                        TextEntry::make('planTrabajo.url')
                            ->label('URL del Plan')
                            ->url(fn ($record) => $record->planTrabajo?->url, shouldOpenInNewTab: true)
                            ->openUrlInNewTab()
                            ->visible(fn ($record) => filled($record->planTrabajo?->url)),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nombre')
                    ->label('Materia')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('semestre')
                    ->label('Semestre')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->label('Licenciatura')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('planTrabajo.descripcion')
                    ->label('Plan de trabajo')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

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
                    ->relationship('carrera', 'nombre')
                    ->label('Carrera'),

                Tables\Filters\SelectFilter::make('tipo')
                    ->options(MateriaHelper::tipos())
                    ->label('Tipo'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
                Tables\Actions\DeleteAction::make()->label('')->extraAttributes(['class' => 'hidden'])
                    ->modalHeading('Eliminar materia')
                    ->modalDescription('¿Estás seguro de que deseas eliminar esta materia? Esta acción enviará el registro a la papelera.')
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\DeleteAction $action, Materia $record) {
                        if ($record->alumnos()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede eliminar la materia')
                                ->body('Esta materia tiene uno o más alumnos inscritos.')
                                ->send();

                            $action->cancel();
                        }
                    }),
                Tables\Actions\RestoreAction::make()->label('Recuperar')
                    ->modalHeading('Recuperar materia')
                    ->modalDescription('¿Estás seguro de que deseas restaurar esta materia?')
                    ->modalSubmitActionLabel('Sí, recuperar')
                    ->modalCancelActionLabel('No, cancelar'),
                Tables\Actions\ForceDeleteAction::make()->label('Borrar definitivamente')
                    ->modalHeading('Borrar materia definitivamente')
                    ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta materia? Esta acción no se puede deshacer.')
                    ->modalSubmitActionLabel('Sí, borrar definitivamente')
                    ->modalCancelActionLabel('No, cancelar')
                    ->before(function (Tables\Actions\ForceDeleteAction $action, Materia $record) {
                        if ($record->alumnos()->exists()) {
                            Notification::make()
                                ->danger()
                                ->title('No se puede borrar definitivamente')
                                ->body('Esta materia tiene uno o más alumnos inscritos.')
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMaterias::route('/'),
            'create' => Pages\CreateMateria::route('/create'),
            'edit' => Pages\EditMateria::route('/{record}/edit'),
        ];
    }
}
