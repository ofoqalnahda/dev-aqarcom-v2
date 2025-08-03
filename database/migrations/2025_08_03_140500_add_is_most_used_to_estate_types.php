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
        Schema::table('estate_types', function (Blueprint $table) {
            $table->boolean('is_most_used')->default(false)->after('id')
                ->comment('Marks if this type is most used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estate_types', function (Blueprint $table) {
            //
        });
    }
};
