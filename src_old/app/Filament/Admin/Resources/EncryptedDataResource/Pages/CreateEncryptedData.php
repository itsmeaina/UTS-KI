<?php

namespace App\Filament\Admin\Resources\EncryptedDataResource\Pages;

use App\Filament\Admin\Resources\EncryptedDataResource;
use App\Helpers\EncryptionHelper;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEncryptedData extends CreateRecord
{
    protected static string $resource = EncryptedDataResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['decrypted_data'] = EncryptionHelper::decrypt($data['encrypted_data']);
        return $data;
    }
}
