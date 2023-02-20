<?php

namespace App\Console\Commands;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

use Illuminate\Console\Command;
use App\Http\Controllers\NewsApiController;

class NewsLoader extends Command
{
    protected $signature = 'api:newsloader';
    protected $description = 'Load fresh news from news Api to Rabbit Queue';

    public function handle()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('fetchNewsDataApi', false, true, false, false);
        $datas = NewsApiController::loadNewsFromSource();
        // dump($datas);
        $msg = new AMQPMessage(json_encode($datas));
        // dump($msg);
        $channel->basic_publish($msg, '', 'fetchNewsDataApi');
        $channel->close();
        $connection->close();
    }
}
