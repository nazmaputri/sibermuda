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
        Schema::create('final_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('desc');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            // Foreign key
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_tasks');
    }

};
