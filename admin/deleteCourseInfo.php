<?php


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID = $p_evalID;

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

$query = mysql_query("DELETE FROM CourseInfo WHERE evalID = '$evalID'");

//GO TO admin.php
$goto = "index.php";
echo "<script> window.location.href = '$goto' </script>";




?>

