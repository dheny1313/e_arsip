<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <-- Wajib ditambahkan
use App\Models\KategoriArsip;
use App\Models\User;
use App\Models\UnitKerja;

class Arsip extends Model
{
    protected $fillable = [
        'kategori_arsip_id',
        'user_id',
        'unit_kerja_id',
        'nomor_arsip',
        'judul_arsip',
        'tanggal_arsip',
        'keterangan',
        'file_arsip'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriArsip::class, 'kategori_arsip_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    // SEMUA EVENT DIGABUNG DALAM 1 METHOD BOOTED
    protected static function booted()
    {
        // 1. EVENT SAAT NAMA/JUDUL DIIEDIT
        static::updating(function ($arsip) {
            // Cek jika Judul Arsip diubah TAPI file tidak diunggah ulang
            if ($arsip->isDirty('judul_arsip') && ! $arsip->isDirty('file_arsip')) {
                $oldPath = $arsip->getOriginal('file_arsip');

                // Pastikan file lama memang ada di storage
                if ($oldPath && Storage::disk('local')->exists($oldPath)) {
                    $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
                    $directory = pathinfo($oldPath, PATHINFO_DIRNAME);

                    // Buat nama file baru berdasarkan Judul Arsip yang baru di-edit
                    $newJudulSlug = Str::slug($arsip->judul_arsip);
                    $newFileName = "{$newJudulSlug}-" . time() . ".{$extension}";
                    $newPath = "{$directory}/{$newFileName}";

                    // Rename (pindahkan) file fisik di server
                    Storage::disk('local')->move($oldPath, $newPath);

                    // Simpan path file baru ini ke database
                    $arsip->file_arsip = $newPath;
                }
            }
        });

        // 2. EVENT SAAT DATA ARSIP DIHAPUS
        static::deleted(function ($arsip) {
            if ($arsip->file_arsip && Storage::disk('local')->exists($arsip->file_arsip)) {
                Storage::disk('local')->delete($arsip->file_arsip);
            }
        });
    }
}
