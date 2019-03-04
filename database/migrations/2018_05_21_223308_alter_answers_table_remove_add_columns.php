<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAnswersTableRemoveAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');

            $table->unsignedInteger('form_id');

            $table->foreign('form_id')
                  ->references('id')
                  ->on('submitted_forms')
                  ->onDelete('cascade')
                  ->onUdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['form_id']);
            $table->dropColumn('form_id');

            $table->unsignedInteger('student_id');
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
