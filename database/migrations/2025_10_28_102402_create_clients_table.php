<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('phone_number');
            $table->string('address')->nullable();
            $table->string('account_number')->nullable(); // created by admin/staff
            $table->enum('stage', ['new','in_progress','approval_pending','approved','rejected','disbursement'])->default('new');
            $table->string('nin')->nullable();
            $table->string('pfa_selected')->nullable(); // pfa code/name
            $table->string('pfa_uploaded_path')->nullable(); // uploaded PDF path
            $table->string('registration_id')->nullable()->unique(); // printable reg id
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
