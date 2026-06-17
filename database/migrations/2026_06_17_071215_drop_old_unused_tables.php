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
        Schema::dropIfExists('pertanyaans');
        Schema::dropIfExists('kuisioners');
        Schema::dropIfExists('dosens');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We do not need to recreate them as they are obsolete
    }
};
