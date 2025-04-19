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
        Schema::table('purchases', function (Blueprint $table) {
            // simpan harga kursus per baris (setelah diskon jika ada)
            $table->unsignedBigInteger('harga_course')->after('course_id');
        });
    }
    
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('harga_course');
        });
    }
        
};
