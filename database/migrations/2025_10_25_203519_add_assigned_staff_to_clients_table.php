<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->unsignedBigInteger('assigned_staff_id')->nullable()->after('id');
        $table->foreign('assigned_staff_id')->references('id')->on('staff')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropForeign(['assigned_staff_id']);
        $table->dropColumn('assigned_staff_id');
    });
}

};
