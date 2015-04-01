<?php

return [
    'user' => [
        'username' => '', //email address for IP2Location service
        'password' => '', //password for IP2Location service
    ],
    'curl' => [
        'cookieName' => 'ip2location-autologin',
    ],
    'storage' => 'mysql',
    'table' => 'ip2loc',

    'loginPath' => 'https://www.ip2location.com/login',

    'storagePath' => storage_path('ip2loclite'),
];