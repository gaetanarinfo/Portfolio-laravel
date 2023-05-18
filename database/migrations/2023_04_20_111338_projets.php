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
        Schema::create('projets', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('categorie');
            $table->string('title');
            $table->string('description')->nullable(true);
            $table->string('image')->default('default.png');
            $table->string('icone')->default('default.png');
            $table->string('url');
            $table->float('prix', 10, 2)->nullable(true);
            $table->string('app')->nullable(true);
            $table->integer('audience')->nullable(true);
            $table->integer('acquisition')->nullable(true);
            $table->decimal('revenu_brut', 10, 2)->nullable(true);
            $table->integer('active')->default(1);
            $table->string('author')->nullable(true);
            $table->string('background')->nullable(true);
            $table->string('color')->nullable(true);
            $table->string('age')->nullable(true);
            $table->string('nouveautes')->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('location')->nullable(true);
            $table->string('regles_url')->nullable(true);
            $table->integer('encrypted')->default(0);
            $table->string('version')->nullable(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
