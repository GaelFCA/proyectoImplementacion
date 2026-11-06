<?php

namespace App\Filament\Resources\JefeCarreraResource\Pages;

use App\Filament\Resources\JefeCarreraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJefeCarrera extends EditRecord
{
    protected static string $resource = JefeCarreraResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Jefe de carrera actualizado exitosamente';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar jefe de carrera')
                ->modalDescription('¿Estás seguro de que deseas eliminar este jefe de carrera? Esta acción enviará el registro a la papelera.')
                ->modalSubmitActionLabel('Sí, eliminar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\RestoreAction::make()
                ->label('Recuperar')
                ->modalHeading('Recuperar jefe de carrera')
                ->modalDescription('¿Estás seguro de que deseas restaurar este jefe de carrera?')
                ->modalSubmitActionLabel('Sí, recuperar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\ForceDeleteAction::make()
                ->label('Borrar definitivamente')
                ->modalHeading('Borrar jefe de carrera definitivamente')
                ->modalDescription('¿Estás seguro de que deseas borrar definitivamente este jefe de carrera? Esta acción no se puede deshacer.')
                ->modalSubmitActionLabel('Sí, borrar definitivamente')
                ->modalCancelActionLabel('No, cancelar'),
        ];
    }
}
