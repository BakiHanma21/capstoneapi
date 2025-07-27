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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_deactivated')->default(false);
            $table->text('deactivation_reason')->nullable();
            $table->timestamp('deletion_scheduled_at')->nullable();
            $table->text('deletion_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_deactivated');
            $table->dropColumn('deactivation_reason');
            $table->dropColumn('deletion_scheduled_at');
            $table->dropColumn('deletion_reason');
        });
    }
}; 