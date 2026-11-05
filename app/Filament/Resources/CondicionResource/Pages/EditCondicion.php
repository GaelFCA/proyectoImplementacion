<?php

namespace App\Filament\Resources\CondicionResource\Pages;

use App\Filament\Resources\CondicionResource;
use App\Models\Condicion;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCondicion extends EditRecord
{
    protected static string $resource = CondicionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar condición')
                ->modalDescription('¿Estás seguro de que deseas eliminar esta condición? Esta acción enviará el registro a la papelera.')
                ->modalSubmitActionLabel('Sí, eliminar')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\DeleteAction $action, Condicion $record) {
                    if ($record->alumnos()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede eliminar la condición')
                            ->body('Esta condición está asignada a uno o más alumnos en el sistema.')
                            ->send();

                        $action->cancel();
                    }
                }),

            Actions\RestoreAction::make()
                ->label('Recuperar')
                ->modalHeading('Recuperar condición')
                ->modalDescription('¿Estás seguro de que deseas restaurar esta condición?')
                ->modalSubmitActionLabel('Sí, recuperar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\ForceDeleteAction::make()
                ->label('Borrar definitivamente')
                ->modalHeading('Borrar condición definitivamente')
                ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta condición? Esta acción no se puede deshacer.')
                ->modalSubmitActionLabel('Sí, borrar definitivamente')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\ForceDeleteAction $action, Condicion $record) {
                    if ($record->alumnos()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede borrar definitivamente')
                            ->body('Esta condición está asignada a uno o más alumnos en el sistema.')
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
