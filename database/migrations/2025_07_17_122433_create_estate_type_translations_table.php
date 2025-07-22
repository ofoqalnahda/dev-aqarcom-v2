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
        Schema::create('estate_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_type_id')->constrained('estate_types')->onDelete('cascade')->onDelete('cascade');;
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['estate_type_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_type_translations');
    }
};
