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
    protected static ?string $navigationGroup = 'Academic';
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Name')->required(),
                Forms\Components\TextInput::make('Nim')->required(),
                Select::make('gender')
                    ->options([
                        'female' => 'Female',
                        'male' => 'Male',
                    ])
                    ->native(false),
                Select::make('jurusan_id')
                    ->relationship('jurusan', 'nama_jurusan') // sesuaikan dengan relasi di model
                    ->label('Jurusan')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'nama_course') // Sesuaikan nama relasi & kolom
                    ->label('Course')
                    ->required(),
                Forms\Components\TextInput::make('Email')->required(),
                Forms\Components\TextInput::make('Phone')->required(),
                DatePicker::make('date_of_birth')->format('d/m/Y'),
                Select::make('Status')
                    ->options([
                        'active' => 'Active',
                        'leave of absence' => 'Leave of Absence',
                    ])
                    ->native(false),

            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('Name')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('Nim')
                ->label('NIM')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('gender')
                ->label('Jenis Kelamin')
                ->sortable(),

            Tables\Columns\TextColumn::make('Email')
                ->label('Email')
                ->searchable(),

            Tables\Columns\TextColumn::make('Jurusan')
                ->label('Jurusan')
                ->sortable(),

            Tables\Columns\TextColumn::make('Status')
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


    public static function getRelations(): array
    {
        return [
            //
        ];
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
