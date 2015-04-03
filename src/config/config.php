<?php

return [
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