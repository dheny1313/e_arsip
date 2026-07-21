<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriArsip extends Model
{
    protected $fillable = ['nama_kategori', 'deskripsi', 'parent_id', 'jabatan_id'];
    // public function arsip()
    //{
    //   return $this->hasMany(Arsip::class);
    // }


    // Tambahkan di dalam class KategoriArsip
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 'kategori_arsip_jabatan');
    }

    // 2. Tambahkan relasi ini untuk Sub-Folder (anak)
    public function children()
    {
        return $this->hasMany(KategoriArsip::class, 'parent_id');
    }

    // 3. Tambahkan relasi ini untuk Folder Utama (induk)
    public function parent()
    {
        return $this->belongsTo(KategoriArsip::class, 'parent_id');
    }

    // Method bantuan untuk membuat struktur folder berdasarkan hierarki
    public function getFolderPath()
    {
        // Ubah nama kategori saat ini menjadi slug (format URL)
        $slug = Str::slug($this->nama_kategori);

        // Jika kategori ini punya induk (parent), gabungkan path parent dengan slug saat ini
        if ($this->parent) {
            return $this->parent->getFolderPath() . '/' . $slug;
        }

        // Jika tidak punya induk, langsung kembalikan slug-nya
        return $slug;
    }

    // Relasi bawaan Anda sebelumnya
    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'kategori_arsip_id');
    }
}
