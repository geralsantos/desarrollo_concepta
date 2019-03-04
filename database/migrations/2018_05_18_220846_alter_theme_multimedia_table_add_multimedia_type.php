<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterThemeMultimediaTableAddMultimediaType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('theme_multimedia', function (Blueprint $table) {
            $table->unsignedInteger('multimedia_type_id');

            $table->foreign('multimedia_type_id')
                  ->references('id')
                  ->on('multimedia_types')
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
        Schema::table('theme_multimedia', function (Blueprint $table) {
            $table->dropForeign(['multimedia_type_id']);
            $table->dropColumn('multimedia_type_id');
        });
    }
}
