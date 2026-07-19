<?php

namespace App\Filament\Widgets;

use App\Models\KategoriArsip;
use App\Models\Arsip;
use Filament\Widgets\ChartWidget;

class ArsipKategoriChart extends ChartWidget
{
    protected ?string $heading = 'Arsip Kategori Chart';


    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Ambil semua data kategori
        $kategoris = KategoriArsip::all();

        return [
            'datasets' => [
                [
                    'label' => 'Total Dokumen',
                    // Menggunakan gaya map(fn) persis seperti dokumentasi
                    'data' => $kategoris->map(
                        fn($kategori) =>
                        Arsip::where('kategori_arsip_id', $kategori->id)->count()
                    )->toArray(),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                ],
            ],
            // Mengambil nama kategori dengan map(fn)
            'labels' => $kategoris->map(fn($kategori) => $kategori->nama_kategori)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
