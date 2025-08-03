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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('license_number')->nullable()->index();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_type_id')->constrained()->onDelete('cascade');

            $table->foreignId('region_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('neighborhood_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('estate_type_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('usage_type_id')->nullable()->constrained()->onDelete('set null');

            $table->string('main_type')->comment(sprintf('it will be %s', implode(',', MainType::values())));
            $table->boolean('status')->default(false);
            $table->string('slug',300)->index();
            $table->boolean('is_special')->default(false);
            $table->boolean('is_story')->default(false);
            $table->string('address')->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('price', 15)->nullable();
            $table->decimal('property_price', 15)->default(0)->nullable();
            $table->decimal('area', 15)->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_constrained')->default(false);
            $table->boolean('is_pawned')->default(false);
            $table->boolean('is_halted')->default(false);
            $table->boolean('is_testament')->default(false);

            $table->integer('street_width')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->string('deed_number')->nullable();
            $table->string('property_face')->nullable();
            $table->string('plan_number')->nullable();
            $table->string('land_number')->nullable();
            $table->string('ad_license_url')->nullable();
            $table->string('ad_source')->nullable();
            $table->string('title_deed_type_name')->nullable();
            $table->string('location_description')->nullable();
            $table->string('property_age')->nullable();
            $table->json('rer_constraints')->nullable();

            $table->date('creation_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamp('refresh_date')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->foreignId('reason_id')->nullable()->constrained('reasons')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
