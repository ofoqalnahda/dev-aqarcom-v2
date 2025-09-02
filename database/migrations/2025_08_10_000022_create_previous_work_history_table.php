<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('previous_work_history'))
        {
            return;
        }
        Schema::create('previous_work_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->text('description');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current_job')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('previous_work_history');
    }
};
