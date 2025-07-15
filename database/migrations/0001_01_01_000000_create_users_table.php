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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->string('whatsapp')->nullable()->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('receive_notification')->default(true);
            $table->boolean('receive_messages')->default(true);
            $table->integer('free_ads')->unsigned()->default(0);
            $table->string('device_token')->nullable();
            $table->timestamp('last_login')->nullable();

            //for authenticated users only
            $table->boolean('is_authentic')->default(0);
            $table->boolean('pending_authentication')->default(0);
            $table->string('identity_owner_name')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('commercial_owner_name')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('commercial_number')->nullable();
            $table->string('commercial_image')->nullable();
            $table->string('identity_image')->nullable();
            $table->longText('val_license')->nullable();
            $table->string( 'transId')->nullable();
            $table->string( 'requestId')->nullable();
            $table->boolean( 'is_nafath_verified')->default( false );
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
