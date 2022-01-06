<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSqlQueryHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sql_query_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');


            $table->bigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->text('sql');

            $table->timestamp('execution_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sql_query_history');
    }
}
