<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexManageUserIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manage_user_ip', function (Blueprint $table) {
            $table->Index(['movie_id', 'ip_number', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_user_ip', function (Blueprint $table) {
            $table->dropIndex(['movie_id', 'ip_number', 'created_at']);
        });
    }
}
