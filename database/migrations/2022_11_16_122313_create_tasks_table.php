<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->char('mnvu',12)->unique();
            $table->string('name_nv');
            $table->date('start_nv');
            $table->date('end_nv');
            $table->date('finish_nv')->nullable();
            $table->tinyInteger('status_nv')->default(0);
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('creat_id')->index();
            $table->timestamps();
        });
        Schema::table('tasks', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('creat_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
