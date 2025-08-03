<?php

use App\Component\Ad\Domain\Enum\MainType;
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
        Schema::table('ad_types', function (Blueprint $table) {
            $table->string('main_type')->default('sell')->comment(sprintf('it will be %s', implode(',', MainType::values())))->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad_types', function (Blueprint $table) {
            //
        });
    }
};
