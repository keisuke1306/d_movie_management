<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class BaseController extends Controller
{
    protected $compact;

    protected function get_ranking_movie($count = 10)
    {
        $movie_obj = Movie::where('status', 1)
            ->orderBy('access_count', 'DESC')
            ->limit($count)
            ->get();

        return $movie_obj;
    }
}
