<?php

namespace App\Filament\Widgets;

use App\Models\Arsip;
use App\Models\KategoriArsip;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    // Mengatur urutan tampilan widget di halaman
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            // Kotak 1: Total Arsip (Menggunakan sintaks v5 dengan named arguments)
            Stat::make(
                label: 'Total Arsip Dokumen',
                value: Arsip::count()
            )
                ->description('Seluruh dokumen tersimpan')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Efek grafik kecil
                ->color('success'),

            // Kotak 2: Total Kategori
            Stat::make(
                label: 'Kategori Arsip',
                value: KategoriArsip::count()
            )
                ->description('Klasifikasi yang tersedia')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('info'),

            // Kotak 3: Total Pengguna
            Stat::make(
                label: 'Total Pegawai',
                value: User::count()
            )
                ->description('Pengguna sistem aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
