<?php

namespace App\Filament\Resources\CondicionResource\Pages;

use App\Filament\Resources\CondicionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCondicion extends CreateRecord
{
    protected static ?string $title = 'Agregar nueva condicion';
    protected static bool $canCreateAnother = false;
    protected static string $resource = CondicionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Condicion agregada exitosamente';
    }
}
