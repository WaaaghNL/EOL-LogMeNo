<?php

require 'jobs/ringcentral_login.php';

$syncConfigResults = 250; //Max 250

$syncTokenFile = $fs['secrets'] . "syncToken.json"; //
if (file_exists($syncTokenFile)) {
    //Login met bestaande creds
    $synctoken = json_decode(file_get_contents($syncTokenFile), true);

    // OPTIONAL QUERY PARAMETERS
    $queryParams = array(
        'syncType' => 'ISync',
        'syncToken' => $synctoken['syncToken'],
        'recordCount' => $syncConfigResults,
    );
}
else {
    // OPTIONAL QUERY PARAMETERS
    $queryParams = array(
        'syncType' => 'FSync',
        'dateFrom' => '2000-01-01T12:00:00.000Z',
        'recordCount' => $syncConfigResults,
        'statusGroup' => 'All',
        'view' => 'Detailed',
    );
}

try {
    $resp = $platform->get("/restapi/v1.0/account/~/call-log-sync", $queryParams);

    $resp = $resp->json();

    foreach ($resp->records as $record) {
        $sessionFile = $record->startTime . " - " . $record->id . ".json"; //Waar de login token is opgeslagen

        $sessionFile = str_replace(":", "_", $sessionFile);

        $sessionFolderImport = $fs['logs'] . "import";
        if (!file_exists($sessionFile)) {
            if (!is_dir($sessionFolderImport)) {
                mkdir($sessionFolderImport, 0755, true);
            }

            file_put_contents($sessionFolderImport . "/" . $sessionFile, json_encode($record, JSON_PRETTY_PRINT));
            echo "file created in Import: " . $sessionFile . "<br />" . PHP_EOL;
        }
        else {
            echo "file bestaat al: " . $sessionFolderRaw . "/" . $sessionFile . "<br />" . PHP_EOL;
        }
    }

    //Show Sync info
    //echo json_encode($resp->syncInfo, JSON_PRETTY_PRINT);
    //Save Sync info
    file_put_contents($syncTokenFile, json_encode($resp->syncInfo, JSON_PRETTY_PRINT));
}
catch (\RingCentral\SDK\Http\ApiException $e) {
    $errorMessage = $e->getMessage();
    $getCode = $pieces = explode("resulted in a `", $errorMessage);
    $errorCode = substr($getCode[1], 0, 3);

    echo $errorCode . "<br /><br /><br />";

    if ($errorCode == 400) {
        if (str_contains($errorMessage, 'syncToken')) {
            echo "Problemen with the syncToken, Sorry maar het wissen van de token is je enigste optie<br />";
            print 'Expected HTTP Error: ' . $errorMessage . PHP_EOL;
            //Remove token
            unlink($syncTokenFile);
        }
        else {
            echo "Error: Er is iets aan de hand, Parameter error: ";
            print 'Expected HTTP Error: ' . $errorMessage . PHP_EOL;
        }
    }
    elseif ($errorCode == 429) {
        echo "Error: teveel requests: ";
        print 'Expected HTTP Error: ' . $errorMessage . PHP_EOL;
    }
    else {
        print 'Expected HTTP Error: ' . $errorMessage . PHP_EOL;
    }
}