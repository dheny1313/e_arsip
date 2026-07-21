<?php

namespace App\Filament\Resources\KategoriArsips\Pages;

use App\Filament\Resources\KategoriArsips\KategoriArsipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriArsip extends EditRecord
{
    protected static string $resource = KategoriArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    // --- TAMBAHKAN BLOK KODE INI UNTUK BREADCRUMBS ---
    public function getBreadcrumbs(): array
    {
        $record = $this->getRecord();
        $breadcrumbs = [];

        // Mulai dari parent (folder induk)
        $kategori = $record->parent;

        // Tarik terus ke atas sampai mentok di folder paling luar
        while ($kategori) {
            $breadcrumbs[KategoriArsipResource::getUrl('edit', ['record' => $kategori->id])] = $kategori->nama_kategori;
            $kategori = $kategori->parent;
        }

        // Balik urutannya agar berjejer dari kiri (Utama) ke kanan (Sub)
        $breadcrumbs = array_reverse($breadcrumbs, true);

        return [
            // Menambahkan link 'Kategori Utama' di paling kiri
            KategoriArsipResource::getUrl('index') => 'Kategori Utama',
            ...$breadcrumbs,
        ];
    }
}
