<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KHSResource\Pages;
use App\Filament\Admin\Resources\KHSResource\RelationManagers;
use App\Models\KHS;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KHSResource extends Resource
{
    protected static ?string $model = KHS::class;

    protected static ?string $navigationLabel = 'KHS';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->label('NIM')
                    ->required(),

                Select::make('course_id')
                    ->label('Mata Kuliah')
                    ->relationship('course', 'nama_mata_kuliah')
                    ->required(),

                Select::make('semester')
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

                Forms\Components\TextInput::make('thn_akademik')
                    ->label('Tahun Akademik')
                    ->placeholder('cth: 2024/2025')
                    ->required(),

                Forms\Components\TextInput::make('nilai_huruf')
                    ->required(),

                Forms\Components\TextInput::make('nilai_angka')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')->label('NIM'),
                TextColumn::make('course.nama_mata_kuliah')->label('Mata Kuliah'),
                TextColumn::make('semester')->label('Semester'),
                TextColumn::make('thn_akademik')->label('Tahun Akademik'),
                TextColumn::make('nilai_huruf')->label('Grade'),
                TextColumn::make('nilai_angka')->label('Score'),
            ])
            ->defaultSort('nim', 'desc')

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

    public static function getRecordKeyUsing(): ?\Closure
    {
        return fn ($record) => $record->composite_key;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        KHS::updateOrCreate(
            [
                'nim' => $data['nim'],
                'course_id' => $data['course_id'],
                'semester' => $data['semester'],
                'thn_akademik' => $data['thn_akademik'],
            ],
            [
                'nilai_huruf' => $data['nilai_huruf'],
                'nilai_angka' => $data['nilai_angka'],
            ]
        );

        return $data;
    }


    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKHS::route('/'),
            'create' => Pages\CreateKHS::route('/create'),
            'edit' => Pages\EditKHS::route('/{record}/edit'),
        ];
    }
}
