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
        Schema::create('news', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('title');
            $table->string('url');
            $table->string('small_content');
            $table->longText('large_content');
            $table->string('image')->nullable(true);
            $table->string('image_bandeau')->nullable(true);
            $table->string('categorie');
            $table->string('author');
            $table->string('author_content');
            $table->string('author_link');
            $table->string('source');
            $table->string('avatar');
            $table->integer('views');
            $table->integer('active');
            $table->string('url_fb')->nullable(true);
            $table->string('url_linkedin')->nullable(true);
            $table->string('url_twitter')->nullable(true);
            $table->string('email')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
