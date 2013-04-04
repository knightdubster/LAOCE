<?php


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$rowID = $p_rowID;


//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

$query = mysql_query("DELETE FROM CourseAccess WHERE rowID = '$rowID'");

//GO TO admin.php
$goto = "courseAccess.php";
echo "<script> window.location.href = '$goto' </script>";




?>

