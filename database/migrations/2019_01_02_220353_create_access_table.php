<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('movie_id', 32);
            $table->date('access_date');
            $table->integer('access_count');
            $table->timestamps();

            $table->index(['movie_id', 'access_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_access');
    }
}
