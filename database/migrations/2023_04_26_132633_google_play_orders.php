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
        Schema::create('google_play_orders', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('order_date');
            $table->string('application');
            $table->string('produit');
            $table->string('order_id');
            $table->string('status');
            $table->string('total');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_play_orders');
    }
};
