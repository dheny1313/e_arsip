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
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class ArsipResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Arsip';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                // Mengambil ID User yang sedang login secara otomatis (Tersembunyi dari layar)
                Hidden::make('user_id')
                    ->default(fn() => Auth::id()),

                Select::make('kategori_arsip_id')
                    ->label('Kategori Arsip')
                    ->relationship('kategori', 'nama_kategori')
                    ->required()
                    ->searchable(),

                TextInput::make('nomor_arsip')
                    ->label('Nomor Registrasi / Surat')
                    ->required()
                    ->unique(ignoreRecord: true) // Tidak boleh ada nomor ganda
                    ->maxLength(255),

                TextInput::make('judul_arsip')
                    ->label('Judul Arsip')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('tanggal_arsip')
                    ->label('Tanggal Terbit Dokumen')
                    ->required(),

                // Komponen Upload File (Disimpan di folder: storage/app/public/dokumen-arsip)
                FileUpload::make('file_arsip')
                    ->label('Unggah File Dokumen')
                    ->disk('local') // Pastikan menggunakan disk local
                    ->directory(function (Get $get) {
                        // 1. Cari kategori berdasarkan ID yang dipilih di form
                        $kategori = KategoriArsip::find($get('kategori_arsip_id'));

                        // 2. Ubah nama kategori jadi format URL (contoh: "Surat Masuk" jadi "surat-masuk")
                        $namaKategori = $kategori ? Str::slug($kategori->nama_kategori) : 'uncategorized';

                        // 3. Ambil tanggal hari ini
                        $tanggal = date('Y-m-d');

                        // 4. Hasilkan struktur folder
                        return "dokumen-arsip/{$namaKategori}/{$tanggal}";
                    })
                    //->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
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
            ->columns([
                TextColumn::make('nomor_arsip')->searchable()->sortable(),
                TextColumn::make('judul_arsip')->searchable(),
                TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
                TextColumn::make('tanggal_arsip')->date('d F Y')->sortable(),
                TextColumn::make('uploader.name')->label('Diunggah Oleh'),
            ])
            ->filters([
                // FITUR BARU: Filter berdasarkan Kategori Arsip
                SelectFilter::make('kategori_arsip_id')
                    ->label('Filter Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                // Tombol Kustom Lihat Dokumen
                Action::make('lihat_dokumen')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->modalHeading('Pratinjau Dokumen')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver()
                    ->modalContent(function ($record) {
                        // 1. Ambil URL dari Secure Route Laravel
                        $secureUrl = route('arsip.secure', $record);

                        // 2. Cek ekstensi file (pdf atau word)
                        $extension = strtolower(pathinfo($record->file_arsip, PATHINFO_EXTENSION));

                        // JIKA FILE ADALAH WORD (DOC / DOCX) -> Browser tidak bisa preview langsung, berikan opsi download aman
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

                        // JIKA FILE ADALAH PDF -> Jalankan Trik Blob URL (Anti-IDM & Anti-Download)
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
                                            // Mengubah file private menjadi URL memori sementara di browser
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
                // Tombol Bawaan CRUD
                EditAction::make(),
                //DeleteAction::make(),
            ])
            ->bulkActions([
                // Menggunakan BulkAction standar sesuai dokumentasi versi 5 Anda
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
