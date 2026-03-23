<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('staff_work_sessions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('staff_id');
        $table->date('work_date');
        $table->timestamp('start_time')->nullable();
        $table->timestamp('end_time')->nullable();
        $table->decimal('hours_spent', 5, 2)->nullable(); // 8.50 = 8hrs 30mins
        $table->timestamps();

        $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_work_sessions');
    }
};
