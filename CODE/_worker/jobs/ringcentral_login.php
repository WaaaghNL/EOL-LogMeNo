<?php

//Connect to ringcentral
//LogMeNo
$rcsdk = new RingCentral\SDK\SDK('CLIENT_KEY', 'CLIENT_SECRET', 'https://platform.ringcentral.com');

//Start de Platform class
$platform = $rcsdk->platform();

//Login op het platform
$authFile = $fs['secrets'] . "rc-auth.json"; //Waar de login token is opgeslagen
if (file_exists($authFile)) {
    //Login met bestaande creds
    $platform->auth()->setData(json_decode(file_get_contents($authFile), true));
}

//Als login mislukt is
if (!$platform->loggedIn()) {
    //Login

    $platform->login(['jwt' => $job['tenantJWT']]);

    //Sla sessie op in de auth file
    file_put_contents($authFile, json_encode($platform->auth()->data(), JSON_PRETTY_PRINT));
}
