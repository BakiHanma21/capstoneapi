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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->unsignedBigInteger('sender_id'); // Changed to unsignedBigInteger for foreign key compatibility
            $table->unsignedBigInteger('receiver_id'); // Changed to unsignedBigInteger for foreign key compatibility
            $table->text('message');
            $table->decimal('proposed_cost', 10, 2)->nullable();
            $table->text('additional_details')->nullable();
            $table->string('typed_message')->nullable();
            $table->enum('is_agreed', ['yes', 'no', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};