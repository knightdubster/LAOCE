<?php
//SAVE SCORE

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename = $p_coursename;
$question=$p_question;

$datesubmitted=date("Y-m-d h:i");

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

//GET QUESTIONID'S SELECTED

foreach($question as $val){
		mysql_query("DELETE FROM CustomEval WHERE coursename='$coursename' AND questionID = '$val'");
		}

//DISPLAY CUSTOM EVALUATION
$goto = "customEval.php?coursename=" . $coursename;
echo "<script> window.location.href = '$goto' </script>";
?>
