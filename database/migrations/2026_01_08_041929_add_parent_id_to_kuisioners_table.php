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
        Schema::table('kuisioners', function (Blueprint $table) {
            // Menambahkan kolom parent_id untuk relasi Kategori -> Sub-Pertanyaan
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('kuisioners')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuisioners', function (Blueprint $table) {
            // Menghapus relasi dan kolom jika migration di-rollback
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};