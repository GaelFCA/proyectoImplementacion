<?php

namespace App\Filament\Resources\JefeCarreraResource\Pages;

use App\Filament\Resources\JefeCarreraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJefeCarrera extends CreateRecord
{
    protected static string $resource = JefeCarreraResource::class;
    protected static ?string $title = 'Agregar nuevo jefe de carrera';
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Jefe de carrera agregado exitosamente';
    }
}
