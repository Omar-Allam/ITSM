<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSDPConversationIdToReplies extends Migration
{
    public function up()
    {
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->unsignedInteger('sdp_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->dropColumn('sdp_id');
        });
    }
}
