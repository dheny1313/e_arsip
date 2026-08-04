@php
    // 1. Cek Tab mana yang sedang aktif
    $currentTab = $this->activeTab ?? 'semua';

    // 2. Query Sub-Folder berdasarkan parent_id saat ini + Eager Load relasi 'jabatan'
    $foldersQuery = \App\Models\KategoriArsip::query()
        ->where('parent_id', $this->folder_id)
        ->with('jabatan'); // Eager load agar query efisien

    // Jika tab 'Arsip Jabatan Saya' aktif, saring folder berdasarkan jabatan user
    if ($currentTab === 'jabatan') {
        $userJabatanId = auth()->user()?->jabatan_id;
        $foldersQuery->where('jabatan_id', $userJabatanId);
    }

    $folders = $foldersQuery->get();
    $currentFolder = $this->folder_id ? \App\Models\KategoriArsip::find($this->folder_id) : null;

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
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
    }

    .folder-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        padding: 0.875rem 0.75rem;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border: 1px solid rgba(229, 231, 235, 1);
        background-color: rgba(249, 250, 251, 0.8);
        min-height: 120px;
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
        word-break: break-word;
        margin-bottom: 6px;
    }

    /* Badge Indikator Jabatan */
    .folder-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 4px;
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

    .dark .folder-badge {
        background-color: rgba(146, 64, 14, 0.3);
        color: #fcd34d;
        border-color: rgba(252, 211, 77, 0.2);
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
                        {{-- Folder Induk --}}
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
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <x-heroicon-s-folder style="width: 44px; height: 44px; color: #f59e0b; margin-bottom: 6px;" />
                        <span class="folder-text">
                            {{ $folder->nama_kategori }}
                        </span>
                    </div>

                    {{-- BADGE INDIKATOR JABATAN (Poin C) --}}
                   @if($folder->jabatan)
                        <span class="folder-badge" title="{{ $folder->jabatan->nama_jabatan ?? $folder->jabatan->nama }}">
                            {{ $folder->jabatan->nama_jabatan ?? $folder->jabatan->nama ?? 'Ada Jabatan' }}
                        </span>
                    @else
                        <span class="folder-badge" style="background-color: #e5e7eb; color: #4b5563; border-color: #d1d5db;">
                            Umum / Global
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @elseif(!$currentFolder)
        <div style="text-align: center; padding: 1.5rem; color: #9ca3af; font-size: 0.875rem; font-style: italic;">
            Belum ada kategori / folder utama.
        </div>
    @else
        <div style="text-align: center; padding: 1rem; color: #9ca3af; font-size: 0.875rem; font-style: italic;">
            Tidak ada sub-folder di dalam kategori ini.
        </div>
    @endif

</x-filament::section>
