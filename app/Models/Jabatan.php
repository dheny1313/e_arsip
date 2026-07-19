<?php

namespace App\Models;
use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Jabatan extends Model
{
    protected $fillable = ['nama_jabatan', 'unit_kerja_id', 'parent_id'];

    // Relasi ke Unit Kerja
    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class);
    }

    // Relasi untuk mengambil 1 tingkat ATASAN langsung
    public function atasan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'parent_id');
    }

    // Relasi untuk mengambil semua BAWAHAN langsung
    public function bawahan(): HasMany
    {
        return $this->hasMany(Jabatan::class, 'parent_id');
    }
}
