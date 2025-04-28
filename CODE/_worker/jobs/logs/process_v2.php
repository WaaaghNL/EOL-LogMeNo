<?php

//Config
$files_run = 20000; //Aantal bestanden per keer verwerken
$dirImport = $fs['logs'] . 'import/';
$dirRaw = $fs['logs'] . 'raw/';

//Default info
$logsWorkedOn = 0;

//Code
echo "Log importer v2<br />";

$logClass = new Logs();
$logClass->setTenant($job['tenantID'], $job['tenantKEY']);
$files = $logClass->getFilesToProcess($dirImport, $files_run);

echo count($files) . " Files to import in this job<br />" . PHP_EOL;

foreach ($files as $file) {
    //Check if file exists
    if (file_exists($dirImport . $file)) {
        //Get file contents
        $filecontents = json_decode(file_get_contents($dirImport . $file), true);
        echo "<b>Filename:</b> " . $dirImport . $file . "<br />" . PHP_EOL;
        echo "<b>ID:</b> " . $filecontents['id'] . "<br />" . PHP_EOL;
        echo "<b>Time:</b> " . $filecontents['startTime'] . "<br />" . PHP_EOL;
        echo "<b>File lastModifiedTime:</b> " . $filecontents['lastModifiedTime'] ?? null . "<br />" . PHP_EOL;

        //Check if log regel al bestaat
        $logResult = $logClass->checkLogExists($filecontents['id']);

        if (!$logResult) {
            echo "No record, Please insert into DB<br />";
            $insert_id = $logClass->createLog($filecontents);

            echo "Succes with ID: " . $insert_id . " <br />" . PHP_EOL;

            $logClass->processLegs($filecontents);
        }
        else {
            // File datum bestaat en is > DB datum bestaat = Updaten, copy file
            //
            // File datum bestaat niet en DB datum bestaat = Niet updaten, Copy file
            // File datum bestaat en is < DB datum bestaat = Niet updaten, Copy file
            // File datum bestaat en is = DB datum bestaat = Niet updaten, Copy file
            if ($filecontents['lastModifiedTime'] > $logResult['log_lastModifiedTime'] ?? null) {
                echo "<br /><b>DB lastModifiedTime:</b> " . $logResult['log_lastModifiedTime'] . "<br />" . PHP_EOL;
                echo 'File timestamp is bigger than DB timestamp, update DB.<br />' . PHP_EOL;
                $logClass->updateLog($filecontents);

                $logClass->processLegs($filecontents);
            }
            else {
                echo "<b>DB lastModifiedTime:</b> " . $logResult['log_lastModifiedTime'] . "<br />" . PHP_EOL;
                echo "We don't need an update<br />" . PHP_EOL;
            }
        }

        echo"<b>Move Files</b><br />" . PHP_EOL;

        //Move File to verwerkt and raw
        $dirRawWithDate = $dirRaw . substr($filecontents['startTime'], 0, 4) . "/" . substr($filecontents['startTime'], 5, 2) . "/";

        if (!is_dir($dirRawWithDate)) {
            mkdir($dirRawWithDate, 0755, true);
        }

        $newfile = $filecontents['startTime'] . " - " . $filecontents['id'] . ".json";
        if (rename($dirImport . $file, $dirRawWithDate . $newfile)) {
            echo "Form: " . $dirImport . $file . "<br />" . PHP_EOL;
            echo "To: " . $dirRawWithDate . $newfile . "<br />" . PHP_EOL;
            echo "Status: Succes<br />" . PHP_EOL;
        }
        else {
            echo "Form: " . $dirImport . $file . "<br />" . PHP_EOL;
            echo "To: " . $dirRawWithDate . $newfile . "<br />" . PHP_EOL;
            echo "Status: Failed<br />" . PHP_EOL;
        }
    }
    else {
        echo "Filename: " . $file . " can't be imported. Error: 404<br />" . PHP_EOL;
    }

    //Add to log counter
    $logsWorkedOn++;
    echo "<hr />" . PHP_EOL;
}