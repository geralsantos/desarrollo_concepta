<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterThemesTableRemoveSubGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropForeign(['sub_group_id']);
            $table->dropColumn('sub_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->unsignedInteger('sub_group_id');

            $table->foreign('sub_group_id')
                  ->references('id')
                  ->on('theme_sub_groups')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
