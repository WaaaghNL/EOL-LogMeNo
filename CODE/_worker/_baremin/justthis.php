<?php

//This schript does just the bare minimum to get it approved

include ('../../includes/include.php');

//Connect to ringcentral
$rcsdk = new RingCentral\SDK\SDK('CLIENT_KEY', 'CLIENT_SECRET', 'https://platform.ringcentral.com'); //LogMeNo.com Production

//Start de Platform class
$platform = $rcsdk->platform();

//Login op het platform
$authFile = "./rc-auth.json"; //Waar de login token is opgeslagen
if (file_exists($authFile)) {
    //Login met bestaande creds
    $platform->auth()->setData(json_decode(file_get_contents($authFile), true));
}

//Als login mislukt is
if (!$platform->loggedIn()) {
    //Login
    $platform->login(['jwt' => 'JWT TOKEN']);

    //Sla sessie op in de auth file
    file_put_contents($authFile, json_encode($platform->auth()->data(), JSON_PRETTY_PRINT));
}

// Authenticate a user using a personal JWT token
try {
    $endpoint = "/restapi/v1.0/account/~/extension";
    $resp = $platform->get($endpoint);
    $jsonObj = $resp->json();
    foreach ($resp->json()->records as $record) {
        print("Extension: " . $record->extensionNumber);
        print("Name: " . $record->name);
        print("Type: " . $record->type . PHP_EOL);
    }
}
catch (\RingCentral\SDK\Http\ApiException $e) {
    exit("Unable to authenticate to platform. Check credentials. " . $e->message . PHP_EOL);
}

// Authenticate a user using a personal JWT token
try {
    $queryParams = array(
            //'page' => 000,
            //'perPage' => 000
    );
    $resp = $platform->get("/restapi/v1.0/account/~/active-calls", $queryParams);
    foreach ($resp->json()->records as $record) {
        pre_dump($record);
    }
    echo "<br />END OF FILE";
}
catch (\RingCentral\SDK\Http\ApiException $e) {
    exit("Unable to authenticate to platform. Check credentials. " . $e->message . PHP_EOL);
}
