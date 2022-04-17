<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_department', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');

            $table->bigInteger('user_id');
            $table->foreign('user_id', 'user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->bigInteger('department_id');
            $table->foreign('department_id', 'department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_department', function (Blueprint $table) {
            $table->dropForeign('department_id');
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('user_department');
    }
}
