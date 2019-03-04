<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompaniesTableRemoveAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function(Blueprint $table){
            $table->dropColumn('logo');
            $table->string('last_name');
            $table->unsignedInteger('business_id');
            $table->string('photo')->nullable();
            $table->string('dni')->unique();
            $table->string('personal_email')->unique();

            $table->foreign('business_id')
                  ->references('id')
                  ->on('businesses')
                  ->onDelete('cascade')
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
        Schema::table('companies', function(Blueprint $table){
            $table->string('logo')->nullable();
            $table->dropColumn('last_name');
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
            $table->dropColumn('photo');
            $table->dropColumn('personal_email');
        });
    }
}
