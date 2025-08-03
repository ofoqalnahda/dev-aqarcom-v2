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
        Schema::create('property_utility_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_utility_id')->constrained('property_utilities')->onDelete('cascade')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['property_utility_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_utility_translations');
    }
};
