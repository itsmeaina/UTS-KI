<?php

namespace App\Filament\Admin\Resources\KHSResource\Pages;

use App\Filament\Admin\Resources\KHSResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKHS extends ListRecords
{
    protected static string $resource = KHSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
