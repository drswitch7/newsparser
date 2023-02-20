<?php

namespace App\Console\Commands;

use App\Models\LatestNews;
use Illuminate\Console\Command;


class LoadNewsFormDB extends Command
{
    protected $signature = 'load:newsdata';
    protected $description = 'Load news data from database to blade //RabbitMQ';


    public function handle()
    {
        $datas = LatestNews::query()->where('status','!=','delete')->paginate(5);
        // dump($datas); die;

        view()->composer('datas', function ($view) use ($datas) {
            $view->with('data', $datas);
        });
    }
}
