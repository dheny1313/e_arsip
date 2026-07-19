<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan'); // Contoh: Kepala Biro, Staf Arsip

            // Menghubungkan ke Unit Kerja
            $table->foreignId('unit_kerja_id')->constrained('unit_kerjas')->onDelete('cascade');

            // KUNCI HIERARKI: Menunjuk ke id jabatan atasannya (bisa kosong jika dia pucuk pimpinan/Menteri)
            $table->foreignId('parent_id')->nullable()->constrained('jabatans')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
