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

You can create cron entry so complete process is automated
Since there are 2 different commands you can make time difference when scripts would run
Or chain them inside call

ex. php artisan ip2loclite:download-csv DB3LITE && php artisan ip2loclite:import-csv

Script will automatically create different tables for every IP2Location database you download.
With default settings it would create table name prefixed ip2loc_ (ip2loc_db3 for DB3LITE IP2Location database)

