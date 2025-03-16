<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->timestamp('blocked_until')->nullable();
            $table->enum('plan', ['free', 'basic', 'advance', 'premium'])->default('free');
            $table->rememberToken();
            $table->timestamps();
        });

        // Meeting Rooms table
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity');
            $table->timestamps();
        });

        // Bookings table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('meeting_room_id')->constrained()->onDelete('cascade');
            $table->string('meeting_name');
            $table->dateTime('start_time');
            $table->integer('duration'); // Duration in minutes
            $table->integer('members');
            $table->enum('status', ['booked', 'cancelled'])->default('booked');
            $table->softDeletes();
            $table->timestamps();
        });

        // Subscriptions table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan');
            $table->integer('max_bookings');
            $table->timestamp('subscribed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('meeting_rooms');
        Schema::dropIfExists('users');
    }
};
