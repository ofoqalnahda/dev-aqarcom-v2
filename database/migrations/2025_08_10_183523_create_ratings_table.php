<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ratings'))
        {
            return;
        }
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->comment('Rating from 1 to 5');
            $table->text('description')->nullable();
            $table->timestamps();

            // Prevent duplicate ratings from same user to same company
            $table->unique(['user_id', 'company_id']);

            // Ensure rating is between 1 and 5
//            $table->check('rating >= 1 AND rating <= 5');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
