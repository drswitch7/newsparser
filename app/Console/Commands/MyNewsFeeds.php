<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\LatestNews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class MyNewsFeeds extends Command
{

    protected $signature = 'load:newsfeed';
    protected $description = 'Fetch News from RabbitMQ on News Loader API to Database';

    public function handle()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('fetchNewsDataApi', false, true, false, false);
        $callback = function (AMQPMessage $message) {

            $datas = json_decode($message->getBody(), true);

            foreach ($datas as $key => $data) 
            {
                if(LatestNews::query()->where('title',$data['title'])->count()>0)
                {
                    $lastUpdate= LatestNews::query()->where('title',$data['title'])->first();
                    
                    $note= 'Title: '.$lastUpdate->title.PHP_EOL;
                    $note.= 'News Published At: '.date('F jS, Y, H:ia',strtotime($lastUpdate->news_added_at)).PHP_EOL;
                    $note.= 'News DB Created at: '.$lastUpdate->created_at->format('F d, Y, H:ia').PHP_EOL.PHP_EOL;
                    $note.= '---------------------------------------------------------------'.PHP_EOL.PHP_EOL;
                    Log::info($note);
                }

                $uuId= (string) Str::orderedUuid();

                LatestNews::query()->updateOrCreate(
                [
                    'title' => $data['title'],
                ],
                [
                    'slug' => $data['title'],
                    'short_description' => $data['description'],
                    'description' => $data['content'],
                    'image' => $data['urlToImage'],
                    'news_added_at' => date('Y-m-d h:i:s', strtotime($data['publishedAt'])),
                    'token' => $uuId,
                ]);
            }
            
        };

        // start consuming messages from the queue
        $channel->basic_consume('fetchNewsDataApi', '', false, true, false, false, $callback);

        // keep consuming messages until interrupted
        while (count($channel->callbacks)) {
            $channel->wait();
        }

        // close the channel and connection
        $channel->close();
        $connection->close();
    }

}
