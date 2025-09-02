<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('working_hours'))
        {
            return;
        }
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_working_day')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'day']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
