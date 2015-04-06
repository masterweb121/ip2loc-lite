<?php

namespace NemC\IP2LocLite\Facades;

use Illuminate\Support\Facades\Facade;

class IP2LocLite extends Facade
{
    public static function get($ip)
    {
        //trim IP just in case
        $ip = trim($ip);
        $longIp = ip2long($ip);
        if ($longIp !== false) {
            return static::$app['nemc_ip2loc-lite_helper']->getForLongIp($longIp);
        } else {
            return [];
        }

    }
    protected static function getFacadeAccessor()
    {
        return 'nemc_ip2loc-lite_helper';
    }
}