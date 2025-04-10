<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('materi_video', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materi_id'); 
            $table->string('title'); // Judul 
            $table->text('description')->nullable(); // Deskripsi 
            $table->string('link'); // URL atau path video
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_video');
    }
};
