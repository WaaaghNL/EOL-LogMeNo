<?php

require ('../../includes/include.php');
require '../jobs/ringcentral_login.php';

try {
    $AccountInfo = $platform->get("/restapi/v1.0/account/~");
    $AccountInfo = $AccountInfo->json();

    //pre_dump($AccountInfo);

    $AccountBusinessAddress = $platform->get("/restapi/v1.0/account/~/business-address");
    $AccountBusinessAddress = $AccountBusinessAddress->json();

    //pre_dump($AccountBusinessAddress);

    $AccountServiceInfo = $platform->get("/restapi/v1.0/account/~/service-info");
    $AccountServiceInfo = $AccountServiceInfo->json();

    pre_dump($AccountServiceInfo->serviceFeatures);

    echo '<hr />';
    echo '<h1>Branding</h1>';
    echo 'ID: ' . $AccountInfo->serviceInfo->brand->id . '<br />';
    echo 'Name: ' . $AccountInfo->serviceInfo->brand->name . '<br />';
    echo '<h1>Regional Settings</h1>';
    echo '<h2>Timezone</h2>';
    echo 'ID: ' . $AccountInfo->regionalSettings->timezone->id . '<br />';
    echo 'Name: ' . $AccountInfo->regionalSettings->timezone->name . '<br />';
    echo 'Description: ' . $AccountInfo->regionalSettings->timezone->description . '<br />';
    echo 'TimeFormat: ' . $AccountInfo->regionalSettings->timeFormat . '<br />';
    echo '<h2>Country</h2>';
    echo 'ID: ' . $AccountInfo->regionalSettings->homeCountry->id . '<br />';
    echo 'Name: ' . $AccountInfo->regionalSettings->homeCountry->name . '<br />';
    echo '<h2>Language</h2>';
    echo 'ID: ' . $AccountInfo->regionalSettings->language->id . '<br />';
    echo 'Name: ' . $AccountInfo->regionalSettings->language->name . '<br />';
    echo 'Locale: ' . $AccountInfo->regionalSettings->language->localeCode . '<br />';

    echo '<h1>Company</h1>';
    echo 'street: ' . $AccountBusinessAddress->businessAddress->street . '<br />';
    echo 'city: ' . $AccountBusinessAddress->businessAddress->city . '<br />';
    echo 'zip: ' . $AccountBusinessAddress->businessAddress->zip . '<br />';
    echo 'country: ' . $AccountBusinessAddress->businessAddress->country . '<br />';
    echo 'company: ' . $AccountBusinessAddress->company . '<br />';
    echo 'email: ' . $AccountBusinessAddress->email . '<br />';

    echo '<h1>Service Features</h1>';
    echo '<table border=1>';
    echo '<tr><th>Feature</th><th>Status</th></tr>';
    foreach ($AccountServiceInfo->serviceFeatures as $feature) {
        echo '<tr><th>' . $feature->featureName . '</th><td>' . $feature->enabled . '</td></tr>';
    }
    echo '<table>';
}
catch (\RingCentral\SDK\Http\ApiException $e) {
    print_r($e->getMessage());
}