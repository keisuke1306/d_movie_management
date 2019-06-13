<?php

namespace App\Services;

use App\Models\Google_account;
use App\Models\Movie;
use Illuminate\Support\Facades\Cache;
use Log;

class YoutubeClientService
{
    protected $google_key = '';

    public function __construct() {}

    /**
     * search_movie_from_youtube
     * youtubeから動画検索を行い、動画を取得
     */
    public function search_movie_from_youtube()
    {
        Log::info('search_movie_from_youtube start.');

        $page_token = Cache::get('page_token') ?? '';
        $insert_count = 0;

        $google_key = $this->get_google_key();
        if ($google_key === false) {
            return false;
        }
        $this->google_key = $google_key;

        $api_count = 0;
        $limit_count = config('movie_manage.limit_count');

        while (true) {
            $keyword = config('movie_manage.youtube_search_keyword');
            $query = [
                'type' => 'video',
                'part' => 'snippet',
                'q' => $keyword,
                'pageToken' => $page_token,
                'key' => $this->google_key,
            ];
            $query_string = "?type=video&part=snippet&q=${keyword}&pageToken=${page_token}&key={$this->google_key}";

            $result = $this->send_curl(config('movie_manage.search_url'), $query_string);
            $api_count++;

            $page_token = $result['nextPageToken'] ?? '';

            // daily limit
            if (isset($result['error'])
                && $result['error']['code'] == '403') {
                Log::error(json_encode($result['error'], true));

                $this->unactive_google_key($this->google_key);

                // 次のgoogle_keyを取得
                $google_key = $this->get_google_key();
                if ($google_key === false) {
                    return false;
                }
                $this->google_key = $google_key;
                continue 1;
            }

            // limitならばbreak
            if ($api_count > $limit_count) {
                Log::info('== reach limit ==');
                break;
            }

            try {
                if (isset($result['items'])) {
                    foreach ($result['items'] as $item) {
                        $snippet = $item['snippet'];

                        $video_id = $item['id']['videoId'];

                        $exist_check = Movie::where('video_id', $video_id)
                            ->exists();

                        // 重複チェック.重複しないならばインサート
                        if ($exist_check) {
                            continue 1;
                        }
                        // 詳細な情報を取得
                        $video_info = $this->get_info_by_video_id($video_id);
                        $api_count++;

                        $video_snippet = $video_info['items'][0]['snippet'];

                        // タイトル
                        $title = $video_snippet['title'] ?? '';

                        // 詳細
                        $description = $video_snippet['description'] ?? '';

                        // サムネイル画像
                        $thumbnail_url = $snippet['thumbnails']['high']['url'];
                        $thumbnail_data = file_get_contents($thumbnail_url);
                        $image_file_name = uniqid() . ".jpg";
                        file_put_contents(config('movie_manage.upload_images') . $image_file_name, $thumbnail_data);

                        $insert_query = [
                            'movie_id' => config('movie_manage.prefix') . uniqid() . date('His'),
                            'title' => $title,
                            'video_id' => $video_id,
                            'status' => 1,
                            'description' => $description,
                            'thumbnail' => $image_file_name,
                            'ability_status' => 0,
                        ];
                        Movie::create($insert_query);
                        $insert_count++;
                    }
                }
            } catch (\Exception $e) {
                Log::alert($e->getMessage());
                continue 1;
            }

            if ($insert_count >= 5) {
                break;
            } else {
                sleep(1);
            }
        }

        // cache
        Cache::put('page_token', $page_token, 18000);

        Log::info("api_count: ${api_count}");
        Log::info('search_movie_from_youtube end.');
    }

    private function send_curl($api_url, $query_string)
    {
        $url = $api_url . $query_string;

        $curl = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);

        return $result;
    }

    /**
     * 動画詳細情報取得
     *
     */
    public function get_info_by_video_id($video_id)
    {
        $google_key = $this->get_google_key();
        if ($google_key === false) {
            return false;
        }
        $this->google_key = $google_key;

        $query_string = "?part=snippet&id=${video_id}&key={$this->google_key}";
        $url = config('movie_manage.get_video_url');

        return $this->send_curl($url, $query_string);
    }

    private function get_google_key()
    {
        // google keyの取得
        $google_account_obj = Google_account::where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->first();

        if (is_null($google_account_obj)) {
            Log::alert('active google account is nothing.');
            return false;
        }
        return $google_account_obj->google_key;
    }

    /**
     * 制限に達したgoogle keyをオフにする
     *
     * @param String $google_key
     */
    private function unactive_google_key($google_key)
    {
        $google_account_obj = Google_account::where('google_key', $google_key)
            ->first();

        $google_account_obj->is_active = 0;
        $google_account_obj->save();
    }

    public function update_video_info($key = '')
    {
        if ($key != $this->page_keys['update_video_info']) {
            redirect('/' . config('movie_manage.uri_word') . '/home/');
            return;
        }

        $cols = '*';
        $movie_data_arr = $this->batch_Model->get_movie_data($cols);

        foreach ($movie_data_arr as $movie_data) {
            $id = $movie_data['id'];
            $video_id = $movie_data['video_id'];

            $video_info = $this->get_info_by_video_id($video_id);
            if (count($video_info['items']) !== 0) {
                $video_snippet = $video_info['items'][0]['snippet'];

                // タイトル
                $title = $video_snippet['title'] ?? '';

                // 詳細
                $description = $video_snippet['description'] ?? '';

                $update_query = [
                    'id' => $id,
                    'title' => $title,
                    'description' => $description,
                    'video_id' => $video_id,
                ];
                $this->batch_Model->update_movie_data($update_query);
            } else {
                $update_query = [
                    'id' => $id,
                    'status' => 2,
                    'video_id' => $video_id,
                ];
                $this->batch_Model->update_movie_data($update_query);
            }
        }
    }

    /**
     * 動画情報のヘルスチェック
     * @param  string $video_id
     * @return bool
     */
    public function health_check($video_id)
    {
        $google_key = $this->get_google_key();
        if ($google_key === false) {
            return false;
        }
        $this->google_key = $google_key;

        $query_string = "?part=snippet&id=${video_id}&key={$this->google_key}";
        $url = config('movie_manage.get_video_url');

        $data = $this->send_curl($url, $query_string);

        if (!isset($data['items'])
            || count($data['items']) === 0) {
            return false;
        }

        return true;
    }
}
