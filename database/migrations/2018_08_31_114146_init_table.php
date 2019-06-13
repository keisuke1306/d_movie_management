<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // init table
        Schema::create('movie', function (Blueprint $table) {
            $table->integer('id', 10);
            $table->string('movie_id', 32)
                ->commeent('動画ID');
            $table->string('title', 500);
            $table->string('video_id', 190)
                ->comment('youtubeの動画ID');
            $table->tinyinteger('status')
                ->default(1)
                ->comment('公開/非公開');
            $table->integer('point')
                ->default(0)
                ->comment('動画の評価');
            $table->integer('access_count')
                ->default(0)
                ->comment('動画のアクセス数');
            $table->mediumText('description')
                ->nullable();
            $table->string('thumbnail', 255)
                ->nullable()
                ->comment('サムネイル画像');
            $table->mediumText('memo')
                ->nullable()
                ->comment('備考');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('manage_user_ip', function (Blueprint $table) {
            $table->integer('id', 10);
            $table->string('ip_number', 100)
                ->commeent('IPナンバー');
            $table->string('movie_id', 32)
                ->comment('動画ID');
            $table->tinyinteger('count_flag')
                ->default(1)
                ->comment('再生数を増やして良いかどうか(1: OK、2: NG)');
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
        Schema::dropIfExists('movie');
        Schema::dropIfExists('manage_user_ip');
    }
}
