<?php

namespace App\Filament\Resources\KategoriArsips\RelationManagers;

use App\Models\KategoriArsip;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema; // Menggunakan Schema sesuai versi terbaru
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArsipRelationManager extends RelationManager
{
    protected static string $relationship = 'arsip';
    protected static ?string $title = 'File Arsip';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                Forms\Components\TextInput::make('nomor_arsip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('judul_arsip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_arsip')
                    ->required()
                    ->default(now()),
                Forms\Components\Select::make('folder_utama')
                    ->label('Pilih Folder Utama')
                    ->options(KategoriArsip::whereNull('parent_id')->pluck('nama_kategori', 'id')) // Hanya ambil folder yang tidak punya parent (Induk)
                    ->live() // Wajib live agar saat dipilih, sub-foldernya ter-update
                    ->dehydrated(false), // Gunakan ini JIKA field 'folder_utama' tidak ada di database/tabel arsip Anda (hanya sebagai filter sementara)

                Forms\Components\Select::make('kategori_arsip_id')
                    ->label('Kategori (Sub-Folder)')
                    // Menggunakan ->options() dinamis berdasarkan pilihan di atas
                    ->options(function (Get $get) {
                        $folderUtamaId = $get('folder_utama');

                        // Jika folder utama belum dipilih, dropdown ini kosong
                        if (! $folderUtamaId) {
                            return [];
                        }

                        // Jika sudah dipilih, cari sub-folder yang parent_id-nya sesuai
                        return KategoriArsip::where('parent_id', $folderUtamaId)->pluck('nama_kategori', 'id');
                    })
                    ->live()
                    ->required(),
                Forms\Components\FileUpload::make('file_arsip')
                    ->label('Unggah File Dokumen')
                    ->disk('local') // Pastikan menggunakan disk local
                    ->directory(function (Get $get) {
                        // 1. Cari kategori berdasarkan ID yang dipilih di form
                        $kategori = KategoriArsip::find($get('kategori_arsip_id'));

                        // 2. Dapatkan struktur folder hierarkis (contoh: "hrd/surat-masuk" atau "keuangan/2024/faktur")
                        $namaKategori = $kategori ? $kategori->getFolderPath() : 'uncategorized';

                        // 3. Ambil tanggal hari ini
                        $tanggal = date('Y-m-d');

                        // 4. Hasilkan struktur folder
                        return "dokumen-arsip/{$namaKategori}/{$tanggal}";
                    })
                    //->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(5120) // Maksimal 5MB
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul_arsip')
            ->columns([
                Tables\Columns\TextColumn::make('nomor_arsip')->searchable(),
                Tables\Columns\TextColumn::make('judul_arsip')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_arsip')->date(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Upload File')
                    // Memastikan user_id terisi
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                // Tombol download file
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => asset('storage/' . $record->file_arsip))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
