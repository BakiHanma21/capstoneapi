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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('request_id');
            $table->integer('customer_id');
            $table->string('name');
            $table->string('amount');
            $table->string('title');
            $table->text('description');
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED', 'MANUALLY UPDATED']);
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
