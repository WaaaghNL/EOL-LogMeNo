<?php

require ('../../includes/include.php');

$getCall = DB::query("SELECT id,log_id,log_startTime,log_type,log_direction,log_action,log_transferTarget_telephonySessionId,log_transferee_telephonySessionId,log_reason,log_telephonySessionId,log_partyId FROM `ringcentral_logrows` WHERE log_id = %s", $_GET['log_id']);
$getCall = $getCall[0];
echo "<pre>";
print_r($getCall);
echo "</pre>";

echo "<hr>";
echo "<h1>Call legs based on CallID</h1><br />";
$getCall = DB::query("SELECT id,log_id,leg_startTime,leg_type,leg_internalType,leg_direction,leg_result,leg_telephonySessionId,leg_partyId,leg_legType,leg_master,leg_reason,leg_transferee_telephonySessionId,leg_transferTarget_telephonySessionId FROM `ringcentral_logrows_legs` WHERE log_id = %s", $_GET['log_id']);
echo "<pre>";
print_r($getCall);
echo "</pre>";

exit();

echo "<hr>";
echo "<h1>Other calls legs with telephonySessionId</h1><br />";
$getCall = DB::query("SELECT id,CallID,startTime,type,internalType,direction,result,telephonySessionId,partyId,legType,master,extension_id,extension_uri,from_device_id,from_device_uri,from_extensionId,from_extensionNumber,from_location,from_name,from_phoneNumber,reason,to_name,to_device_id,to_device_uri,to_extensionId,to_extensionNumber,to_location,to_phoneNumber,transferee_telephonySessionId,transferTarget_telephonySessionId FROM `ringcentral_logrows_legs` WHERE telephonySessionId = %s", $getCall['telephonySessionId']);
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
