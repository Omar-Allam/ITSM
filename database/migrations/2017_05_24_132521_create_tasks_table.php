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
            $table->integer('ticket_id');
            $table->integer('status_id');
            $table->integer('group_id');
            $table->integer('technician_id');
            $table->integer('type_id');
            $table->integer('priority_id');
            $table->string('title');
            $table->string('description');
            $table->date('scheduled_start_from');
            $table->date('scheduled_start_to');
            $table->date('actual_start_from');
            $table->date('actual_start_to');
            $table->string('comments');
            $table->string('additional_cost');
            $table->string('created_by');
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
