<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Movie;
use Illuminate\Http\Request;
use Log;

class ActorController extends BaseController
{
    protected $compact_arr = [];

    public function index()
    {
        $this->compact_arr = array_merge($this->compact_arr, [
            'movie_obj',
            'ranking_movie_obj',
            'search_params',
        ]);

        $movie_obj = Movie::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $search_params = [];

        return view('actor/index', compact($this->compact_arr));
    }

    public function search_movie(Request $request)
    {
        $this->compact_arr = array_merge($this->compact_arr, [
            'search_keyword',
            'movie_obj',
            'search_params',
        ]);

        $search_keyword = $request->input('search_keyword') ?? '';

        if ($search_keyword == '') {
            $search_keyword = $_GET['search_keyword'] ?? '';
        }

        Log::debug("search_keyword: ${search_keyword}");

        // 検索
        $query = Movie::query();

        // キーワード検索
        if ($search_keyword != '') {
            $query = $query->orWhere('title', 'LIKE', "%${search_keyword}%")
                ->orWhere('description', 'LIKE', "%${search_keyword}%");
        }

        $movie_obj = $query->orderBy('created_at', 'DESC')
            ->paginate(10);

        // 検索条件
        $search_params = [];
        if ($search_keyword != '') {
            $search_params['search_keyword'] = $search_keyword;
        }

        return view('actor/index', compact($this->compact_arr));
    }
}
