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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('product_id')->unique()->autoIncrement();
            $table->string('product_title');
            $table->string('product_icon');
            $table->float('product_price', 10, 2);
            $table->float('product_per_month', 10 , 2);
            $table->string('product_content');
            $table->string('product_hebergement');
            $table->string('product_color');
            $table->timestamp('product_created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('product_updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
