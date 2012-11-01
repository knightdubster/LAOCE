<?php

 
$action                 = $_POST['action'];
$updateRecordsArray     = $_POST['recordsArray'];

include "../dbconnect.php";	

if ($action == "updateRecordsListings"){
 
    $listingCounter = 1;
    foreach ($updateRecordsArray as $recordIDValue) {
        $query = "UPDATE Assessments SET questionorder = " . $listingCounter . " WHERE questionID = " . $recordIDValue;
        mysql_query($query) or die('Error, insert query failed');
        $listingCounter = $listingCounter + 1;
    }
 
}

?>