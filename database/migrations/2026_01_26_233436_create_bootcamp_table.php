<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bootcamps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('duration');
            $table->string('level');
            $table->string('schedule');
            $table->string('price');
            $table->string('discount_price')->nullable();
            $table->string('image')->nullable();
            $table->json('features')->nullable();
            $table->json('syllabus')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bootcamps');
    }
};
