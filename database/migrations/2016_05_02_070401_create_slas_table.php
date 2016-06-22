<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlasTable extends Migration
{
    public function up()
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('due_days')->nullable()->default(0);
            $table->integer('due_hours')->nullable()->default(0);
            $table->integer('due_minutes')->nullable()->default(0);
            $table->integer('response_days')->nullable()->default(0);
            $table->integer('response_hours')->nullable()->default(0);
            $table->integer('response_minutes')->nullable()->default(0);
            $table->boolean('critical')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('slas');
    }
}
