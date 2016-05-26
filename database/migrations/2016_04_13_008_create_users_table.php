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
            $table->boolean('vip')->nullable();
            $table->boolean('phone')->nullable();
            $table->boolean('mobile1')->nullable();
            $table->boolean('mobile2')->nullable();
            $table->boolean('is_ad');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
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
