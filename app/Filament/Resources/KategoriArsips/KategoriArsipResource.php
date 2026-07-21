<?php

namespace App\Filament\Resources\KategoriArsips;

use App\Filament\Resources\KategoriArsips\Pages\CreateKategoriArsip;
use App\Filament\Resources\KategoriArsips\Pages\EditKategoriArsip;
use App\Filament\Resources\KategoriArsips\Pages\ListKategoriArsips;
use App\Filament\Resources\KategoriArsips\RelationManagers\ArsipRelationManager;
use App\Filament\Resources\KategoriArsips\RelationManagers\ChildrenRelationManager;
use App\Models\KategoriArsip;
use BackedEnum;

// --- IMPORT KOMPONEN FORM ---
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

// --- IMPORT KOMPONEN TABLE ---
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class KategoriArsipResource extends Resource
{
    protected static ?string $model = KategoriArsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::RectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_kategori';

    // 1. SKEMA FORM
    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nama_kategori')
                    ->label('Nama Kategori / Folder')
                    ->required()
                    ->maxLength(255),

                Select::make('jabatans')
                    ->label('Akses Jabatan')
                    ->relationship('jabatans', 'nama_jabatan')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->placeholder('Pilih Jabatan (Biarkan kosong jika untuk Semua Jabatan/Umum)'),

                Textarea::make('deskripsi') // Komponen Form Textarea
                    ->label('Deskripsi Folder')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    // 2. SKEMA TABLE (Mengikuti contoh standar dokumentasi Filament v5)
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('parent_id'))
            ->columns([
                TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jabatans.nama_jabatan')
                    ->label('Akses Jabatan')
                    ->badge()
                    ->separator(',')
                    ->default('Semua Jabatan (Umum)')
                    ->color(fn ($record) => $record->jabatans->isNotEmpty() ? 'info' : 'gray')
                    ->searchable(),

                TextColumn::make('deskripsi') // Menggunakan TextColumn untuk Table
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::class,
            ArsipRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKategoriArsips::route('/'),
            'create' => CreateKategoriArsip::route('/create'),
            'edit' => EditKategoriArsip::route('/{record}/edit'),
        ];
    }
}
