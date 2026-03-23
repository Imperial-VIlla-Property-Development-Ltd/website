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
        Schema::create('staff_activity', function (Blueprint $table) {
    $table->id();
    $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
    $table->integer('clients_assigned')->default(0);
    $table->integer('clients_completed')->default(0);
    $table->integer('daily_reports')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_activity');
    }
};
