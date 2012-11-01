<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "../admin/validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename=strtoupper($p_coursename);

mysql_query("INSERT INTO CustomEval (coursename, instructorAssessment,questionID)VALUES ('$coursename',1, '$questionID')");

//GO TO QUESTION EDIT
$goto ="customEval.php?coursename=" . $coursename;
echo "<script> window.location.href = '$goto' </script>";

?>