<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriUserTable extends Migration
{
    public function up()
    {
        Schema::create('materi_user', function (Blueprint $table) {
            $table->id();
            $table->string('nilai');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('courses_id')->constrained('courses'); 
            $table->timestamp('completed_at')->nullable(); // Menyimpan waktu penyelesaian
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materi_user');
    }
}
