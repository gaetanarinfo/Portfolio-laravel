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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('avatar')->default('default.svg');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->integer('active')->default(1);
            $table->integer('admin')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable(true);
            $table->timestamp('logged_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
