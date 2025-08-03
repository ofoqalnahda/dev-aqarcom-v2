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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->json('value');
            $table->string('type', 50)->default('general');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_public')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['key', 'user_id']);
            $table->index('type');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
