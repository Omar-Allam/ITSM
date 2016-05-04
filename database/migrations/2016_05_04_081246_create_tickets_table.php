<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requester_id')->unsigned();
            $table->integer('creator_id')->unsigned();
            $table->integer('coordinator_id')->unsigned()->nullable();
            $table->integer('technician_id')->unsigned()->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('subject');
            $table->text('description');
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('priority_id')->unsigned()->nullable();
            $table->integer('impact_id')->unsigned()->nullable();
            $table->integer('urgency_id')->unsigned()->nullable();
            $table->integer('sla_id')->unsigned()->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('first_response_date')->nullable();
            $table->dateTime('resolve_date')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->integer('business_unit_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('time_spent')->default(0);
            $table->softDeletes();
            $table->timestamps();

            //Relation with users
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('coordinator_id')->references('id')->on('users');
            $table->foreign('technician_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');

            //Relation with status models
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->foreign('impact_id')->references('id')->on('impacts');
            $table->foreign('urgency_id')->references('id')->on('urgencies');
            $table->foreign('sla_id')->references('id')->on('slas');

            //Relation with categories
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');
            $table->foreign('item_id')->references('id')->on('items');

            //Relation with business
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    public function down()
    {
        Schema::drop('tickets');
    }
}