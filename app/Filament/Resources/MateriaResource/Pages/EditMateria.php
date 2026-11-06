<?php

namespace App\Filament\Resources\MateriaResource\Pages;

use App\Filament\Resources\MateriaResource;
use App\Models\Materia;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMateria extends EditRecord
{
    protected static string $resource = MateriaResource::class;

    protected static ?string $title = 'Editar materia';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Materia actualizada exitosamente';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar materia')
                ->modalDescription('¿Estás seguro de que deseas eliminar esta materia? Esta acción enviará el registro a la papelera.')
                ->modalSubmitActionLabel('Sí, eliminar')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\DeleteAction $action, Materia $record) {
                    if ($record->alumnos()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede eliminar la materia')
                            ->body('Esta materia tiene uno o más alumnos inscritos.')
                            ->send();

                        $action->cancel();
                    }
                }),

            Actions\RestoreAction::make()
                ->label('Recuperar')
                ->modalHeading('Recuperar materia')
                ->modalDescription('¿Estás seguro de que deseas restaurar esta materia?')
                ->modalSubmitActionLabel('Sí, recuperar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\ForceDeleteAction::make()
                ->label('Borrar definitivamente')
                ->modalHeading('Borrar materia definitivamente')
                ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta materia? Esta acción no se puede deshacer.')
                ->modalSubmitActionLabel('Sí, borrar definitivamente')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\ForceDeleteAction $action, Materia $record) {
                    if ($record->alumnos()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede borrar definitivamente')
                            ->body('Esta materia tiene uno o más alumnos inscritos.')
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
