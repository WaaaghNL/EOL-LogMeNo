<?php

echo "RingCentral Stats importer" . "<br />";

$dirImport = $fs['rc_stats'].'import/';
$dirRaw = $fs['rc_stats'] . 'raw/';
$files = scandir($dirImport, SCANDIR_SORT_ASCENDING);

if (($key = array_search('.', $files)) !== false) {
    unset($files[$key]);
}
if (($key = array_search('..', $files)) !== false) {
    unset($files[$key]);
}

echo count($files) . " Files in import folder<br />";

foreach ($files as $file) {
    if (file_exists($dirImport . $file)) {

        $filecontents = file_get_contents($dirImport . $file);
        $filecontentsArray = json_decode($filecontents, true);

        $adminCount = 0;
        foreach ($filecontentsArray as $content) {
            if (isset($content['permissions']['admin']['enabled']) AND $content['permissions']['admin']['enabled'] === true) {
                $adminCount++;
            }
        }
        $userCount = count($filecontentsArray);
        echo "Users: " . $userCount . "<br />";
        echo "Admins: " . $adminCount . "<br />";

        $filename = str_replace(".json", "", $file); //remove extentie van filename
        $filename = explode(" - ", $filename); //Split filename
        echo $filename[0] . "<br />"; //log starttime
        //echo $filename[1]."<br />"; //log Counting 
        //echo $filename[2]."<br />"; //log Userlist 
        //Select from DB where timestamp and tenant id
        $dbResult = DB::query("SELECT * FROM ringcentral_counter WHERE timestamp = %s AND tenant = %i ORDER BY id ASC", $filename[0], $job['tenantID']);
        //If result is 0 do insert
        echo "DB Results : " . count($dbResult) . "<br />";
        
        if (count($dbResult) == 0) {
            echo "Insert <br />";
            DB::insert('ringcentral_counter', array(
                'tenant' => $job['tenantID'],
                'timestamp' => $filename[0],
                'count_users' => $userCount,
                'count_superadmins' => $adminCount,
                'proof_users' => $filecontents
            ));
        } elseif (count($dbResult) == 1) {
            echo "Update <br />";
            DB::update('ringcentral_counter', ['count_users' => $userCount, 'count_superadmins' => $adminCount, 'proof_users' => $filecontents], "id=%i", $dbResult['0']['id']);
        } else {
            echo "Duplicates for timestamp " . $filename[0] . " in tenant " . $job['tenantKEY'] . " <br />";
        }
        
        
        //Check if there is a RAW file of it, if yes remove the file other move
        if (file_exists($dirRaw . $file)) {
            unlink($dirRaw . $file);
        }
        else{
            echo "File is NOT in RAW<br />";
            echo "copy file<br />";
            rename($dirImport . $file, $dirRaw . $file);
            
        }
        //else update result
        //remove from pre-import
        //unlink($dir_import . $file);
    } else {
        echo "Filename: " . $file . " can't be imported. Error: 404<br />";
    }
    echo "<hr>";
}