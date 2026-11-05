<?php

namespace App\Filament\Resources\UniversidadResource\Pages;

use App\Filament\Resources\UniversidadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUniversidads extends ListRecords
{
    protected static string $resource = UniversidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
