<?php

//Config
//Timelimit 3 min
set_time_limit(3 * 60);

//Debug mode
$debug = true;

//Min Time between jobs in minutes
$betweenJobs['logs_grab'] = 1;
$betweenJobs['logs_process'] = 5;
$betweenJobs['rc_stats_grab'] = 60;
$betweenJobs['rc_stats_process'] = 60;
$betweenJobs['recordings_download'] = 30;

//Script runner
$loopDuration = 60; //time in seconds
//Clean up
$cleanUpDays = 0.1;

require ('../includes/include.php');

//if call is comming from CLI with arguments
if (isset($argv)) {
    foreach ($argv as $arg) {
        $e = explode('=', $arg);
        if (count($e) == 2)
            $_GET[$e[0]] = $e[1];
        else
            $_GET[$e[0]] = 0;
    }
}
//EOF: CLI

$queue = new JobQueue;

echo "I'm a worker! Lets check the board for jobs!<br />";

if (isset($_GET['tenantkey']) AND isset($_GET['doJob'])) {
    $queue->overideEnable($_GET['tenantkey'], $_GET['doJob']);
    echo('<p style="color: red; background-color: #ffff42; font-weight: 900;">WARNING! OVERRIDE IS ENABLED AND USING TENANT KEY: ' . $_GET['tenantkey'] . ' AND JOB IS: ' . $_GET['doJob'] . '</p>');
}

//While loop so we can do more in one run
// Set the start time
$startTime = time();
// Main while loop
while ((time() - $startTime) < $loopDuration) {

    $job = $queue->claimJob();

    if (is_array($job)) {
        echo"<h1>Job data</h1>" . PHP_EOL;
        echo "Job ID: ".$job['id']."<br />";
        echo "Tenant ID: ".$job['tenantID']."<br />";
        echo "Tenant Key: ".$job['tenantKEY']."<br />";
        echo "Type: ".$job['type']."<br />";
        echo "Start After: ".$job['startAfter']."<br />";
        echo"<pre>";
        //print_r($job); //Shows JWT Key!
        echo"</pre>";

        echo"<h1>Job Process</h1>";
        $worker = new Worker($job['tenantID'], $job['tenantKEY']);

        $fs_check = $worker->validate_folder_structure();
        if ($fs_check) {
            //init FS vars
            $fs = $worker->get_filesystem();
            //CODE
            $bench = new BenchMark();
            $bench->mark('start');

            if ($job['type'] === "logs_grab") {
                echo "Going to grab the logs from RingCentral<br />" . PHP_EOL;

                require 'jobs/logs/grab.php';

                if (isset($resp->records)) {
                    $job_result['status'] = "Completed";
                    $job_result['resultDescription'] = "Logs: Downloaded " . count($resp->records) . " logs";
                }
                else {
                    $job_result['status'] = "Failed";
                    $job_result['resultDescription'] = "Failed: Errorcode: $errorCode";
                }

                $queue->createJob($job['tenantID'], 'logs_grab', $betweenJobs['logs_grab']);
            }
            elseif ($job['type'] === "logs_process_v2") {
                echo "Going to process downloaded logs<br />" . PHP_EOL;

                require 'jobs/logs/process_v2.php';

                $job_result['status'] = "Completed";
                $job_result['resultDescription'] = "Logs: Added " . $logsWorkedOn . " to database!";
                $queue->createJob($job['tenantID'], 'logs_process_v2', $betweenJobs['logs_process']);
            }
            elseif ($job['type'] === "rc_stats_grab") {
                echo "Going to download the RingCentral Stats<br />" . PHP_EOL;

                require 'jobs/rc_stats/grab.php';

                $job_result['status'] = "Completed";
                $job_result['resultDescription'] = "Stats: Users: " . count($resp->records) . " Admins: " . $admincount;
                $queue->createJob($job['tenantID'], 'rc_stats_grab', $betweenJobs['rc_stats_grab']);
            }
            elseif ($job['type'] === "rc_stats_process") {
                $userCount = 0;
                $adminCount = 0;
                
                echo "Going to import the RingCentral Stats<br />" . PHP_EOL;

                require 'jobs/rc_stats/process.php';

                $job_result['status'] = "Completed";
                $job_result['resultDescription'] = "Stats: Users: " . $userCount . " Admins: " . $adminCount;
                $queue->createJob($job['tenantID'], 'rc_stats_process', $betweenJobs['rc_stats_process']);
            }
            elseif ($job['type'] === "recordings_download") {
                echo "Going to import the RingCentral Phone Recordings<br />" . PHP_EOL;

                require 'jobs/recordings/download.php';

                $job_result['status'] = "Completed";
                $job_result['resultDescription'] = "Recordings downloaded";
                $queue->createJob($job['tenantID'], 'recordings_download', $betweenJobs['recordings_download']);
            }
            elseif ($job['type'] === "cache_calculate") {
                echo "Going to calculate the cache value's<br />" . PHP_EOL;

                require 'jobs/cache/calculate.php';
            }
            elseif ($job['type'] === "remove_voicemails") {
                echo "Going to Remove Voicemails<br />" . PHP_EOL;

                require 'jobs/remove-voicemails.php';
            }
            else {
                echo "Type unknown! <br />" . PHP_EOL;

                $job_result['status'] = "Failed";
                $job_result['resultDescription'] = "No type or incorrect type" . PHP_EOL;

                break;
            }

            $bench->mark('stop');

            if (!$queue->overrideStatus()) {
                $time = $bench->time_between('start', 'stop');
                $queue->finishJob($job['id'], $job_result['status'], $job_result['resultDescription'], $time);
            }
            //EOF CODE
        }
        else {
            print_r($fs_check);
        }

        if (isset($_GET['tenantkey']) AND isset($_GET['doJob'])) {
            break;
        }
    }
    else {
        echo "No jobs on the board for now.<br />" . PHP_EOL;

        break; //Dont kill the worker just stop the while loop and wait for the next minute :)
    }
}

//Check if there are overdue jobs
echo "<hr />";
echo "<h1>Checking for old jobs!</h1><br />";
$timestamp = time() - 600;

//$stuckJobs = DB::query("SELECT * FROM worker_jobs WHERE status = %s AND startTime IS NOT NULL AND endTime IS NULL AND startTime <= %i ORDER BY startAfter ASC", 'In Progress', $timestamp);
$stuckJobs = $queue->stuckJobs();

if (count($stuckJobs) !== 0) {
    $tenantInfo = new Tenant();

    echo "Oh no some jobs are stuck!<br />";
    echo "<table border=1>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Tenant</th>";
    echo "<th>Type</th>";
    echo "<th>Starttime</th>";
    echo "<th>Duration</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($stuckJobs as $stuck) {
        $runTime = $timestamp - $stuck['startTime'];
        $tenantInfoData = $tenantInfo->find_tenant($stuck['tenant']);
        echo "<tr>";
        echo "<td>" . $stuck['id'] . "</td>";
        echo "<td>" . $tenantInfoData['tenantkey'] . "</td>";
        echo "<td>" . $stuck['type'] . "</td>";
        echo "<td>" . date("Y-m-d H:i:s", $stuck['startTime']) . "</td>";
        echo "<td>" . gmdate("H:i:s", $runTime) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
else {
    echo "No jobs are STUCK!<br />";
}

echo "<hr />";
echo"<h1>Clean Up database by removing Completed jobs older than 1 day</h1>" . PHP_EOL;

echo "Removing completed jobs older than " . $cleanUpDays . " day(s)<br />" . PHP_EOL;

echo "Removed " . $queue->cleanJobQueue($cleanUpDays) . " jobs<br />" . PHP_EOL;

