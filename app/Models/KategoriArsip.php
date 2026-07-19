<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriArsip extends Model
{
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }
}
