<?php

namespace App\Filament\Admin\Resources\EncryptedDataResource\Pages;

use App\Filament\Admin\Resources\EncryptedDataResource;
use App\Helpers\EncryptionHelper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEncryptedData extends EditRecord
{
    protected static string $resource = EncryptedDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['decrypted_data'] = EncryptionHelper::decrypt($data['encrypted_data']);
        return $data;
    }
}
