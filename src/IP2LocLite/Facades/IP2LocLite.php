<?php

namespace NemC\IP2LocLite\Facades;

use Illuminate\Support\Facades\Facade;

class IP2LocLite extends Facade
{
    public static function get($ip)
    {
        $longIp = ip2long($ip);

        return static::$app['nemc_ip2loc-lite_helper']->getForLongIp($longIp);
    }
    protected static function getFacadeAccessor()
    {
        return 'nemc_ip2loc-lite_helper';
    }
}