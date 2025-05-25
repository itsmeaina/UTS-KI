<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MahasiswaResource\Pages;
use App\Filament\Admin\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationLabel = 'Mahasiswa';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_mahasiswa')
                    ->label('Nama')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->label('Gender')
                    ->options([
                        'female' => 'Female',
                        'male' => 'Male',
                    ])
                    ->native(false),
                DatePicker::make('date_birth')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->native(false) 
                    ->maxDate(now()) 
                    ->displayFormat('d-m-Y')
                    ->closeOnDateSelection(),
                Select::make('jurusan_id')
                    ->relationship('jurusan', 'nama_jurusan') 
                    ->label('Jurusan')
                    ->required(),
                Forms\Components\TextInput::make('year_admission')
                    ->label('Tahun Masuk')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->required(),
                Select::make('status')
                    ->required()
                    ->options([
                        'aktif' => 'Aktif',
                        'cuti' => 'Cuti',

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('nama_mahasiswa')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Gender')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_birth')
                    ->label('Tanggal Lahir')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan_id')
                    ->label('Jurusan')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('year_admission')
                    ->label('Angkatan'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->orderBy('nama_mahasiswa');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
