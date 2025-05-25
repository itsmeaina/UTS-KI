<?php

namespace App\Filament\Admin\Resources\KHSResource\Pages;

use App\Filament\Admin\Resources\KHSResource;
use App\Models\KHS;
use Illuminate\Validation\ValidationException;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKHS extends CreateRecord
{
    protected static string $resource = KHSResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $exists = KHS::where('nim', $data['nim'])
            ->where('course_id', $data['course_id'])
            ->where('semester', $data['semester'])
            ->where('thn_akademik', $data['thn_akademik'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'nim' => 'Data KHS sudah ada untuk kombinasi NIM, Mata Kuliah, Semester, dan Tahun Akademik tersebut.',
            ]);
        }

        return $data;
    }
}
