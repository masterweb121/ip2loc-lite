# IP2LocLite
Laravel 4 integration for IP2Location Lite with database support and download.

You can consider this is Poor Man's IP2Location script where you have everything stored locally 
so there is no fear that your 3rd party service would be down.

You need to create your account on https://www.ip2location.com/
Then provide details inside config for ip2loc-lite.php inside your config dir.

This script supports only free mySQL database powered search at this point.
Revision one supports only DB3 that has Country Abbreviation code, Country name, State/Region name, City name.
 
Future updates will cover other 4 different databases.
Note that there is no information about State/Region Abbreviation code.

Script brings 3 new commands:
- ip2loclite:login
- ip2loclite:download-csv <database name to download>
- ip2loclite:import-csv <database name to download>

Installation
------------

It can be found on [Packagist](https://packagist.org/packages/nem-c/ip2loc-lite).
The recommended way is through [composer](http://getcomposer.org).

Edit `composer.json` and add:

```json
{
    "require": {
        "nem-c/ip2loc-lite": "~1.0"
    }
}
```

Find the `providers` array key in `config/app.php` and register the **Geocoder Service Provider**.

```php
'providers' => array(
    // ...

    'NemC\IP2LocLite\Providers\IP2LocLiteServiceProvider',
)
```

Usage
-----

```bash
$ php artisan ip2loclite:download-csv DB3LITE
```

```bash
$ php ip2loclite:import-csv DB3LITE
```

Automate whole process by chaining those 2 commands like
```bash
$ php artisan ip2loclite:download-csv DB3LITE && php ip2loclite:import-csv DB3LITE
```


Configuration
-------------

Add file name ip2loc-lite.php to app/config and use content below

```php
<?php

return [
    'username' => '', //your IP2Location account username
    'password' => '', //your IP2Location account password
    'rememberMe' => 'on',
];
```

License
-------

IP2Location LITE is released under the MIT License. See the bundled
[LICENSE](https://github.com/nem-c/ip2loc-lite/blob/master/LICENSE.txt)
file for details.