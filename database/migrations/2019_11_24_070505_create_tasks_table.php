<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->text('comment')->nullable();
            $table->unsignedInteger('status_id');
            $table->boolean('check');
            $table->time('planned_time');
            $table->time('worked_time')->default('00:00:00');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('moscow_id');
            $table->foreign('moscow_id')->references('id')->on('moscow');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
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
