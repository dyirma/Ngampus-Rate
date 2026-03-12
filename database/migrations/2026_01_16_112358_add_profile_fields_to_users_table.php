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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('users', 'status_responden')) {
                $table->string('status_responden')->nullable();
            }
            if (!Schema::hasColumn('users', 'program_studi')) {
                $table->string('program_studi')->nullable();
            }
            if (!Schema::hasColumn('users', 'angkatan')) {
                $table->string('angkatan', 4)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
