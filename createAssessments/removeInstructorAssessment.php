<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "../admin/validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename=strtoupper($p_coursename);

mysql_query("DELETE FROM CustomEval WHERE coursename='$coursename' AND instructorAssessment=1");

//GO TO QUESTION EDIT
$goto ="customEval.php?coursename=" . $coursename;
echo "<script> window.location.href = '$goto' </script>";

?>