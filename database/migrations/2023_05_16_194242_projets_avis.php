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
        Schema::create('projets_avis', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->integer('projets_id');
            $table->decimal('note', 10, 2)->nullable(true);
            $table->longText('comment');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets_avis');
    }
};
