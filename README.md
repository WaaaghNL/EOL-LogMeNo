## PHP Version
Min: 8.2

## Import SQL
import the SQL database

## Files to change
* "Code\_worker\jobs\ringcentral_login.php" Line 5
* "Code\_worker\_baremin\justthis.php" Line 7 + 23
* "Code\includes\config\FileSystem.php" line 2
* "Code\includes\config\Database.php" Line 3 + 4 + 5
* "Code\includes\classes\Worker.php" Line 7

## every folder starting with an underscore is a subdomain
_website is the frontpage

## Create a Cron for the worker
depening on the amount of data returning run it every x period.

* * * * * /usr/bin/php /home/USERNAME/domains/DOMAIN/_worker/worker.php > /dev/null 2>&1
