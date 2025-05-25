<?php

namespace App\Filament\Admin\Resources\DosenCourseResource\Pages;

use App\Filament\Admin\Resources\DosenCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDosenCourse extends EditRecord
{
    protected static string $resource = DosenCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
