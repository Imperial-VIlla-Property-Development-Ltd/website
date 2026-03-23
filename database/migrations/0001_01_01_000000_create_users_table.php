<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // generic name
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['client','staff','admin','super_admin'])->default('client');
            $table->string('staff_id')->nullable()->unique(); // for staff login
            $table->string('pension_number')->nullable()->unique(); // for clients (login alternative)
            $table->string('profile_photo')->nullable();
            $table->boolean('is_active')->default(true); // suspend/activate
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
