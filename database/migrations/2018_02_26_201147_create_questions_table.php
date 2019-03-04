<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float('score');
            $table->text('text');
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('complexity_id')->nullable();

            $table->foreign('type_id')
                  ->references('id')
                  ->on('types')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('complexity_id')
                  ->references('id')
                  ->on('complexities')
                  ->onDelete('set null')
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
        Schema::dropIfExists('questions');
    }
}
