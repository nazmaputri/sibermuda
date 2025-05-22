<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMateriProgressTable extends Migration
{
    public function up()
    {
        Schema::create('user_materi_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materi')->onDelete('cascade');

            $table->enum('status', ['belum', 'selesai'])->default('belum');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_materi_progress');
    }
}
