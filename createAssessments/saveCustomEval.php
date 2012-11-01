<?php
//SAVE SCORE

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename = strtoupper($p_coursename);
$question=$p_question;

$datesubmitted=date("Y-m-d h:i");

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

//GET QUESTIONID'S SELECTED
//INSERT IN CustomEval TABLE IF NOT ALREADY THERE
foreach($question as $val){
	$query = mysql_query("SELECT * from CustomEval WHERE coursename='$coursename' AND questionID='$val'");
	$result = mysql_fetch_array($query);
	
	if(!isset($result['questionID'])){
		mysql_query("INSERT INTO CustomEval (coursename,instructorAssessment, questionID)VALUES ('$coursename',0,'$val')");
		}
}


//INSERT IN CustomEvalArchive TABLE IF NOT ALREADY THERE
foreach($question as $val){
	$query = mysql_query("SELECT * from CustomEvalArchive WHERE coursename='$coursename' AND questionID='$val'");
	$result = mysql_fetch_array($query);
	
	if(!isset($result['questionID'])){
		mysql_query("INSERT INTO CustomEvalArchive (coursename,instructorAssessment, questionID)VALUES ('$coursename',0,'$val')");
		}
}

//DISPLAY CUSTOM EVALUATION
$goto = "customEval.php?coursename=" . $coursename;
echo "<script> window.location.href = '$goto' </script>";
?>
