<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

//CHECK INSTRUSCTOR OR ADMIN ROLE - gets user info- $name
include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$answerID=$p_answerID;
$assessmentID=$p_assessmentID;

include "../dbconnect.php";

mysql_query( "DELETE FROM Answers WHERE answerID = '$answerID'");


//GO TO DISPLAY ASSESSMENT
$goto ="assessmentEdit.php?assessmentID=" . $assessmentID;
echo "<script> window.location.href = '$goto' </script>";

