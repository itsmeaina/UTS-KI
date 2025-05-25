<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DosenCourseResource\Pages;
use App\Filament\Admin\Resources\DosenCourseResource\RelationManagers;
use App\Models\DosenCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DosenCourseResource extends Resource
{
    protected static ?string $model = DosenCourse::class;

    protected static ?string $navigationLabel = 'Perkuliahan';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label('Mata Kuliah')
                    ->relationship('course', 'nama_mata_kuliah') // Asumsikan relasi 'course' sudah ada di model
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama_jurusan') // asumsi kamu punya tabel jurusan dan relasinya
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('thn_akademik')
                    ->label('Tahun Akademik')
                    ->required(),
                Forms\Components\TextInput::make('semester')->required(),
                DatePicker::make('tanggal')
                    ->label('Tanggal Perkuliahan')
                    ->required(),
                TimePicker::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->required(),
                TimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->required(),
                Forms\Components\TextInput::make('ruang')->required(),
        
            ]);
    }

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();

        $exists = \App\Models\DosenCourse::where('nip', $data['nip'])
            ->where('tanggal', $data['tanggal'])
            ->where('ruang', $data['ruang'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('waktu_mulai', [$data['waktu_mulai'], $data['waktu_selesai']])
                    ->orWhereBetween('waktu_selesai', [$data['waktu_mulai'], $data['waktu_selesai']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('waktu_mulai', '<=', $data['waktu_mulai'])
                            ->where('waktu_selesai', '>=', $data['waktu_selesai']);
                    });
            })
            ->exists();

        if ($exists) {
            Notification::make()
                ->title('Jadwal Bentrok')
                ->body('Terdapat jadwal bentrok untuk dosen ini di ruang dan waktu yang sama.')
                ->danger()
                ->send();

            $this->halt(); 
        }
    }

    protected function beforeSave(): void
    {
        $data = $this->form->getState();

        $exists = \App\Models\DosenCourse::where('nip', $data['nip'])
            ->where('tanggal', $data['tanggal'])
            ->where('ruang', $data['ruang'])
            ->where('id', '!=', $this->record->id) // Abaikan dirinya sendiri
            ->where(function ($query) use ($data) {
                $query->whereBetween('waktu_mulai', [$data['waktu_mulai'], $data['waktu_selesai']])
                    ->orWhereBetween('waktu_selesai', [$data['waktu_mulai'], $data['waktu_selesai']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('waktu_mulai', '<=', $data['waktu_mulai'])
                            ->where('waktu_selesai', '>=', $data['waktu_selesai']);
                    });
            })
            ->exists();

        if ($exists) {
            Notification::make()
                ->title('Jadwal Bentrok')
                ->body('Terdapat jadwal bentrok pada perubahan ini.')
                ->danger()
                ->send();

            $this->halt();
        }
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')->label('NIP')->searchable(),
                TextColumn::make('dosen.nama_dosen')->label('Nama Dosen'),
                TextColumn::make('course_id')->label('Kode MK'),
                TextColumn::make('jurusan_id')->label('Kode Jurusan'),
                TextColumn::make('thn_akademik')->label('Tahun Akademik'),
                TextColumn::make('semester')->label('Semester'),
                TextColumn::make('tanggal')->label('Tanggal')->date(),
                TextColumn::make('waktu_mulai')->label('Waktu Mulai')->time(),
                TextColumn::make('waktu_selesai')->label('Waktu Selesai')->time(),
                TextColumn::make('ruang')->label('Ruang'),
            ])
            ->defaultSort('tanggal') 

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getNavigationSort(): ?int
    {
        return 7;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDosenCourses::route('/'),
            'create' => Pages\CreateDosenCourse::route('/create'),
            'edit' => Pages\EditDosenCourse::route('/{record}/edit'),
        ];
    }
}
