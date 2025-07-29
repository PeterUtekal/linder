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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo_url')->nullable();
            $table->text('message');
            $table->string('location');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('contact_method')->default('whatsapp'); // whatsapp, instagram, phone
            $table->string('contact_value'); // phone number, username, etc.
            $table->string('short_code')->unique()->index();
            $table->string('qr_code_url')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('swipe_count')->default(0);
            $table->integer('right_swipe_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('device_id')->nullable()->index(); // for tracking unique devices
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->index(['created_at', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
