<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NewsApiController extends Controller
{


    static public function newsApiCalls($params)
    {
        try {
            $client = new Client();
            $response = $client->request(
                'GET', 
                config('app.news_url').$params.'&apiKey='.config('app.news_api_key'));
                return json_decode($response->getBody()->getContents(), true);
            
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }


    static public function loadNewsFromSource($value='')
    {
        $source= (empty($value))?'techcrunch':$value;
        $params = 'top-headlines?sources='.$source;
        $response = self::newsApiCalls($params);
        return Arr::get($response,'articles');
    }
}
