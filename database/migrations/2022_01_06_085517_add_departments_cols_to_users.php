<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentsColsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name');
            $table->string('patronymic')->nullable();
            $table->string('phone');
            $table->softDeletes();
            $table->string('avatar')->nullable();
            $table->string('position');
            $table->integer('salary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('patronymic');
            $table->dropColumn('phone');
            $table->dropSoftDeletes();
            $table->dropColumn('avatar');
            $table->dropColumn('position');
            $table->dropColumn('salary');
        });
    }
}
