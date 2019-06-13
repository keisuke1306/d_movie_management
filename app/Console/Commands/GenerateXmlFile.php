<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;

class GenerateXmlFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate_xml_file';

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

        $br = "\r\n";
        $app_url = config('movie_manage.app_url');
        $uri_word = config('movie_manage.uri_word');
        $url_data_arr = [
            0 => [
                'loc' => $app_url,
                'priority' => '1.0',
                'changefreq' => 'weekly',
            ],
            1 => [
                'loc' => "${app_url}/${uri_word}/home/",
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
            2 => [
                'loc' => "${app_url}/${uri_word}/ranking/",
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
            3 => [
                'loc' => "${app_url}/${uri_word}/actor/",
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
        ];

        $movie_data_obj = Movie::where('status', 1)
            ->get();

        $xml_string = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

__EOS__;

        foreach ($url_data_arr as $url_data) {
            $xml_string .= '<url>' . $br;
            $xml_string .= '<loc>' . $url_data['loc'] . '</loc>' . $br;
            $xml_string .= '<priority>' . $url_data['priority'] . '</priority>' . $br;
            $xml_string .= '<changefreq>' . $url_data['changefreq'] . '</changefreq>' . $br;
            $xml_string .= '</url>' . $br;
        }

        foreach ($movie_data_obj as $movie_data) {
            $xml_string .= '<url>' . $br;

            $url = "${app_url}/${uri_word}/movie/watch/" . $movie_data['movie_id'] . "/";
            $xml_string .= '<loc>' . $url . '</loc>' . $br;
            $xml_string .= '<priority>0.5</priority>' . $br;
            $xml_string .= '<changefreq>monthly</changefreq>' . $br;
            $xml_string .= '</url>' . $br;
        }

        $xml_string .= '</urlset>';

        $save_path = base_path('public') . '/sitemap.xml';

        file_put_contents($save_path, $xml_string);
    }
}
