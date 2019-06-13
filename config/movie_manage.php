<?php

return [
    'app_url'                => env('APP_URL'),
    'youtube_api_debug_mode' => env('YOUTUBE_API_DEBUG_MODE'),

    'limit_count'            => env('LIMIT_COUNT'),

    'keni_type'              => env('KENI_TYPE', 'black'),
    'uri_word'               => env('URI_WORD'),
    'ja_word'                => env('JA_WORD'),
    'youtube_search_keyword' => env('YOUTUBE_SEARCH_KEYWORD'),
    'title_word'             => env('TITLE_WORD'),

    // URL
    'search_url'             => 'https://www.googleapis.com/youtube/v3/search',
    'get_video_url'          => 'https://www.googleapis.com/youtube/v3/videos',

    'upload_images'          => base_path('public/images/upload/'),

    'keywords'               => json_decode(env('TAG_WORDS'), true),

    'prefix'                 => 'ga',

    'ua'                     => isset($_SERVER['HTTP_USER_AGENT']) ? (((strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false)) ? 'sp' : 'pc') : '',

    'des_limit_count'        => isset($_SERVER['HTTP_USER_AGENT']) ? (((strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false)) ? 50 : 150) : '',

    'search_minutes'         => json_decode(env('SEARCH_MINUTES'), true),
    'ga_account'             => env('GA_ACCOUNT'),
];
