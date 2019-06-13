<?php

namespace App\Console\Commands;

use App\Models\Google_account;
use Illuminate\Console\Command;

class ResetGoogleAccountJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reset_ga';

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
        $update_query = [
            'is_active'  => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        Google_account::where('is_active', 0)
            ->update($update_query);
    }
}
