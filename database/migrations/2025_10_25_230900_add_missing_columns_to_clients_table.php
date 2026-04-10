<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'email')) {
                $table->string('email')->unique()->nullable();
            }
            if (!Schema::hasColumn('clients', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('clients', 'full_name')) {
                $table->string('full_name')->nullable();
            }
            if (!Schema::hasColumn('clients', 'pension_number')) {
                $table->string('pension_number')->unique()->nullable();
            }
            if (!Schema::hasColumn('clients', 'stage')) {
                $table->string('stage')->default('Registered');
            }
            if (!Schema::hasColumn('clients', 'profile_image')) {
                $table->string('profile_image')->nullable();
            }
            if (!Schema::hasColumn('clients', 'account_number')) {
                $table->string('account_number')->nullable();
            }
            if (!Schema::hasColumn('clients', 'staff_id')) {
                $table->unsignedBigInteger('staff_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'email', 'password', 'full_name', 'pension_number',
                'stage', 'profile_image', 'account_number', 'staff_id'
            ]);
        });
    }
};
