<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateUsersCareerJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_career_journal', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->foreign('user_id', 'user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->bigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnDelete();

            $table->integer('salary');
            $table->string('position');

            $table->date('started_at')->default(Carbon::now());
            $table->date('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_career_journal', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('department_id');
        });
        Schema::dropIfExists('users_career_journal');
    }
}
