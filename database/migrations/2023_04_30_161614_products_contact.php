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
        Schema::create('products_contact', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement();
            $table->integer('product_id')->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email');
            $table->timestamp('appointment');
            $table->timestamp('appointmentTel');
            $table->string('phone');
            $table->string('content');
            $table->string('maquette');
            $table->longText('domains');
            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_contact');
    }
};
