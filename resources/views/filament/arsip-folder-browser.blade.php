@php
    // 1. Cek Tab mana yang sedang aktif ('semua' atau 'jabatan')
    $currentTab = $this->activeTab ?? 'semua';

    // 2. Query Folder berdasarkan parent_id saat ini
    $foldersQuery = \App\Models\KategoriArsip::where('parent_id', $this->folder_id);

    // DIPERBARUI: Jika tab 'Arsip Jabatan Saya' aktif, saring menggunakan whereHas
    if ($currentTab === 'jabatan') {
        $userJabatanId = auth()->user()->jabatan_id;
        $foldersQuery->whereHas('jabatans', function ($query) use ($userJabatanId) {
            $query->where('jabatans.id', $userJabatanId);
        });
    }

    $folders = $foldersQuery->get();
    $currentFolder = \App\Models\KategoriArsip::find($this->folder_id);

    // 3. Hirarki Breadcrumb
    $breadcrumbs = [];
    $tempFolder = $currentFolder;
    while ($tempFolder) {
        array_unshift($breadcrumbs, $tempFolder);
        $tempFolder = $tempFolder->parent;
    }
@endphp
{{-- Style Khusus yang Mendukung Dark & Light Mode --}}
<style>
    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 1rem;
    }

    .folder-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1rem;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border: 1px solid rgba(229, 231, 235, 1);
        background-color: rgba(249, 250, 251, 0.8);
    }

    .folder-card:hover {
        border-color: #3b82f6;
        background-color: #f3f4f6;
        transform: translateY(-2px);
    }

    .folder-text {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Support Dark Mode */
    .dark .folder-card {
        border-color: rgba(255, 255, 255, 0.1);
        background-color: rgba(255, 255, 255, 0.03);
    }

    .dark .folder-card:hover {
        border-color: #60a5fa;
        background-color: rgba(255, 255, 255, 0.08);
    }

    .dark .folder-text {
        color: #f3f4f6;
    }
</style>

<x-filament::section class="mb-6">

    {{-- Header Path Breadcrumb File Explorer --}}
    <x-slot name="heading">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 12px;">

            {{-- Navigasi Path Hirarki --}}
            <nav aria-label="Breadcrumb" style="display: flex; align-items: center; gap: 4px; font-size: 0.875rem; flex-wrap: wrap;">

                {{-- Tombol Root (Kategori Utama) --}}
                <button
                    wire:click="setFolder(null)"
                    type="button"
                    class="flex items-center gap-1.5 px-2 py-1 rounded-md transition font-semibold text-gray-500 hover:text-primary-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-primary-400 dark:hover:bg-gray-800"
                >
                    <x-heroicon-m-home style="width: 18px; height: 18px;" />
                    <span>Root</span>
                </button>

                {{-- Loop Seluruh Tingkatan Folder --}}
                @foreach($breadcrumbs as $crumb)
                    <x-heroicon-m-chevron-right style="width: 16px; height: 16px; color: #9ca3af;" />

                    @if($loop->last)
                        {{-- Folder Aktif (Posisi Sekarang) --}}
                        <span class="px-2 py-1 rounded-md font-bold text-gray-900 bg-gray-100 dark:text-white dark:bg-gray-800">
                            {{ $crumb->nama_kategori }}
                        </span>
                    @else
                        {{-- Folder Induk (Bisa Diklik untuk Melompat ke Tingkat Ini) --}}
                        <button
                            wire:click="setFolder({{ $crumb->id }})"
                            type="button"
                            class="px-2 py-1 rounded-md transition font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-primary-400 dark:hover:bg-gray-800"
                        >
                            {{ $crumb->nama_kategori }}
                        </button>
                    @endif
                @endforeach

            </nav>

            {{-- Tombol Kembali (Naik 1 Level) --}}
            @if($currentFolder)
                <x-filament::button
                    wire:click="goUp"
                    color="gray"
                    size="sm"
                    icon="heroicon-m-arrow-left"
                >
                    Kembali
                </x-filament::button>
            @endif
        </div>
    </x-slot>

    {{-- Grid Folder Responsive --}}
    @if($folders->isNotEmpty())
        <div class="folder-grid">
            @foreach($folders as $folder)
                <div wire:click="setFolder({{ $folder->id }})" class="folder-card">
                    <x-heroicon-s-folder style="width: 44px; height: 44px; color: #f59e0b; margin-bottom: 8px;" />
                    <span class="folder-text">
                        {{ $folder->nama_kategori }}
                    </span>
                </div>
            @endforeach
        </div>
    @elseif(!$currentFolder)
        <div style="text-align: center; padding: 1.5rem; color: #9ca3af; font-size: 0.875rem; font-style: italic;">
            Belum ada kategori / folder utama.
        </div>
    @endif

</x-filament::section>
