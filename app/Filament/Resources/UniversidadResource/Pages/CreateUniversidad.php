<?php

namespace App\Filament\Resources\UniversidadResource\Pages;

use App\Filament\Resources\UniversidadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUniversidad extends CreateRecord
{
    protected static ?string $title = 'Agregar nueva universidad';
    protected static bool $canCreateAnother = false;
    protected static string $resource = UniversidadResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Universidad agregada exitosamente';
    }
}
