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
            $table->id()->unique()->autoIncrement();
            $table->string('avatar')->default('default.svg');
            $table->string('name');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('pseudo')->unique();

            $table->string('signature')->nullable(true);
            $table->date('naissance')->nullable(true);
            $table->string('website')->nullable(true);
            $table->integer('civilite');
            $table->string('biographie')->nullable(true);
            $table->string('fb_page')->nullable(true);
            $table->string('twitter_page')->nullable(true);
            $table->string('insta_page')->nullable(true);
            $table->string('linkedin_page')->nullable(true);
            $table->string('youtube_page')->nullable(true);

            $table->string('email')->unique();
            $table->string('password');
            $table->string('pays')->default('fr');
            $table->string('token')->nullable();
            $table->integer('active')->default(1);
            $table->integer('admin')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable(true);
            $table->foreignId('current_team_id')->nullable();
            $table->timestamp('logged_at')->nullable(true);
            $table->string('profile_photo_path', 2048)->nullable();
            $table->rememberToken();
            $table->integer('user_role')->default(3);
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
