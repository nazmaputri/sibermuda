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
        Schema::create('youtube', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('materi_id');
            $table->text('description')->nullable();
            $table->string('link');
            $table->timestamps();
    
            // Relasi ke tabel materi
            $table->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube');
    }
};
