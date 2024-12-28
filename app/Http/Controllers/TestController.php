<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index(){
        $ipAddress = request()->ip();
        $dateTime = \Carbon\Carbon::now();
        $location = null;
        if ((!Cache::get('limit-fetch-ip-address') ) && ($ipAddress !== '127.0.0.1' && ($ipAddress !== '::1'))) {
            $response = Http::get("http://ip-api.com/php/".$ipAddress."?fields=country,regionName,city,as,query");
            $responseJson = unserialize($response->body());
            $responseJson['xrl'] = (int) $response->getHeader('x-rl')[0];
            $responseJson['xttl'] = (int) $response->getHeader('x-ttl')[0];
            if (!$responseJson['xrl']) {
                Cache::add('limit-fetch-ip-address', 'value', $responseJson['xttl']);
            }
            $location = $responseJson['regionName'].",".$responseJson['country'];
        }
        return [$ipAddress,$dateTime,$location];
    }
}
