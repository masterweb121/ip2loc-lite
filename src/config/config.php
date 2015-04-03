<?php

return [
    'user' => [
        'username' => 'nemanja.cimbaljevic@codeanvil.co', //email address for IP2Location service
        'password' => 'REPQFE99', //password for IP2Location service
        'rememberMe' => 'on', //can be "on" or "off"
        ''
    ],

    'databases' => [
        //TODO: 'DB1LITE', //IP-Country Database
        'DB3LITE', //IP-Country-Region-City Database
        //TODO: 'DB5LITE', //IP-Country-Region-City-Latitude-Longitude Database
        //TODO: 'DB9LITE', //IP-Country-Region-City-Latitude-Longitude-ZIPCode Database
        //TODO: 'DB11LITE', //IP-Country-Region-City-Latitude-Longitude-ZIPCode-TimeZone Database
    ],

    'storage' => 'mysql',
    'table_prefix' => 'ip2loc_',

    'loginPagePath' => 'https://www.ip2location.com/login',
    'accountPagePath' => 'https://www.ip2location.com/account',
    'downloadPagePath' => 'https://www.ip2location.com/download',

    'storagePath' => storage_path('ip2loc-lite'),
    'cookiePath' => storage_path('ip2loc-lite') . '/cookies/autologin.cookie',
];