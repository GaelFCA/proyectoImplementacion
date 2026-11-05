<?php

namespace App\Filament\Resources\PlanTrabajoResource\Pages;

use App\Filament\Resources\PlanTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanTrabajo extends EditRecord
{
    protected static string $resource = PlanTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
