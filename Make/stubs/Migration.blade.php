{!! '<' !!}?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create{{$class}}Table extends Migration
{
    public function up()
    {
        Schema::create('{{$table}}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('{{$table}}');
    }
}