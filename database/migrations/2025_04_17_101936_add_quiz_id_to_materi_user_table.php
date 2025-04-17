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
        Schema::table('materi_user', function (Blueprint $table) {
            $table->foreignId('quiz_id')->after('courses_id')->constrained()->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('materi_user', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn('quiz_id');
        });
    }
    
};
