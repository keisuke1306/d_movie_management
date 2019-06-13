<?php

namespace App\Services;

use App\Models\Daily_access;
use App\Models\Manage_user_ip;
use App\Models\Movie;

class MovieService
{

    /**
     * check_increase_access_count_flag
     * アクセス数を増加させて良いかどうかチェック
     * @param  string $movie_id
     * @return boolean true
     *         booleam false
     */
    public function check_increase_access_count_flag($movie_id)
    {
        $ip_number = ip2long($_SERVER["REMOTE_ADDR"]);

        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));

        $exists_check = Manage_user_ip::where('movie_id', $movie_id)
            ->where('ip_number', $ip_number)
            ->where('created_at', '>=', $yesterday)
            ->exists();

        // 24時間以降でのアクセスの時にカウントを増加させる
        if (!$exists_check) {
            $manage_user_ip_obj = new Manage_user_ip();
            $manage_user_ip_obj->ip_number = $ip_number;
            $manage_user_ip_obj->movie_id = $movie_id;
            $manage_user_ip_obj->count_flag = 2;
            $manage_user_ip_obj->save();

            return true;
        }

        return false;
    }

    /**
     * increase_access_count
     * 動画へのアクセス回数を増加させる
     * @param  string  $movie_id
     * @return boolean true
     */
    public function increase_access_count($movie_id)
    {
        $now_date = date('Y-m-d');

        $movie_obj = Movie::where('movie_id', $movie_id)
            ->first();

        $access_count = $movie_obj->access_count;
        $access_count++;
        $movie_obj->access_count = $access_count;
        $movie_obj->save();

        // デイリーのアクセスを管理するテーブルをチェック
        $daily_access_obj = Daily_access::where('movie_id', $movie_id)
            ->where('access_date', $now_date)
            ->first();

        if (!is_null($daily_access_obj)) {
            $daily_access_obj->increment('access_count');
        } else {
            $daily_access_obj = new Daily_access;
            $daily_access_obj->movie_id = $movie_id;
            $daily_access_obj->access_date = $now_date;
            $daily_access_obj->access_count = 1;
            $daily_access_obj->save();
        }

        return true;
    }

    /**
     * get_relate_movie
     * 関連動画を取得
     * @param  string $origin_movie_id
     * @param  int    $count
     * @return array  $movie_data
     */
    public function get_relate_movie($origin_movie_id, $count = 10)
    {
        $fetch_cols = [
            'movie_id',
            'title',
            'description',
            'thumbnail',
        ];

        // ID一覧を取得
        $ids_obj = Movie::select('id')
            ->where('movie_id', '<>', $origin_movie_id)
            ->where('status', 1)
            ->limit(10000)
            ->orderBy('id', 'DESC')
            ->get();
        $ids = array_pluck($ids_obj->toArray(), 'id');
        shuffle($ids);
        $relations_ids = array_slice($ids, 0, $count);

        // 関連の動画情報を取得
        $relate_movie_obj = Movie::whereIn('id', $relations_ids)
            ->get();

        return $relate_movie_obj;
    }
}
