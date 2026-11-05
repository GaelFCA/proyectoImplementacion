<?php

namespace App\Filament\Resources\UniversidadResource\Pages;

use App\Filament\Resources\UniversidadResource;
use App\Models\Universidad;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUniversidad extends EditRecord
{
    protected static string $resource = UniversidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar universidad')
                ->modalDescription('¿Estás seguro de que deseas eliminar esta universidad? Esta acción enviará el registro a la papelera.')
                ->modalSubmitActionLabel('Sí, eliminar')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\DeleteAction $action, Universidad $record) {
                    if ($record->carreras()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede eliminar la universidad')
                            ->body('Esta universidad tiene una o más carreras registradas.')
                            ->send();

                        $action->cancel();
                    }
                }),

            Actions\RestoreAction::make()
                ->label('Recuperar')
                ->modalHeading('Recuperar universidad')
                ->modalDescription('¿Estás seguro de que deseas restaurar esta universidad?')
                ->modalSubmitActionLabel('Sí, recuperar')
                ->modalCancelActionLabel('No, cancelar'),

            Actions\ForceDeleteAction::make()
                ->label('Borrar definitivamente')
                ->modalHeading('Borrar universidad definitivamente')
                ->modalDescription('¿Estás seguro de que deseas borrar definitivamente esta universidad? Esta acción no se puede deshacer.')
                ->modalSubmitActionLabel('Sí, borrar definitivamente')
                ->modalCancelActionLabel('No, cancelar')
                ->before(function (Actions\ForceDeleteAction $action, Universidad $record) {
                    if ($record->carreras()->exists()) {
                        Notification::make()
                            ->danger()
                            ->title('No se puede borrar definitivamente')
                            ->body('Esta universidad tiene una o más carreras registradas.')
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
