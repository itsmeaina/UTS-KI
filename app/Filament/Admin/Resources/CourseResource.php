<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CourseResource\Pages;
use App\Filament\Admin\Resources\CourseResource\RelationManagers;
use App\Models\Jurusan;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationLabel = 'Mata Kuliah';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_mata_kuliah')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Mata Kuliah'),

                Forms\Components\TextInput::make('bidang_mata_kuliah')
                    ->required()
                    ->maxLength(255)
                    ->label('Bidang Mata Kuliah'),

                Forms\Components\TextInput::make('sks')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(10)
                    ->label('SKS'),

                Forms\Components\Select::make('semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                        3 => 'Semester 3',
                        4 => 'Semester 4',
                        5 => 'Semester 5',
                        6 => 'Semester 6',
                        7 => 'Semester 7',
                        8 => 'Semester 8',
                    ])
                    ->required()
                    ->label('Semester'),

                Forms\Components\Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama_jurusan') // sesuaikan dengan relasi dan nama kolom
                    ->searchable()
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course_id')
                    ->label('Kode Mata Kuliah')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_mata_kuliah')
                    ->label('Nama Mata Kuliah')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bidang_mata_kuliah')
                    ->label('Bidang Mata Kuliah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sks')
                    ->label('SKS'),

                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan_id')
                    ->label('Jurusan')
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('course_id')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
        return 3;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
