<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmittedFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('evaluated')->default(false);
            $table->float('score')->default(0.0);
            $table->integer('entity_name');
            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('student_id');

            $table->foreign(['student_id'])
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unique(['entity_id', 'entity_name', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitted_forms');
    }
}
