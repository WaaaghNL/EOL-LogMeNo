

<?php
require ('../../includes/include.php');
if ($_GET['log_id']){
    
}
else{
    exit('No CALL ID');
}

echo "<h1>Call based on CallID</h1><br />";
$getCall = DB::query("SELECT id, log_action, log_billing_costIncluded, log_billing_costPurchased, log_delegate_id, log_delegate_name, log_direction, log_durationMs, log_extension_id, log_extension_uri, log_from_dialerPhoneNumber, log_from_device_id, log_from_device_uri, log_from_extensionId, log_from_extensionNumber, log_from_location, log_from_name, log_from_phoneNumber, log_id, log_internalType, log_lastModifiedTime, log_message_id, log_message_type, log_message_uri, log_partyId, log_reason, log_reasonDescription, log_recording_saved, log_recording_id, log_result, log_sessionId, log_shortRecording, log_sipUuidInfo, log_startTime, log_telephonySessionId, log_to_dialedPhoneNumber, log_to_device_id, log_to_device_uri, log_to_extensionId, log_to_extensionNumber, log_to_location, log_to_name, log_to_phoneNumber, log_transferTarget_telephonySessionId, log_transferee_telephonySessionId, log_transport, log_type, version FROM `ringcentral_logrows` WHERE log_id = %s", $_GET['log_id']);
$getCall = $getCall[0];
echo "<pre>";
print_r($getCall);
echo "</pre>";

echo "<hr>";
echo "<h1>Call legs based on CallID</h1><br />";
$getCallLegs = DB::query("SELECT * FROM `ringcentral_logrows_legs` WHERE log_id = %s ORDER BY leg_startTime ASC", $_GET['log_id']);

echo "<table border=1>";
echo "<tr>";
echo "<th>Starttime</th>";
echo "<th>Action</th>";
echo "<th>Richting</th>";
echo "<th>Duur Sec</th>";
//echo "<th>from_dialerPhoneNumber</th>";
//echo "<th>from_device_id</th>";
echo "<th>from_extensionId</th>";
echo "<th>from_extensionNumber</th>";
echo "<th>from_name</th>";
echo "<th>from_phoneNumber</th>";
echo "<th>to_dialedPhoneNumber</th>";
//echo "<th>to_device_id</th>";
//echo "<th>to_extensionId</th>";
echo "<th>to_extensionNumber</th>";
echo "<th>to_name</th>";
echo "<th>to_phoneNumber</th>";
echo "<th>Master</th>";
echo "<th>reason</th>";
echo "<th>telephonySessionId</th>";
echo "<th>transferTarget_telephonySessionId</th>";
echo "<th>transferee_telephonySessionId</th>";
echo "</tr>";
foreach($getCallLegs as $leg){
    echo "<tr>";
    echo "<td>".$leg['leg_startTime']."</td>";
    echo '<td>'.$leg['leg_action']."</td>";
    echo "<td>".$leg['leg_direction']."</td>";
    echo "<td>".$leg['leg_duration']."</td>";
    //echo "<td>".$leg['leg_from_dialerPhoneNumber']."</td>";
    //echo "<td>".$leg['leg_from_device_id']."</td>";
    echo "<td>".$leg['leg_from_extensionId']."</td>";
    echo "<td>".$leg['leg_from_extensionNumber']."</td>";
    echo "<td>".$leg['leg_from_name']."</td>";
    echo "<td>".$leg['leg_from_phoneNumber']."</td>";
    echo "<td>".$leg['leg_to_dialedPhoneNumber']."</td>";
    //echo "<td>".$leg['leg_to_device_id']."</td>";
    //echo "<td>".$leg['leg_to_extensionId']."</td>";
    echo "<td>".$leg['leg_to_extensionNumber']."</td>";
    echo "<td>".$leg['leg_to_name']."</td>";
    echo "<td>".$leg['leg_to_phoneNumber']."</td>";
    echo "<td>".$leg['leg_master']."</td>";
    echo "<td>".$leg['leg_reason']."</td>";
    echo "<td>".$leg['leg_telephonySessionId']."</td>";
    echo "<td>".$leg['leg_transferTarget_telephonySessionId']."</td>";
    echo "<td>".$leg['leg_transferee_telephonySessionId']."</td>";
    echo "</tr>";
}
echo "</table>";

foreach($getCallLegs as $leg){
    echo "<pre>";
print_r($leg);
echo "</pre>";
}

exit();

echo "<hr>";
echo "<h1>Other calls legs with telephonySessionId</h1><br />";
$getCall = DB::query("SELECT * FROM `ringcentral_logrows_legs` WHERE telephonySessionId = %s", $getCall['telephonySessionId']);
echo "<pre>";
print_r($getCall);
echo "</pre>";

exit();

echo "<hr>";
echo "<h1>Other calls legs with partyId</h1><br />";
$getCall = DB::query("SELECT * FROM `ringcentral_logrows_legs` WHERE partyId = %s", $getCall['partyId']);
echo "<pre>";
print_r($getCall);
echo "</pre>";

exit();

echo "<hr>";
echo "<h1>Other calls with telephonySessionId</h1><br />";
$getCall = DB::query("SELECT * FROM `ringcentral_logrows` WHERE telephonySessionId = %s", $getCall['telephonySessionId']);
echo "<pre>";
print_r($getCall);
echo "</pre>";

exit();

echo "<hr>";
echo "<h1>Other calls with partyId</h1><br />";
$getCall = DB::query("SELECT * FROM `ringcentral_logrows` WHERE partyId = %s", $getCall['partyId']);
echo "<pre>";
print_r($getCall);
echo "</pre>";

exit();

echo "<hr>";
echo "<h1></h1><br />";
echo "<hr>";
echo "<h1></h1><br />";
echo "<hr>";
echo "<h1></h1><br />";