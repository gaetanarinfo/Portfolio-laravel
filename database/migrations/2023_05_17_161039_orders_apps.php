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
        Schema::create('orders_apps', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->integer('projets_id');
            $table->integer('user_id');
            $table->string('status');
            $table->timestamp('order_at')->nullable(true);
            $table->string('order_method')->nullable(true);
            $table->string('transaction_id')->nullable(true);
            $table->string('capture_id')->nullable(true);
            $table->float('price', 10, 2)->nullable(true);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable(true);
            $table->timestamp('refund_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_apps');
    }
};
