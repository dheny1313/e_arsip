<?php

namespace App\Filament\Resources\Arsips\Pages;

use App\Filament\Resources\Arsips\ArsipResource;
use App\Models\KategoriArsip;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class ListArsips extends ListRecords
{
    protected static string $resource = ArsipResource::class;
    // Tambahkan baris ini untuk menggunakan Custom Page View
    protected string $view = 'filament.resources.arsip-resource.pages.list-arsips';

    // protected function getHeaderActions(): array
    // {
    //   return [
    //     CreateAction::make()
    //       // Mengoper ID folder yang sedang aktif ke halaman/modal create
    //     ->url(fn(): string => static::$resource::getUrl('create', [
    //       'folder_id' => $this->folder_id
    // ])),
    //];
    //}


    // Menyimpan ID folder saat ini di URL (contoh: ?folder_id=1)
    #[Url]
    public ?int $folder_id = null;

    // Fungsi untuk masuk ke dalam folder
    public function setFolder($id)
    {
        $this->folder_id = $id;
        $this->resetPage();
    }

    public function updatedActiveTab(): void
    {
        $this->folder_id = null; // Kembali ke folder utama (root) saat ganti tab
        $this->resetPage();      // Reset halaman pagination ke halaman 1
    }

    public function goUp(): void
    {
        if ($this->folder_id) {
            $currentFolder = KategoriArsip::find($this->folder_id);
            $this->folder_id = $currentFolder?->parent_id;
            $this->resetPage();
        }
    }

    // =========================================================
    // 1. SAKELAR / TAB FILTER (SEMUA VS ARSIP JABATAN)
    // =========================================================
    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua Arsip')
                ->icon('heroicon-m-folder-open'),

            'jabatan' => Tab::make('Arsip Jabatan Saya')
                ->icon('heroicon-m-briefcase')
                ->modifyQueryUsing(function (Builder $query) {
                    $user = Auth::user();
                    // Menampilkan data tabel arsip yang hanya sesuai dengan jabatan user
                    $query->whereHas('kategori', function ($q) use ($user) {
                        $q->where('jabatan_id', $user->jabatan_id);
                    });
                }),
        ];
    }

    // =========================================================
    // 2. TOMBOL BUAT FOLDER BARU & UNGGAH ARSIP
    // =========================================================
    protected function getHeaderActions(): array
    {
        return [
            Action::make('buatFolderBaru')
                ->label('Folder Baru')
                ->icon('heroicon-m-folder-plus')
                ->color('warning')
                ->form([
                    TextInput::make('nama_kategori')
                        ->label('Nama Folder / Kategori Baru')
                        ->placeholder('Contoh: Laporan Keuangan 2026')
                        ->required()
                        ->maxLength(255),
                ])
                ->action(function (array $data): void {
                    KategoriArsip::create([
                        'nama_kategori' => $data['nama_kategori'],
                        'parent_id'     => $this->folder_id,
                        'jabatan_id'    => Auth::user()->jabatan_id, // Otomatis mengikat folder ke jabatan user
                    ]);

                    Notification::make()
                        ->title('Folder Berhasil Dibuat!')
                        ->success()
                        ->send();
                }),

            CreateAction::make()
                ->label('Unggah Arsip')
                ->icon('heroicon-m-document-plus')
                ->url(fn(): string => static::$resource::getUrl('create', [
                    'folder_id' => $this->folder_id
                ])),
        ];
    }
}
