<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JefeCarreraResource\Pages;
use App\Filament\Resources\JefeCarreraResource\RelationManagers;
use App\Filament\Resources\DeleteAction;
use App\Models\JefeCarrera;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class JefeCarreraResource extends Resource
{
    protected static ?string $model = JefeCarrera::class;

        protected static ?string $pluralModelLabel = 'Jefes de carrera';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('a_paterno')
                    ->label('Apellido paterno')
                    ->required(),
                Forms\Components\TextInput::make('a_materno')
                    ->label('Apellido Materno')
                    ->required(),
                Forms\Components\Select::make('carrera_id')
                    ->relationship('carrera', 'nombre')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_trabajador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre del profesor')
                    ->getStateUsing(fn($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),
                /* Tables\Columns\TextColumn::make('nombre')
                     ->searchable(),
                 Tables\Columns\TextColumn::make('a_paterno')
                     ->searchable(),
                 Tables\Columns\TextColumn::make('a_materno')
                     ->searchable(),*/
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

            ->recordURL(null)
            ->recordAction(Tables\Actions\ViewAction::class)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make() ->iconButton(),
                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),

                /*Tables\Actions\DeleteAction::make()
                    ->make()->iconButton()
                    ->modalHeading('¿Eliminar jefe de carrera?')
                    ->modalDescription('¿Estás seguro?')*/
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns(1)
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('numero_trabajador')
                            ->label('Número del trabajador'),

                        TextEntry::make('nombre_completo')
                            ->label('Nombre del profesor')
                            ->state(fn($record) => "{$record->nombre} {$record->a_paterno} {$record->a_materno}"),


                        TextEntry::make('carrera.nombre')
                            ->label('Licenciatura')

                    ]),
            ]);
    }
}
