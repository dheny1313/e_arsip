<?php

namespace App\Filament\Resources\Jabatans\Pages;

use App\Filament\Resources\Jabatans\JabatanResource;
use App\Models\Jabatan;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJabatans extends ListRecords
{
    protected static string $resource = JabatanResource::class;

    // View default diset ke 'table'
    public string $activeView = 'table';


    // Arahkan ke custom blade template
    protected string $view = 'filament.resources.jabatans.pages.list-jabatans';

    protected function getHeaderActions(): array
    {
        return [
            // Tombol 1: Mode Table
            Action::make('viewTable')
                ->label('Tampilan Tabel')
                ->icon('heroicon-o-table-cells')
                // 3. BUNGKUS COLOR DENGAN CLOSURE (fn () => ...)
                ->color(fn(): string => $this->activeView === 'table' ? 'success' : 'gray')
                ->action(fn() => $this->activeView = 'table'),

            // Tombol 2: Mode Struktur Organisasi
            Action::make('viewTree')
                ->label('Struktur Organisasi')
                ->icon('heroicon-o-rectangle-group')
                ->color($this->activeView === 'tree' ? 'success' : 'gray')
                ->action(fn() => $this->activeView = 'tree'),

            // Tombol Buat Baru bawaan Filament
            ...parent::getHeaderActions(),

            // TULIS EKSPLISIT DI SINI:
            CreateAction::make(),
        ];
    }

    // Mengambil data Jabatan Puncak (parent_id is null) beserta relasi bawahannya secara rekursif
    public function getTreeData()
    {
        return Jabatan::with('bawahan.bawahan', 'unitKerja')
            ->whereNull('parent_id')
            ->get();
    }
}
