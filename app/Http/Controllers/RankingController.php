<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class RankingController extends BaseController
{
    protected $compact_arr = [];

    public function index()
    {
        $this->compact_arr = array_merge($this->compact_arr, [
            'ranking_movie_obj',
        ]);

        $ranking_movie_obj = $this->get_ranking_movie();

        return view('ranking/index', compact($this->compact_arr));
    }
}
