<?php

require 'jobs/ringcentral_login.php';

try {
    // OPTIONAL QUERY PARAMETERS
    // https://developers.ringcentral.com/api-reference/Extensions/listExtensions
    $queryParams = array(
        'perPage' => 1000,
        'status' => array('Enabled', 'NotActivated'),
        'type' => array('User', 'DigitalUser')
    );

    $resp = $platform->get("/restapi/v1.0/account/~/extension", $queryParams);
    $resp = $resp->json();

    $date = str_replace('+00:00', 'Z', date('c'));
    $date = str_replace(":", "_", $date);
    echo $date . '<br />';

    $dirRaw = $fs['rc_stats'] . "raw/";
    $dirImport = $fs['rc_stats'] . "import/";
    if (!is_dir($dirRaw)) {
        mkdir($dirRaw, 0755, true);
    }
    if (!is_dir($dirImport)) {
        mkdir($dirImport, 0755, true);
    }
    file_put_contents($dirRaw . $date . ".json", json_encode($resp->records, JSON_PRETTY_PRINT));
    file_put_contents($dirImport . $date . ".json", json_encode($resp->records, JSON_PRETTY_PRINT));

    echo "Users" . count($resp->records) . ' (Enabled, NotActivated)<br />';

    $admincount = 0;
    $admin = [];
    foreach ($resp->records as $record) {
        if ($record->permissions->admin->enabled) {
            //Add 1 to admin count
            $admincount++;

            //Add user to admin array
            $admin[] = array('id' => $record->id, 'user' => $record->name, 'admin' => $record->permissions->admin->enabled);
        }
    }
    echo "Admins " . $admincount . '<br />';
} catch (\RingCentral\SDK\Http\ApiException $e) {
    print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
    echo "<pre>";

    // In order to get Request and Response used to perform transaction:
    $apiResponse = $e->apiResponse();
    print_r($apiResponse->request());
    print_r($apiResponse->response());

    echo "</pre><hr />";
}
