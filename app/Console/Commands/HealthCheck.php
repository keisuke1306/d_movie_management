<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Services\YoutubeClientService;
use Illuminate\Console\Command;
use Log;

class HealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:health_check';

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
        Log::info("Health check start.");

        // 過去1週間、ヘルスチェックをしていないIDを取得
        $date = date('Y-m-d', strtotime('-1 week', time()));
        $movie_obj = Movie::where('health_check_date', '<=', $date)
            ->limit(1000)
            ->where('status', 1)
            ->get();

        if (count($movie_obj) === 0) {
            return true;
        }

        $service = app(YoutubeClientService::class);

        // ヘルスチェック
        foreach ($movie_obj as $obj) {
            $video_id = $obj['video_id'];

            Log::debug($video_id);

            $is_exists = $service->health_check($video_id);
            if (!$is_exists) {
                $obj->status = 2;
            }

            // ヘルスチェック時間を保存
            $obj->health_check_date = date('Y-m-d');
            $obj->save();
        }

        Log::info("Health check end.");
    }
}
