<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSrFlagCategoriesSubcatgoriesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('service_request')->default(0);
        });


        Schema::table('subcategories', function (Blueprint $table) {
            $table->tinyInteger('service_request')->default(0);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->tinyInteger('service_request')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('service_request');
        });


        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn('service_request');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('service_request');
        });
    }
}
