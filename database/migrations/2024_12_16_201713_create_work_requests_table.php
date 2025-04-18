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
        Schema::create('work_requests', function (Blueprint $table) {
            $table->increments('request_id'); // Primary Key
            $table->integer('customer_id');   // FK references users.user_id
            $table->integer('worker_id');     // FK references skilled_workers.worker_id
            $table->string('service');        // Service type/name
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING'); // Status column
            $table->decimal('proposed_cost', 10, 2); // Proposed cost with precision
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();             // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_requests');
    }
};