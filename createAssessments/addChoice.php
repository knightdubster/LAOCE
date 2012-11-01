<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

//CHECK INSTRUSCTOR OR ADMIN ROLE - gets user info- $name
include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$questionID = $p_questionID;
$assessmentID = $p_assessmentID;



	//GET ID OF LAST ANSWER
	$query = mysql_query("SELECT answerID from Answers ORDER BY answerID DESC LIMIT 1");
	$result = mysql_fetch_array($query);
	$answerID = $result['answerID'] + 1;

	mysql_query("INSERT INTO Answers (answerID, questionID)VALUES ('$answerID', '$questionID')");

	//GO TO QUESTION EDIT
	$goto ="editQuestion.php?assessmentID=" . $assessmentID . "&questionID=" . $questionID;
	echo "<script> window.location.href = '$goto' </script>";


?>