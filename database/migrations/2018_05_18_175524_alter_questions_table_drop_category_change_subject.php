<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterQuestionsTableDropCategoryChangeSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function(Blueprint $table){
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->dropForeign(['subject_id']);
            $table->unsignedInteger('subject_id')->change();

            $table->foreign('subject_id')
                  ->references('id')
                  ->on('question_subjects')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function(Blueprint $table){
            $table->dropForeign(['subject_id']);
            $table->unsignedInteger('subject_id')->nullable()->change();

            $table->foreign('subject_id')
                  ->references('id')
                  ->on('question_subjects')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->unsignedInteger('category_id')->nullable();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }
}
