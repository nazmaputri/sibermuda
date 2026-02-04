<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->string('image_path')->nullable();
            $table->string('category');
            $table->dateTime('published_at');
            $table->string('author');
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
