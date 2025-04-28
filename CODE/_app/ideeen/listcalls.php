<?php
require ('../../includes/include.php');

echo "<h1>Calls</h1><br />";
$getCalls = DB::query("SELECT * FROM `ringcentral_logrows` ORDER BY log_startTime DESC LIMIT 50");

echo "<table border=1>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Starttime</th>";
echo "<th>Action</th>";
echo "<th>Richting</th>";
echo "<th>Duur Sec</th>";
echo "<th>From: extensionNumber;name;phoneNumber</th>";
echo "<th>To: dialedPhoneNumber;extensionNumber;name;phoneNumber</th>";
echo "<th>reason</th>";
echo "</tr>";
foreach($getCalls as $log){
    echo '<tr>';
    echo '<td><a href="call.php?log_id='.$log['log_id'].'">'.$log['log_id'].'</a></td>';
    echo "<td>".$log['log_startTime']."</td>";
    echo "<td>".$log['log_action']."</td>";
    echo "<td>".$log['log_direction']."</td>";
    echo "<td>".$log['log_duration']." sec</td>";
    echo "<td>".$log['log_from_extensionNumber'].";".$log['log_from_name'].";".$log['log_from_phoneNumber']."</td>";
    echo "<td>".$log['log_to_dialedPhoneNumber'].";".$log['log_to_extensionNumber'].";".$log['log_to_name'].";".$log['log_to_phoneNumber']."</td>";
    echo '<td title="'.$log['log_reasonDescription'].'">'.$log['log_reason'].'</td>';
    echo "</tr>";
    echo'<tr><td colspan = "100%">';
        $getCallLegs = DB::query("SELECT * FROM `ringcentral_logrows_legs` WHERE log_id = %s ORDER BY leg_startTime ASC", $log['log_id']);
        echo '<table border=1 bgcolor="#D1EABE">';
        echo "<tr>";
        echo "<th>Starttime</th>";
        echo "<th>Action</th>";
        echo "<th>Richting</th>";
        echo "<th>Duur Sec</th>";
        echo "<th>from_dialerPhoneNumber</th>";
        echo "<th>from_extensionNumber</th>";
        echo "<th>from_name</th>";
        echo "<th>from_phoneNumber</th>";
        echo "<th>to_dialedPhoneNumber</th>";
        echo "<th>to_extensionNumber</th>";
        echo "<th>to_name</th>";
        echo "<th>to_phoneNumber</th>";
        echo "<th>Reason</th>";
        echo "<th>Master</th>";
        echo "</tr>";
        foreach($getCallLegs as $leg){
            echo "<tr>";
            echo "<td>".$leg['leg_startTime']."</td>";
            echo '<td>'.$leg['leg_action']."</td>";
            echo "<td>".$leg['leg_direction']."</td>";
            echo "<td>".$leg['leg_duration']."</td>";
            echo "<td>".$leg['leg_from_dialerPhoneNumber']."</td>";
            echo "<td>".$leg['leg_from_extensionNumber']."</td>";
            echo "<td>".$leg['leg_from_name']."</td>";
            echo "<td>".$leg['leg_from_phoneNumber']."</td>";
            echo "<td>".$leg['leg_to_dialedPhoneNumber']."</td>";
            echo "<td>".$leg['leg_to_extensionNumber']."</td>";
            echo "<td>".$leg['leg_to_name']."</td>";
            echo "<td>".$leg['leg_to_phoneNumber']."</td>";
            echo "<td>".$leg['leg_reason']."</td>";
            echo "<td>".$leg['leg_master']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    echo '</td></tr>';
    if($log['log_direction'] == "Inbound"){
        echo'<tr><td colspan = "100%">';
            echo '<table border=1 bgcolor="#DFBEEA">';
            echo'<tr><th colspan = "100%">>>> Flow >>></th></tr>';
            echo "<tr>";
            foreach($getCallLegs as $leg){
                if($leg['leg_reason'] != "Not Answered"){
                    
                
                echo "<td>".$leg['leg_startTime']." - ".$leg['leg_duration']." Sec<br /><b>From:</b>".$leg['leg_from_extensionNumber'].";".$leg['leg_from_name'].";".$leg['leg_from_phoneNumber']."<br /><b>To:</b>".$leg['leg_to_dialedPhoneNumber'].";".$leg['leg_to_extensionNumber'].";".$leg['leg_to_name'].";".$leg['leg_to_phoneNumber']."<br /><b>".$leg['leg_reason']."</b></td>";
                echo "<td> >> </td>";
                }
            }
            echo "<td>STOP</td>";
            echo "</tr>";
            echo "</table>";
        echo '</td></tr>';
    }
}
echo "</table>";

foreach($getCalls as $log){
    echo "<pre>";
print_r($log);
echo "</pre>";
}

exit();