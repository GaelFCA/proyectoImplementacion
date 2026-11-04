<?php

namespace App\Filament\Resources\JefeCarreraResource\Pages;

use App\Filament\Resources\JefeCarreraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJefeCarrera extends EditRecord
{
    protected static string $resource = JefeCarreraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
