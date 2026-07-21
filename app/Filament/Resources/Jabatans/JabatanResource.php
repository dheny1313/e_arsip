<?php

namespace App\Filament\Resources\Jabatans;

use App\Filament\Resources\Jabatans\Pages\CreateJabatan;
use App\Filament\Resources\Jabatans\Pages\EditJabatan;
use App\Filament\Resources\Jabatans\Pages\ListJabatans;
use App\Filament\Resources\Jabatans\Tables\JabatansTable;
use App\Models\Jabatan;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use BackedEnum;


// 1. KEMBALIKAN IMPORT SCHEMA INI
use Filament\Schemas\Schema;

class JabatanResource extends Resource
{
    protected static ?string $model = Jabatan::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;
    protected static ?string $recordTitleAttribute = 'Jabatan';

    // 2. UBAH TYPE HINT MENJADI SCHEMA SESUAI ATURAN PARENT CLASS ANDA
    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nama_jabatan')
                    ->required()
                    ->maxLength(255),

                Select::make('unit_kerja_id')
                    ->relationship('unitKerja', 'nama_unit')
                    ->required()
                    ->searchable(),

                Select::make('parent_id')
                    ->label('Atasan Langsung')
                    ->relationship('atasan', 'nama_jabatan')
                    ->searchable()
                    ->placeholder('Pilih jika memiliki atasan langsung (Kosongkan jika Menteri/Pucuk)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Menampilkan Nama Jabatan
                TextColumn::make('nama_jabatan')
                    ->label('Nama Jabatan')
                    ->searchable()
                    ->sortable(),

                // 2. Menampilkan Nama Unit Kerja (Menggunakan Relasi Eloquent)
                TextColumn::make('unitKerja.nama_unit')
                    ->label('Unit Kerja')
                    ->searchable()
                    ->sortable(),

                // 3. Menampilkan Atasan Langsung (Menggunakan Relasi Self-Reference)
                TextColumn::make('atasan.nama_jabatan')
                    ->label('Atasan Langsung')
                    ->placeholder('Pucuk Pimpinan / Menteri')
                    ->searchable(),
            ])
            ->filters([
                // Tempat filter jika nanti dibutuhkan
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJabatans::route('/'),
            'create' => CreateJabatan::route('/create'),
            'edit' => EditJabatan::route('/{record}/edit'),
        ];
    }
}
