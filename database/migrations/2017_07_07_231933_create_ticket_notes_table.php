<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->integer('user_id');
            $table->text('note');
            $table->tinyInteger('display_to_requester');
            $table->tinyInteger('email_to_technician');
            $table->tinyInteger('as_first_response');
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
        Schema::dropIfExists('ticket_notes');
    }
}
