<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Menambahkan kolom nama
            $table->string('email'); // Email pengulas
            $table->unsignedTinyInteger('rating'); // Rating (1-5)
            $table->text('comment')->nullable(); // Komentar
            $table->boolean('display')->default(true); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
