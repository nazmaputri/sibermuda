<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdToFinalTaskUserTable extends Migration
{
    public function up()
    {
        Schema::table('final_task_user', function (Blueprint $table) {
            // Menambahkan kolom course_id
            $table->foreignId('course_id')->after('final_task_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('final_task_user', function (Blueprint $table) {
            // Menghapus kolom course_id jika rollback
            $table->dropColumn('course_id');
        });
    }
}
