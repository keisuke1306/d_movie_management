<?php

namespace App\Console\Commands;

use App\Services\YoutubeClientService;
use Illuminate\Console\Command;

class CreateSearchMovieJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_search_movie_job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (config('movie_manage.youtube_api_debug_mode')) {
            $this->main();
            return true;
        }

        // 現在の時間
        $minute = date('i');

        // 許可の時間
        $search_minutes = config('movie_manage.search_minutes');

        if (in_array($minute, $search_minutes, true) !== false) {
            $this->main();
        }
    }

    private function main()
    {
        // service
        $youtube_client = app(YoutubeClientService::class);

        // 動画取得
        $youtube_client->search_movie_from_youtube();
    }
}
