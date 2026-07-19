<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriArsip;
use App\Models\User;


class Arsip extends Model
{
    protected $fillable = [
        'kategori_arsip_id',
        'user_id',
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

    // Di dalam model Arsip, tambahkan ini
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    // FUNGSI INI AKAN OTOMATIS BERJALAN SAAT DATA DIHAPUS
    protected static function booted()
    {
        static::deleted(function ($arsip) {
            // Mengecek apakah file fisiknya ada di storage
            if ($arsip->file_arsip && Storage::disk('public')->exists($arsip->file_arsip)) {
                // Hapus file fisiknya!
                Storage::disk('public')->delete($arsip->file_arsip);
            }
        });
    }
    //
}
