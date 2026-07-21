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
        Schema::table('kategori_arsips', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('id')
                ->constrained('kategori_arsips')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_arsips', function (Blueprint $table) {
            // Hapus relasi (foreign key) terlebih dahulu
            $table->dropForeign(['parent_id']);
            // Hapus kolomnya
            $table->dropColumn('parent_id');
        });
    }
};
