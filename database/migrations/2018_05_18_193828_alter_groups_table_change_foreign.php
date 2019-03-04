<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGroupsTableChangeForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('theme_groups', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
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
        Schema::table('theme_groups', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
