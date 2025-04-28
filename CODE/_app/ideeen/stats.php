<?php
require ('../../includes/include.php');

$getStats = DB::query("SELECT DAYOFWEEK(log_StartTime) AS weekday, AVG(COUNT(*)) AS average_calls, MIN(COUNT(*)) AS min_calls, MAX(COUNT(*)) AS max_calls FROM ringcentral_logrows GROUP BY weekday ORDER BY weekday");
        
echo "<pre>";
print_r($getStats);
echo "</pre>";