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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['USER', 'WORKER', 'ADMINISTRATOR']);
            $table->string('profile_image')->nullable();
            $table->string('job')->nullable();
            $table->string('location')->nullable();
            $table->integer('experience')->nullable();
            $table->boolean('availability')->nullable();
            $table->text('occupation')->nullable();
            $table->text('certifications')->nullable();
            $table->text('skills')->nullable();
            $table->text('valid_id')->nullable();
            $table->text('purok')->nullable();
            $table->text('street')->nullable();
            $table->string('phone')->nullable();
            $table->integer('rating')->nullable();
            $table->json('reviews')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
