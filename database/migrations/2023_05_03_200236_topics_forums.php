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
        Schema::create('topics_forums', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement();
            $table->integer('user_id');
            $table->integer('forum_id');
            $table->string('title');
            $table->string('url');
            $table->longText('content');
            $table->longText('signature');
            $table->integer('status')->default(0);
            $table->integer('sticky')->default(0);
            $table->integer('admin')->default(0);
            $table->integer('resolved')->default(0);
            $table->integer('views')->default(0);
            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics_forums');
    }
};
