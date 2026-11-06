<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriaResource\Pages;
use App\Filament\Resources\MateriaResource\RelationManagers;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

class MateriaResource extends Resource
{
    protected static ?string $model = Materia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required(),

                Forms\Components\TextInput::make('semestre')
                    ->label('Semestre')
                    ->required(),

                Forms\Components\TextInput::make('tipo')
                    ->label('Tipo de asignatura')
                    ->required(),

                Forms\Components\TextInput::make('plan_trabajo_id')
                    ->label('Plan de trabajo')
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
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->label('Materia'),

                Tables\Columns\TextColumn::make('semestre'),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('plan_trabajo_id')
                    ->label('Plan de trabajo'),
                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->label('Licenciatura'),


            ])

            ->recordUrl(null)
            ->recordAction(Tables\Actions\ViewAction::class)

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),

                Tables\Actions\ViewAction::make()->extraAttributes(['class' => 'hidden']),
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
            'index' => Pages\ListMaterias::route('/'),
            'create' => Pages\CreateMateria::route('/create'),
            'edit' => Pages\EditMateria::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns(2)
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('nombre')
                            ->label('Materia'),

                        TextEntry::make('semestre')
                            ->label('Semestre'),
                        
                        TextEntry::make('tipo')
                            ->label('Tipo'),

                        TextEntry::make('carrera.nombre')
                            ->label('Licenciatura'),

                        TextEntry::make('planTrabajo.url')
                            ->url(fn($state)=>$state, shouldOpenInNewTab: true)
                            ->openUrlInNewTab()
                            ->label('Plan de trabajo'),

                    ]),
            ]);
    }

}
