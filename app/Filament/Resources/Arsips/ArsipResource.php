<?php

namespace App\Filament\Resources\Arsips;

use App\Filament\Resources\Arsips\Pages\CreateArsip;
use App\Filament\Resources\Arsips\Pages\EditArsip;
use App\Filament\Resources\Arsips\Pages\ListArsips;
use App\Models\Arsip;
use App\Models\KategoriArsip;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class ArsipResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;

    protected static ?string $recordTitleAttribute = 'Semua Arsip';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),

                Select::make('kategori_arsip_id')
                    ->label('Kategori Arsip')
                    ->relationship('kategori', 'nama_kategori')
                    ->required()
                    ->searchable()
                    ->live() // Memicu re-render otomatis saat kategori berubah
                    // OTOMATIS: Mengambil parameter folder_id dari halaman List/URL saat ini
                    ->default(fn() => request()->query('folder_id')),

                TextInput::make('nomor_arsip')
                    ->label('Nomor Registrasi / Surat')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('judul_arsip')
                    ->label('Judul Arsip')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('tanggal_arsip')
                    ->label('Tanggal Terbit Dokumen')
                    ->required()
                    ->default(now()),

                FileUpload::make('file_arsip')
                    ->label('Unggah File Dokumen')
                    ->disk('local')
                    ->directory(function (Get $get) {
                        // 1. Cari kategori beserta relasi parent-nya berdasarkan ID
                        $kategori = KategoriArsip::with('parent')->find($get('kategori_arsip_id'));

                        // 2. Gunakan method getFolderPath() dari model Anda!
                        // Hasilnya misal: "surat-masuk/2026/faktur"
                        $folderStructure = $kategori ? $kategori->getFolderPath() : 'uncategorized';

                        // 3. Ambil tanggal hari ini
                        $tanggal = date('Y-m-d');

                        // 4. Struktur direktori penyimpanan di server
                        return "dokumen-arsip/{$folderStructure}/{$tanggal}";
                    })
                    ->maxSize(5120) // Maksimal 5MB
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('keterangan')
                    ->label('Keterangan Tambahan')
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            // 1. FILTER FILE: Hanya tampilkan file yang folder/kategorinya sedang dibuka
            ->modifyQueryUsing(function (Builder $query, $livewire) {
                // Cek apakah halaman ini adalah ListArsips (punya variabel folder_id)
                if (property_exists($livewire, 'folder_id')) {
                    $query->where('kategori_arsip_id', $livewire->folder_id);
                }
                return $query;
            })

            // 1. TAMBAHKAN CONTENT GRID DI SINI (Ini yang membuat tampilan jadi seperti G-Drive)
            ->contentGrid([
                'md' => 3, // 3 kolom di layar sedang
                'xl' => 4, // 4 kolom di layar besar
                '2xl' => 5, // 5 kolom di layar sangat besar
            ])
            ->columns([
                // 2. BUNGKUS KOLOM DENGAN STACK AGAR DITUMPUK KE BAWAH (Menyerupai Kartu/Folder)
                Stack::make([
                    // Ikon File (Berubah sesuai ekstensi dokumen)
                    IconColumn::make('ikon_file')
                        ->getStateUsing(fn($record) => strtolower(pathinfo($record->file_arsip, PATHINFO_EXTENSION)))
                        ->icon(fn($state) => match ($state) {
                            'pdf' => 'heroicon-s-document-text',
                            'doc', 'docx' => 'heroicon-s-document',
                            'xls', 'xlsx' => 'heroicon-s-table-cells',
                            default => 'heroicon-s-document',
                        })
                        ->color(fn($state) => match ($state) {
                            'pdf' => 'danger',     // Merah untuk PDF
                            'doc', 'docx' => 'info', // Biru untuk Word
                            'xls', 'xlsx' => 'success', // Hijau untuk Excel
                            default => 'primary',
                        })
                        ->size(IconSize::Large) // Ikon besar
                        ->alignCenter(),

                    // Judul File
                    TextColumn::make('judul_arsip')
                        ->weight('bold')
                        ->searchable()
                        ->alignCenter()
                        ->limit(30), // Batasi teks agar card tidak berantakan jika judul sangat panjang

                    // Nomor Arsip
                    TextColumn::make('nomor_arsip')
                        ->size('sm')
                        ->color('gray')
                        ->alignCenter()
                        ->searchable(),

                    // Kategori File
                    TextColumn::make('kategori.nama_kategori')
                        ->label('Kategori')
                        ->size('sm')
                        ->color('primary') // Beri warna agar terlihat seperti badge kategori
                        ->alignCenter()
                        ->sortable(),

                    // Tanggal Upload
                    TextColumn::make('tanggal_arsip')
                        ->date('d F Y')
                        ->size('xs')
                        ->color('gray')
                        ->alignCenter()
                        ->sortable(),
                ])->space(3), // Jarak vertikal antar elemen di dalam card
            ])
            ->filters([
                SelectFilter::make('kategori_arsip_id')
                    ->label('Filter Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                // Tombol akan otomatis muncul di bagian bawah setiap "Card" file
                Action::make('lihat_dokumen')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->label('Lihat') // Label dipersingkat agar muat di card grid
                    ->modalHeading('Pratinjau Dokumen')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver()
                    ->modalContent(function ($record) {
                        $secureUrl = route('arsip.secure', $record);
                        $extension = strtolower(pathinfo($record->file_arsip, PATHINFO_EXTENSION));

                        if (in_array($extension, ['doc', 'docx'])) {
                            return new HtmlString("
                            <div style='display: flex; flex-direction: column; justify-content: center; align-items: center; height: 30vh; gap: 15px;'>
                                <span style='font-size: 14px; color: #4b5563;'>Dokumen Word (.{$extension}) tidak dapat dipratinjau secara langsung.</span>
                                <a href='{$secureUrl}' class='fi-btn fi-btn-size-md fi-color-primary' style='background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;'>
                                    Unduh Dokumen Secara Aman
                                </a>
                            </div>
                        ");
                        }

                        return new HtmlString(<<<HTML
                        <div x-data="{
                            pdfUrl: '',
                            loading: true,
                            init() {
                                fetch('{$secureUrl}')
                                    .then(response => {
                                        if (!response.ok) throw new Error('Gagal memuat file');
                                        return response.blob();
                                    })
                                    .then(blob => {
                                        this.pdfUrl = URL.createObjectURL(blob);
                                        this.loading = false;
                                    })
                                    .catch(err => {
                                        console.error(err);
                                        this.loading = false;
                                    });
                            }
                        }" style="width: 100%; height: 75vh;">
                            <template x-if="loading">
                                <div style="display: flex; justify-content: center; align-items: center; height: 100%; color: #888;">
                                    <span>Sedang mengunduh pratinjau enkripsi secara aman...</span>
                                </div>
                            </template>
                            <template x-if="!loading && pdfUrl">
                                <iframe :src="pdfUrl" style="width: 100%; height: 100%; border: none; border-radius: 8px;"></iframe>
                            </template>
                            <template x-if="!loading && !pdfUrl">
                                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; color: #ef4444; gap: 10px;">
                                    <span>Gagal memuat pratinjau.</span>
                                    <a href="{$secureUrl}" target="_blank" style="color: #3b82f6; text-decoration: underline;">Unduh Langsung</a>
                                </div>
                            </template>
                        </div>
                    HTML);
                    }),
                EditAction::make()->label('Edit'), // Dipersingkat agar rapi sejajar dengan tombol lihat
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->label('Hapus Terpilih')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn(\Illuminate\Database\Eloquent\Collection $records) => $records->each->delete()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArsips::route('/'),
            'create' => CreateArsip::route('/create'),
            'edit' => EditArsip::route('/{record}/edit'),
        ];
    }
}
