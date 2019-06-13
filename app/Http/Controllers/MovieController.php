<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Movie;
use App\Services\MovieService;
use Log;

class MovieController extends BaseController
{
    protected $compact_arr = [];
    protected $movie_service;

    public function __construct()
    {
        $this->movie_service = app(MovieService::class);
    }

    public function watch($movie_id = '')
    {
        Log::info("movie_id: $movie_id");

        $this->compact_arr = array_merge($this->compact_arr, [
            'movie_obj',
            'movie_width',
            'movie_height',
            'relate_movie_data',
        ]);

        $movie_obj = Movie::where('movie_id', $movie_id)
            ->where('status', 1)
            ->first();

        // 存在チェック
        if (is_null($movie_obj)) {
            Log::error("invalid movie_id. movie_id:${movie_id}");
            return \Redirect::to(config('movie_manage.uri_word') . '/home/');
        }

        $increase_flg = $this->movie_service->check_increase_access_count_flag($movie_id);

        if ($increase_flg) {
            $this->movie_service->increase_access_count($movie_id);
        }

        // pc, sp
        $movie_width = '90%';
        $movie_height = '';
        switch (config('movie_manage.ua')) {
            case 'pc':
                $movie_height = '450';
                break;
            case 'sp':
                $movie_height = '200';
                break;
        }

        // 関連動画
        $relate_movie_data = $this->movie_service->get_relate_movie($movie_id);

        return view('movie/watch', compact($this->compact_arr));
    }
}
