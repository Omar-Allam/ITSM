<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovalEscalationToSla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slas', function (Blueprint $table) {
            $table->integer('approval_days')->nullable();
            $table->integer('approval_hours')->nullable();
            $table->integer('approval_minutes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slas', function (Blueprint $table) {
            $table->dropColumn('approval_days');
            $table->dropColumn('approval_hours');
            $table->dropColumn('approval_minutes');
        });
    }
}
