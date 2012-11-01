<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

//CHECK INSTRUSCTOR OR ADMIN ROLE - gets user info- $name
include "validateID.php";


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$questionID=$p_questionID;
$assessmentID=$p_assessmentID;
$totalAnswers=$p_totalAnswers;
$question = $p_question;
$question = stripslashes($question);
$question = mysql_escape_string($question);
$question = nl2br($question);


//SAVE QUESTION
$query = mysql_query("UPDATE Questions SET questionText='$question' WHERE questionID = '$questionID'");

//SAVE ANSWERS
for ($i = 1; $i <= $totalAnswers; $i++){
	$answer= "p_answer" . $i;//this increments variable name called by $$answer
	$answerText=$$answer;
	$answerText=stripslashes($answerText);
	$answerText = mysql_escape_string($answerText);
	$answerText = nl2br($answerText);
	
	$answerNumber = "p_answerID-" . $i;
	$answerID = $$answerNumber;

	mysql_query("UPDATE Answers SET answerText='$answerText' WHERE answerID = '$answerID'");
	
	}
	
	
	//GO TO DISPLAY ASSESSMENT
	$goto ="assessmentEdit.php?assessmentID=" . $assessmentID;
	echo "<script> window.location.href = '$goto' </script>";


?>