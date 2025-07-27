<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('verification_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->integer('experience')->nullable();
            $table->string('skills')->nullable();
            $table->string('role');
            $table->string('location')->nullable();
            $table->string('purok')->nullable();
            $table->string('street')->nullable();
            $table->string('image')->nullable();
            $table->string('valid_id')->nullable();
            $table->string('status'); // 'Approved' or 'Denied'
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('denied_at')->nullable();
            $table->json('work_examples')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_histories');
    }
}