## PHP Version
Min: 8.2

## Import SQL
import the SQL database

## Files to change
* "M:\Buraublad\LogMeNo\Code\logmeno.com\_worker\jobs\ringcentral_login.php" Line 5
* "M:\Buraublad\LogMeNo\Code\logmeno.com\_worker\_baremin\justthis.php" Line 7 + 23
* "M:\Buraublad\LogMeNo\Code\logmeno.com\includes\config\FileSystem.php" line 2
* "M:\Buraublad\LogMeNo\Code\logmeno.com\includes\config\Database.php" Line 3 + 4 + 5
* "M:\Buraublad\LogMeNo\Code\logmeno.com\includes\classes\Worker.php" Line 7

## every folder starting with an underscore is a subdomain
_website is the frontpage

## Create a Cron for the worker
depening on the amount of data returning run it every x period.

* * * * * /usr/bin/php /home/USERNAME/domains/logmeno.com/_worker/worker.php > /dev/null 2>&1