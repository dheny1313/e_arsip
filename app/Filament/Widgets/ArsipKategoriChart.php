<?php

namespace App\Filament\Widgets;

use App\Models\KategoriArsip;
use App\Models\Jabatan;
use Filament\Widgets\ChartWidget;

class ArsipKategoriChart extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): ?string
    {
        return 'Statistik Arsip per Kategori';
    }

    public function getMaxHeight(): ?string
    {
        return '320px';
    }

    public function getType(): string
    {
        return 'bar';
    }

    // 1. FILTER DROPDOWN DINAMIS (MENGAMBIL DAFTAR JABATAN DARI DATABASE)
    public function getFilters(): ?array
    {
        $filters = [
            'semua' => 'Semua Jabatan',
        ];

        // Ambil semua daftar Jabatan
        $jabatans = Jabatan::pluck('nama_jabatan', 'id')->toArray();

        foreach ($jabatans as $id => $namaJabatan) {
            $filters['jabatan_' . $id] = 'Jabatan: ' . $namaJabatan;
        }

        return $filters;
    }

    // 2. MEMPROSES DATA DENGAN FILTER JABATAN
    public function getData(): array
    {
        $activeFilter = $this->filter ?? 'semua';

        $query = KategoriArsip::query();

        // Jika user memilih Jabatan tertentu di dropdown filter
        if (str_starts_with($activeFilter, 'jabatan_')) {
            $jabatanId = str_replace('jabatan_', '', $activeFilter);

            // Filter kategori yang terikat langsung dengan Jabatan tersebut
            // ATAU sub-kategori yang Jabatan parent-nya sesuai
            $query->where(function ($q) use ($jabatanId) {
                $q->whereHas('jabatans', function ($j) use ($jabatanId) {
                    $j->where('jabatans.id', $jabatanId);
                })
                ->orWhereHas('parent.jabatans', function ($j) use ($jabatanId) {
                    $j->where('jabatans.id', $jabatanId);
                });
            });
        }

        // Hitung total arsip per kategori yang lolos filter
        $kategoris = $query->withCount('arsip')->get();

        // Palet warna dinamis
        $palette = [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
            '#8b5cf6', '#ec4899', '#14b8a6', '#6366f1',
            '#f97316', '#06b6d4',
        ];

        $bgColors = [];
        foreach ($kategoris as $index => $kategori) {
            $bgColors[] = $palette[$index % count($palette)];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Dokumen',
                    'data' => $kategoris->pluck('arsip_count')->toArray(),
                    'backgroundColor' => $bgColors,
                    'borderRadius' => 8,
                ],
            ],
            'labels' => $kategoris->pluck('nama_kategori')->toArray(),
        ];
    }

    public function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
