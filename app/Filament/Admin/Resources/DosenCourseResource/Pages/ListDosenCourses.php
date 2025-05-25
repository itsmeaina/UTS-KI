<?php

namespace App\Filament\Admin\Resources\DosenCourseResource\Pages;

use App\Filament\Admin\Resources\DosenCourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDosenCourses extends ListRecords
{
    protected static string $resource = DosenCourseResource::class;

    public function getTableRecordKey($record): string
    {
        return (string) ($record->nip . '|' . $record->thn_akademik . '|' . $record->semester . '|' . $record->tanggal . '|' . $record->waktu_mulai . '|' . $record->waktu_selesai . '|' . $record->ruang);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(), // Ini akan berfungsi setelah use di atas
        ];
    }

}
