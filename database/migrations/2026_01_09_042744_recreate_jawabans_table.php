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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('dosen_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->integer('nilai_jawaban')->nullable();
            $table->text('teks_jawaban')->nullable();

            // TAMBAHKAN KOLOM INI AGAR TIDAK ERROR LAGI
            $table->string('gender')->nullable();
            $table->string('status_responden')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('angkatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
