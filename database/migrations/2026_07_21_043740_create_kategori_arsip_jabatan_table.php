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
        Schema::create('kategori_arsip_jabatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_arsip_id')->constrained('kategori_arsips')->cascadeOnDelete();
            $table->foreignId('jabatan_id')->constrained('jabatans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_arsip_jabatan');
    }
};
