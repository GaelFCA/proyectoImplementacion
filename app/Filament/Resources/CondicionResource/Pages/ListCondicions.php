<?php

namespace App\Filament\Resources\CondicionResource\Pages;

use App\Filament\Resources\CondicionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCondicions extends ListRecords
{
    protected static string $resource = CondicionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
