<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessRuleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_rule_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_rule_id')->unsigned();
            $table->string('field');
            $table->string('label');
            $table->string('value');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('business_rule_id')->references('id')->on('business_rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('business_rule_actions');
    }
}
