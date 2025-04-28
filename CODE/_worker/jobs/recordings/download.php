<?php

echo "Recording downloader<br />";

//Connect to ringcentral

require 'jobs/ringcentral_login.php';

$apiMax = 10; //API Limit

echo "Select 10 downloads from database where lastmodified is older than now -10 minutes (" . $apiMax . " = API limit/min)<br />";

$records = DB::query("SELECT `id`,`tenantid`,`log_id`,`log_lastModifiedTime`,`log_recording_contentUri` FROM `ringcentral_logrows` WHERE log_recording_contentUri IS NOT NULL AND tenantid = %i AND log_recording_saved IS NULL AND log_shortRecording IS NULL ORDER BY `ringcentral_logrows`.`id` ASC LIMIT %i", $job['tenantID'], $apiMax * 2);

echo "Selected records for download: " . count($records) . "<br />";
echo "<pre>";
print_r($records);
echo "</pre>";

echo "Try to download the records one by one<br />";

foreach ($records as $download) {
    echo "<pre>";
    print_r($download);
    echo "</pre>";
    try {
        $uri = $platform->createUrl($download['log_recording_contentUri'], array(
            'addServer' => false,
            'addMethod' => 'GET',
            'addToken' => true
        ));
        echo "<pre>";
        print_r($uri);
        echo "</pre>";
        $path = $fs['recordings'];
        $filename = $path . $job['tenantKEY'] . " - " . $download['log_recording_id'] . ".mp3";

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $uri);

            if ($response->getStatusCode() == 200) {

                $body = $response->getBody();

                file_put_contents($filename, $body);

                echo $filename . ': ' . filesize($filename) . ' bytes<br />';

                if (file_exists($filename) AND filesize($filename) <= 5) {
                    echo "UNLINK " . $filename . "<br />";
                    echo "update ID to FAILED<br />";
                    DB::update('ringcentral_logrows', array(
                        'log_recording_saved' => 'failed',
                            ), "id=%i", $download['id']);
                }
                else {
                    echo "insert recording to DB and call record ID to true.<br />";
                    DB::update('ringcentral_logrows', array(
                        'log_recording_saved' => true,
                            ), "id=%i", $download['id']);
                    DB::insert('ringcentral_recordings', array(
                        'tenant' => $job['tenantID'],
                        'log' => $download['id'],
                        'filename' => $filename,
                        'filesize' => filesize($filename),
                        'filetype' => mime_content_type($filename),
                    ));

                    $insert_id = DB::insertId(); // which id did it choose?!? tell me!!
                    echo "Succes with ID: " . $insert_id . " <br />";
                }

                // Check if a header exists.
                if ($response->hasHeader('X-Rate-Limit-Remaining')) {

                    if ($response->getHeader('X-Rate-Limit-Remaining')[0] != 0) {
                        echo "API Calls Remaining: " . $response->getHeader('X-Rate-Limit-Remaining')[0] . "<br />";
                        continue; //Go to next foreach item
                    }
                    else {
                        echo "NO API Calls Availeble, Stopping foreach!<br />";
                        break; //Break foreach
                    }
                }
                else {
                    echo "Unknown how many API Calls are availeble, Stopping foreach!<br />";
                    break; //Break foreach
                }
            }
        }
        catch (\GuzzleHttp\Exception\ClientException $exception) {
            // catches all ClientExceptions
            //print_r($exception->getResponse());
            if ($exception->getResponse()->getStatusCode() == 429) {
                echo "Oops toooooo many requests, easy boy! <br />";
                break; //break array when api limit is reached!
            }
        }
    }
    catch (\RingCentral\SDK\Http\ApiException $e) {
        print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
    }
}
echo "Done<br/>";
