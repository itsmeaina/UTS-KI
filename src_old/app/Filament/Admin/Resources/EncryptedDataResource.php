<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EncryptedDataResource\Pages;
use App\Filament\Admin\Resources\EncryptedDataResource\RelationManagers;
use App\Helpers\EncryptionHelper;
use App\Models\EncryptedData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;

class EncryptedDataResource extends Resource
{
    protected static ?string $model = EncryptedData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    TextInput::make('encrypted_data')
                        ->label('Encrypted Data')
                        ->required()
                        ->placeholder('Paste encrypted data here'),

                    TextInput::make('decryption_key')
                        ->label('Decryption Key')
                        ->required()
                        ->password()
                        ->revealable(),

                    TextInput::make('decrypted_data')
                        ->label('Decrypted Data')
                        ->disabled()
                        ->default(function ($get) {
                            $data = $get('encrypted_data');
                            $key = $get('decryption_key');
                            return \App\Helpers\EncryptionHelper::decrypt($data, $key);
                        }),
                ])
                ->columns(1), // Ensures one field per row
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('encrypted_data')
                ->label('Encrypted Data')
                ->limit(50)
                ->tooltip(fn ($record) => $record->encrypted_data),

            Tables\Columns\TextColumn::make('decryption_key')
                ->label('Decryption Key')
                ->formatStateUsing(fn () => '***'), // Mask it securely

            Tables\Columns\TextColumn::make('decrypted_data')
                ->label('Decrypted Data')
                ->limit(100)
                ->tooltip(fn ($record) => $record->decrypted_data),
        ]);
}

public static function getPages(): array
{
    return [
        'index' => Pages\ListEncryptedData::route('/'),
        'create' => Pages\CreateEncryptedData::route('/create'),
        'edit' => Pages\EditEncryptedData::route('/{record}/edit'),
    ];
}
}
