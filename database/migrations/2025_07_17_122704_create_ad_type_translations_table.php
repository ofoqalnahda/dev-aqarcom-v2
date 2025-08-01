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
        Schema::create('ad_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_type_id')->constrained('ad_types')->onDelete('cascade')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['ad_type_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_type_translations');
    }
};
