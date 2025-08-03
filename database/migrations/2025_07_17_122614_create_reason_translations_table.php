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
        Schema::create('reason_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reason_id')->constrained('reasons')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['reason_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_translations');
    }
};
