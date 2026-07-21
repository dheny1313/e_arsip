<?php

namespace App\Filament\Resources\KategoriArsips\RelationManagers;

use App\Filament\Resources\KategoriArsips\KategoriArsipResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';
    protected static ?string $title = 'Sub Kategori (Folder)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_kategori')
            // Klik kotak folder untuk masuk ke dalamnya
            ->recordUrl(
                fn ($record): string => KategoriArsipResource::getUrl('edit', ['record' => $record->id])
            )
            // KUNCI UTAMA: Memaksa tabel menjadi Grid (Kotak-kotak)
            ->contentGrid([
                'md' => 3, // 3 folder menyamping di layar sedang
                'xl' => 4, // 4 folder menyamping di layar besar
            ])
            ->columns([
                // Membungkus teks agar tampil cantik di dalam kotak
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('nama_kategori')
                        ->icon('heroicon-s-folder') // Ikon folder solid
                        ->weight('bold')
                        ->size('lg')
                        ->searchable(),

                    Tables\Columns\TextColumn::make('deskripsi')
                        ->color('gray')
                        ->limit(40),
                ])->space(2), // Jarak antara nama folder dan deskripsi
            ])
            ->headerActions([
                CreateAction::make()->label('Buat Folder Baru'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
