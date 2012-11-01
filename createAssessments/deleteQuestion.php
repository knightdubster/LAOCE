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

//CONFIRM DELETE QUESTION AND ALL ASSOCIATED DATA
echo"<script type='text/javascript'>
		 answer = confirm('Warning: All data and instances of this question will be deleted. Proceed?');
	if (answer){
		//delete question
	}
	else{
		//RETURN TO EDIT PAGE
		window.location = 'assessmentEdit.php?assessmentID=" . $assessmentID . "';
	}
	</script>";


mysql_query( "DELETE FROM Assessments WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM Questions WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM Answers WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM Scoring WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM TextOption WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM CustomEval WHERE questionID = '$questionID'");

mysql_query( "DELETE FROM CustomEvalArchive WHERE questionID = '$questionID'");



//GO TO DISPLAY ASSESSMENT
$goto ="assessmentEdit.php?assessmentID=" . $assessmentID;
echo "<script> window.location.href = '$goto' </script>";

?>