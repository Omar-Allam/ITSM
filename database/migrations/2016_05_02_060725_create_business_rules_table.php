<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessRulesTable extends Migration
{
    public function up()
    {
        Schema::create('business_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('is_last')->default(0);
            $table->integer('position')->unsigned()->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('business_rules');
    }
}
