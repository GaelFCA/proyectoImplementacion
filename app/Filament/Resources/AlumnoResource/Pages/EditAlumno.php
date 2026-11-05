<?php

namespace App\Filament\Resources\AlumnoResource\Pages;

use App\Filament\Resources\AlumnoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumno extends EditRecord
{
    protected static string $resource = AlumnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar alumno')
                ->modalDescription('¿Estás seguro de que deseas eliminar este alumno? Esta acción enviará el registro a la papelera.')
                ->modalSubmitActionLabel('Sí, eliminar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\RestoreAction::make()
                ->label('Recuperar')
                ->modalHeading('Recuperar alumno')
                ->modalDescription('¿Estás seguro de que deseas restaurar este alumno?')
                ->modalSubmitActionLabel('Sí, recuperar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\ForceDeleteAction::make()
                ->label('Borrar definitivamente')
                ->modalHeading('Borrar alumno definitivamente')
                ->modalDescription('¿Estás seguro de que deseas borrar definitivamente este alumno? Esta acción no se puede deshacer.')
                ->modalSubmitActionLabel('Sí, borrar definitivamente')
                ->modalCancelActionLabel('No, cancelar'),
        ];
    }
}
