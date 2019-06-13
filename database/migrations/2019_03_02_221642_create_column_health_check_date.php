<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnHealthCheckDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie', function (Blueprint $table) {
            $table->date('health_check_date')
                ->nullable()
                ->default('1000-01-01')
                ->after('memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie', function (Blueprint $table) {
            $table->dropColumn('health_check_date');
        });
    }
}
