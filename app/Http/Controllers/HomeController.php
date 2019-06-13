<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Movie;

class HomeController extends BaseController
{
    protected $compact_arr = [];

    public function index()
    {
        $this->compact_arr = array_merge($this->compact_arr, [
            'new_movie_obj',
            'ranking_movie_obj',
        ]);

        $new_movie_obj = Movie::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $ranking_movie_obj = $this->get_ranking_movie(5);

        return view('home/index', compact($this->compact_arr));
    }
}
