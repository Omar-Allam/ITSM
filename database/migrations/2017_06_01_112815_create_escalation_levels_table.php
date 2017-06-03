<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscalationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escalations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('sla_id');
            $table->integer('level');
            $table->integer('days')->nullable();
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();
            $table->tinyInteger('assigned')->default(0);
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
        Schema::dropIfExists('escalations');
    }
}
