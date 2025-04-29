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
        Schema::table('final_task_user', function (Blueprint $table) {
            // Mengubah tipe kolom photo menjadi longText, agar dapat menerima lebih banyak path foto (karena string terbatas, ini untuk menghindari resiko error jika foto yg dikirim peserta sangat banyak)
            $table->longText('photo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_task_user', function (Blueprint $table) {
            // Mengembalikan kolom photo menjadi string. tipe data photo awalnya memang string (tapi error jika mengirim lebih banyak foto karen string karaketrnya dibatasi)
            $table->string('photo')->nullable()->change();
        });
    }
};
