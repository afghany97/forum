<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('cache:clear');

        Schema::create('trendings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id');
            $table->ipAddress('vistoer_ip');
            $table->unique(['thread_id' , 'vistoer_ip']);
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
        Schema::dropIfExists('trendings');
    }
}
