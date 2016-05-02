<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('password');
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('business_unit_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('manager_id')->unsigned()->nullable();
            $table->boolean('vip');
            $table->boolean('is_ad');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('business_unit_id')->references('id')->on('business_units');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('manager_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
