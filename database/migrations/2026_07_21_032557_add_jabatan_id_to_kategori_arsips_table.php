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
            // Menambahkan jabatan_id (nullable agar folder Root/Umum tidak wajib punya jabatan)
            $table->foreignId('jabatan_id')->nullable()->after('parent_id')->constrained('jabatans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_arsips', function (Blueprint $table) {
            //
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn('jabatan_id');
        });
    }
};
