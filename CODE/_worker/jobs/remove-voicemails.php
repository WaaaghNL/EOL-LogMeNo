<?php

require 'jobs/ringcentral_login.php';

try {
    $queryParams = array(
        'page' => 1,
        'perPage' => 50,
        'status' => array('Enabled', 'NotActivated'),
        'type' => array('User', 'DigitalUser')
    );

    $resp = $platform->get("/restapi/v1.0/account/~/extension", $queryParams);
    $resp = $resp->json();
    //print_r(json_encode($resp->records, JSON_PRETTY_PRINT));
    
    foreach($resp->records as $userInfo){
        //echo "User: ".$userInfo->id." ID: ".$message->id."<br />";
        
        try{
            // OPTIONAL QUERY PARAMETERS
            $queryParams = array(
                //'availability' => array( 'Alive', 'Deleted', 'Purged' ),
                //'conversationId' => 000,
                'dateFrom' => '2016-03-10T18:07:52.534Z',
                //'dateTo' => '<ENTER VALUE>',
                //'direction' => array( 'Inbound', 'Outbound' ),
                //'distinctConversations' => true,
                'messageType' => array('VoiceMail'),
                //'readStatus' => array( 'Read', 'Unread' ),
                //'page' => 000,
                //'perPage' => 10,
                //'phoneNumber' => '<ENTER VALUE>'
            );
        
            $resp2 = $platform->get("/restapi/v1.0/account/~/extension/".$userInfo->id."/message-store", $queryParams);
            $resp2 = $resp2->json();
            
            if(count($resp2->records)!=0){
                $return['user'] = "User: ".$userInfo->id." ID: ";
                
                $return['ids'] = null;
                foreach($resp2->records as $message){
                    $return['ids'].= $message->id.",";
                }
                $return['ids'] = rtrim($return['ids'], ',');
                print_r($return);
                echo "<br />";
                
                try{
                    $queryParams = array(
                        //'purge' => true,
                        //'conversationId' => 000
                    );
                    $r = $platform->delete("/restapi/v1.0/account/~/extension/".$userInfo->id."/message-store/".$return['ids'], $queryParams);
                }
                catch (\RingCentral\SDK\Http\ApiException $e) {
                    print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
                    echo "<pre>";
                
                    // In order to get Request and Response used to perform transaction:
                    $apiResponse = $e->apiResponse();
                    print_r($apiResponse->request());
                    print_r($apiResponse->response());
                
                    echo "</pre><hr />";
                }
                
            }
        } catch (\RingCentral\SDK\Http\ApiException $e) {
            print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
            echo "<pre>";
        
            // In order to get Request and Response used to perform transaction:
            $apiResponse = $e->apiResponse();
            print_r($apiResponse->request());
            print_r($apiResponse->response());
        
            echo "</pre><hr />";
        }
        sleep(2);
    }
} catch (\RingCentral\SDK\Http\ApiException $e) {
    print 'Expected HTTP Error: ' . $e->getMessage() . PHP_EOL;
    echo "<pre>";

    // In order to get Request and Response used to perform transaction:
    $apiResponse = $e->apiResponse();
    print_r($apiResponse->request());
    print_r($apiResponse->response());

    echo "</pre><hr />";
}
