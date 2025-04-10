<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul kursus
            $table->text('description')->nullable(); // Deskripsi kursus
            $table->unsignedBigInteger('category_id')->nullable(); // Relasi ke tabel category
            $table->decimal('price', 8, 2); // Harga kursus
            $table->unsignedInteger('capacity')->nullable(); // Kapasitas peserta
            $table->string('image_path'); // Path gambar
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'published', 'nopublished'])->default('pending');
            $table->boolean('chat')->default(false);
            $table->unsignedBigInteger('mentor_id'); // Menyimpan ID mentor
            $table->timestamps(); // Kolom created_at dan updated_at
        
            // Menambahkan foreign key constraint jika tabel users sudah ada
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
