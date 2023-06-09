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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('name');
            $table->string('email');
            $table->string('to_mail')->default('zineddinehamel@gmail.com');
            $table->string('sujet');
            $table->string('message');
            $table->string('token');
            $table->integer('archive')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
