<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeachersTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->string('personal_email')->unique();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('dni');
            $table->dropColumn('email');
            $table->dropColumn('personal_email');
            $table->dropColumn('company');
            $table->dropColumn('phone');
        });
    }
}
