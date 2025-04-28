<?php

class Logs {

    private $tenantID;
    private $tenantKEY;

    function setTenant($tenantID, $tenantKEY) {
        $this->tenantID = $tenantID;
        $this->tenantKEY = $tenantKEY;
    }

    function createLog($arrayLog, $filetype = 'Unknown') {
        DB::insert('ringcentral_logrows', array(
            'log_id' => $arrayLog['id'],
            'log_action' => $arrayLog['action'] ?? null,
            'log_billing_costIncluded' => $arrayLog['billing']['costIncluded'] ?? null,
            'log_billing_costPurchased' => $arrayLog['billing']['costPurchased'] ?? null,
            'log_delegate_id' => $arrayLog['delegate']['id'] ?? null,
            'log_delegate_name' => $arrayLog['delegate']['name'] ?? null,
            'log_deleted' => $arrayLog['deleted'] ?? null,
            'log_direction' => $arrayLog['direction'] ?? null,
            'log_duration' => $arrayLog['duration'] ?? null,
            'log_durationMs' => $arrayLog['durationMs'] ?? null,
            'log_extension_id' => $arrayLog['extension']['id'] ?? null,
            'log_extension_uri' => $arrayLog['extension']['uri'] ?? null,
            'log_from_dialerPhoneNumber' => $arrayLog['from']['dialerPhoneNumber'] ?? null,
            'log_from_device_id' => $arrayLog['from']['device']['id'] ?? null,
            'log_from_device_uri' => $arrayLog['from']['device']['uri'] ?? null,
            'log_from_extensionId' => $arrayLog['from']['extensionId'] ?? null,
            'log_from_extensionNumber' => $arrayLog['from']['extensionNumber'] ?? null,
            'log_from_location' => $arrayLog['from']['location'] ?? null,
            'log_from_name' => $arrayLog['from']['name'] ?? null,
            'log_from_phoneNumber' => $arrayLog['from']['phoneNumber'] ?? null,
            'log_internalType' => $arrayLog['internalType'] ?? null,
            'log_lastModifiedTime' => $arrayLog['lastModifiedTime'] ?? null,
            'log_message_id' => $arrayLog['message']['id'] ?? null,
            'log_message_type' => $arrayLog['message']['type'] ?? null,
            'log_message_uri' => $arrayLog['message']['uri'] ?? null,
            'log_partyId' => $arrayLog['partyId'] ?? null,
            'log_reason' => $arrayLog['reason'] ?? null,
            'log_reasonDescription' => $arrayLog['reasonDescription'] ?? null,
            'log_recording_contentUri' => $arrayLog['recording']['contentUri'] ?? null,
            'log_recording_id' => $arrayLog['recording']['id'] ?? null,
            'log_recording_type' => $arrayLog['recording']['type'] ?? null,
            'log_recording_uri' => $arrayLog['recording']['uri'] ?? null,
            'log_result' => $arrayLog['result'] ?? null,
            'log_sessionId' => $arrayLog['sessionId'] ?? null,
            'log_shortRecording' => $arrayLog['shortRecording'] ?? null,
            'log_sipUuidInfo' => $arrayLog['sipUuidInfo'] ?? null,
            'log_startTime' => $arrayLog['startTime'] ?? null,
            'log_telephonySessionId' => $arrayLog['telephonySessionId'] ?? null,
            'log_to_dialedPhoneNumber' => $arrayLog['to']['dialedPhoneNumber'] ?? null,
            'log_to_device_id' => $arrayLog['to']['device']['id'] ?? null,
            'log_to_device_uri' => $arrayLog['to']['device']['uri'] ?? null,
            'log_to_extensionId' => $arrayLog['to']['extensionId'] ?? null,
            'log_to_extensionNumber' => $arrayLog['to']['extensionNumber'] ?? null,
            'log_to_location' => $arrayLog['to']['location'] ?? null,
            'log_to_name' => $arrayLog['to']['name'] ?? null,
            'log_to_phoneNumber' => $arrayLog['to']['phoneNumber'] ?? null,
            'log_transferTarget_telephonySessionId' => $arrayLog['transferTarget']['telephonySessionId'] ?? null,
            'log_transferee_telephonySessionId' => $arrayLog['transferee']['telephonySessionId'] ?? null,
            'log_transport' => $arrayLog['transport'] ?? null,
            'log_type' => $arrayLog['type'] ?? null,
            'log_uri' => $arrayLog['uri'] ?? null,
            'tenantid' => $this->tenantID,
        ));

        return DB::insertId(); // which id did it choose?!? tell me!!
    }

    function updateLog($arrayLog, $filetype = 'Unknown') {
        $existingLog = $this->getLog($arrayLog['id']);
        pre_dump($existingLog);
        DB::update('ringcentral_logrows', array(
            'log_action' => $arrayLog['action'] ?? null,
            'log_billing_costIncluded' => $arrayLog['billing']['costIncluded'] ?? null,
            'log_billing_costPurchased' => $arrayLog['billing']['costPurchased'] ?? null,
            'log_delegate_id' => $arrayLog['delegate']['id'] ?? null,
            'log_delegate_name' => $arrayLog['delegate']['name'] ?? null,
            'log_deleted' => $arrayLog['deleted'] ?? null,
            'log_direction' => $arrayLog['direction'] ?? null,
            'log_duration' => $arrayLog['duration'] ?? null,
            'log_durationMs' => $arrayLog['durationMs'] ?? null,
            'log_extension_id' => $arrayLog['extension']['id'] ?? null,
            'log_extension_uri' => $arrayLog['extension']['uri'] ?? null,
            'log_from_dialerPhoneNumber' => $arrayLog['from']['dialerPhoneNumber'] ?? null,
            'log_from_device_id' => $arrayLog['from']['device']['id'] ?? null,
            'log_from_device_uri' => $arrayLog['from']['device']['uri'] ?? null,
            'log_from_extensionId' => $arrayLog['from']['extensionId'] ?? null,
            'log_from_extensionNumber' => $arrayLog['from']['extensionNumber'] ?? null,
            'log_from_location' => $arrayLog['from']['location'] ?? null,
            'log_from_name' => $arrayLog['from']['name'] ?? null,
            'log_from_phoneNumber' => $arrayLog['from']['phoneNumber'] ?? null,
            'log_id' => $arrayLog['id'],
            'log_internalType' => $arrayLog['internalType'] ?? null,
            'log_lastModifiedTime' => $arrayLog['lastModifiedTime'] ?? null,
            'log_message_id' => $arrayLog['message']['id'] ?? null,
            'log_message_type' => $arrayLog['message']['type'] ?? null,
            'log_message_uri' => $arrayLog['message']['uri'] ?? null,
            'log_partyId' => $arrayLog['partyId'] ?? null,
            'log_reason' => $arrayLog['reason'] ?? null,
            'log_reasonDescription' => $arrayLog['reasonDescription'] ?? null,
            'log_recording_contentUri' => $arrayLog['recording']['contentUri'] ?? null,
            'log_recording_id' => $arrayLog['recording']['id'] ?? null,
            'log_recording_type' => $arrayLog['recording']['type'] ?? null,
            'log_recording_uri' => $arrayLog['recording']['uri'] ?? null,
            'log_result' => $arrayLog['result'] ?? null,
            'log_sessionId' => $arrayLog['sessionId'] ?? null,
            'log_shortRecording' => $arrayLog['shortRecording'] ?? null,
            'log_sipUuidInfo' => $arrayLog['sipUuidInfo'] ?? null,
            'log_startTime' => $arrayLog['startTime'] ?? null,
            'log_telephonySessionId' => $arrayLog['telephonySessionId'] ?? null,
            'log_to_dialedPhoneNumber' => $arrayLog['to']['dialedPhoneNumber'] ?? null,
            'log_to_device_id' => $arrayLog['to']['device']['id'] ?? null,
            'log_to_device_uri' => $arrayLog['to']['device']['uri'] ?? null,
            'log_to_extensionId' => $arrayLog['to']['extensionId'] ?? null,
            'log_to_extensionNumber' => $arrayLog['to']['extensionNumber'] ?? null,
            'log_to_location' => $arrayLog['to']['location'] ?? null,
            'log_to_name' => $arrayLog['to']['name'] ?? null,
            'log_to_phoneNumber' => $arrayLog['to']['phoneNumber'] ?? null,
            'log_transferTarget_telephonySessionId' => $arrayLog['transferTarget']['telephonySessionId'] ?? null,
            'log_transferee_telephonySessionId' => $arrayLog['transferee']['telephonySessionId'] ?? null,
            'log_transport' => $arrayLog['transport'] ?? null,
            'log_type' => $arrayLog['type'] ?? null,
            'log_uri' => $arrayLog['uri'] ?? null,
            'tenantid' => $this->tenantID,
            'version' => $existingLog['version'] + 1,
                ), "log_id=%s", $arrayLog['id']);
    }

    function createLeg($arrayLeg, $log_id) {
        DB::insert('ringcentral_logrows_legs', array(
            'leg_action' => $arrayLeg['action'] ?? null,
            'leg_billing_costIncluded' => $arrayLeg['billing']['costIncluded'] ?? null,
            'leg_billing_costPurchased' => $arrayLeg['billing']['costPurchased'] ?? null,
            'leg_delegate_id' => $arrayLeg['delegate']['id'] ?? null,
            'leg_delegate_name' => $arrayLeg['delegate']['name'] ?? null,
            'leg_direction' => $arrayLeg['direction'] ?? null,
            'leg_duration' => $arrayLeg['duration'] ?? null,
            'leg_durationMs' => $arrayLeg['durationMs'] ?? null,
            'leg_extension_id' => $arrayLeg['extension']['id'] ?? null,
            'leg_extension_uri' => $arrayLeg['extension']['uri'] ?? null,
            'leg_from_dialerPhoneNumber' => $arrayLeg['from']['dialerPhoneNumber'] ?? null,
            'leg_from_device_id' => $arrayLeg['from']['device']['id'] ?? null,
            'leg_from_device_uri' => $arrayLeg['from']['device']['uri'] ?? null,
            'leg_from_extensionId' => $arrayLeg['from']['extensionId'] ?? null,
            'leg_from_extensionNumber' => $arrayLeg['from']['extensionNumber'] ?? null,
            'leg_from_location' => $arrayLeg['from']['location'] ?? null,
            'leg_from_name' => $arrayLeg['from']['name'] ?? null,
            'leg_from_phoneNumber' => $arrayLeg['from']['phoneNumber'] ?? null,
            'leg_internalType' => $arrayLeg['internalType'] ?? null,
            'leg_legtype' => $arrayLeg['legType'] ?? null,
            'leg_master' => $arrayLeg['master'] ?? null,
            'leg_message_id' => $arrayLeg['message']['id'] ?? null,
            'leg_message_type' => $arrayLeg['message']['type'] ?? null,
            'leg_message_uri' => $arrayLeg['message']['uri'] ?? null,
            'leg_partyId' => $arrayLeg['partyId'] ?? null,
            'leg_reason' => $arrayLeg['reason'] ?? null,
            'leg_reasonDescription' => $arrayLeg['reasonDescription'] ?? null,
            'leg_recording_contentUri' => $arrayLeg['recording']['contentUri'] ?? null,
            'leg_recording_id' => $arrayLeg['recording']['id'] ?? null,
            'leg_recording_type' => $arrayLeg['recording']['type'] ?? null,
            'leg_recording_uri' => $arrayLeg['recording']['uri'] ?? null,
            'leg_result' => $arrayLeg['result'] ?? null,
            'leg_shortRecording' => $arrayLeg['shortRecording'] ?? null,
            'leg_sipUuidInfo' => $arrayLeg['sipUuidInfo'] ?? null,
            'leg_startTime' => $arrayLeg['startTime'] ?? null,
            'leg_telephonySessionId' => $arrayLeg['telephonySessionId'] ?? null,
            'leg_to_dialedPhoneNumber' => $arrayLeg['to']['dialedPhoneNumber'] ?? null,
            'leg_to_device_id' => $arrayLeg['to']['device']['id'] ?? null,
            'leg_to_device_uri' => $arrayLeg['to']['device']['uri'] ?? null,
            'leg_to_extensionId' => $arrayLeg['to']['extensionId'] ?? null,
            'leg_to_extensionNumber' => $arrayLeg['to']['extensionNumber'] ?? null,
            'leg_to_location' => $arrayLeg['to']['location'] ?? null,
            'leg_to_name' => $arrayLeg['to']['name'] ?? null,
            'leg_to_phoneNumber' => $arrayLeg['to']['phoneNumber'] ?? null,
            'leg_transferTarget_telephonySessionId' => $arrayLeg['transferTarget']['telephonySessionId'] ?? null,
            'leg_transferee_telephonySessionId' => $arrayLeg['transferee']['telephonySessionId'] ?? null,
            'leg_transport' => $arrayLeg['transport'] ?? null,
            'leg_type' => $arrayLeg['type'] ?? null,
            'log_id' => $log_id,
        ));

        return DB::insertId(); // which id did it choose?!? tell me!!
    }

    function removeLegs($log_id) {
        DB::delete('ringcentral_logrows_legs', 'log_id=%s', $log_id);
    }

    function processLegs($array) {
        if (isset($array['legs'])) {
            //1 remove legs
            echo "Remove legs<br />" . PHP_EOL;
            $this->removeLegs($array['id']);
            //2. Add legs
            echo "Add Legs<br />" . PHP_EOL;
            foreach ($array['legs'] as $leg) {
                $this->createLeg($leg, $array['id']);
            }

            echo "Legs processed<br />" . PHP_EOL;
        }
        else {
            echo "No legs to add or update<br />" . PHP_EOL;
        }
    }

    function getLog($log_id) {
        $log = DB::query("SELECT * FROM ringcentral_logrows WHERE log_id=%s LIMIT 1", $log_id);
        return $log[0];
    }

    function checkLogExists($log_id) {
        $results = DB::query("SELECT id, log_id, log_lastModifiedTime FROM ringcentral_logrows WHERE log_id=%s", $log_id);
        $count_rows = count($results);
        if ($count_rows == 1) {
            return $results[0];
        }
        else {
            return false;
        }
    }

    function getFilesToProcess($path, $count = 10000) {
        $files = scandir($path, SCANDIR_SORT_ASCENDING);

        if (($key = array_search('.', $files)) !== false) {
            unset($files[$key]);
        }
        if (($key = array_search('..', $files)) !== false) {
            unset($files[$key]);
        }

        $files = array_slice($files, 0, $count, false);

        return $files;
    }
}
