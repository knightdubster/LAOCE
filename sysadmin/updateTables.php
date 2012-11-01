<?php

include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

//$userID="sss1";

mysql_query( "DELETE FROM CustomEvalArchive WHERE coursename = 'TESTING'");

//mysql_query( "DELETE FROM AssessmentsDescription WHERE AssessmentID = 2");

//mysql_query("INSERT INTO Answers (answerID, questionID, type, ratingvalue)VALUES (6, 4, 'mc-check', '4')");

//mysql_query("INSERT INTO AssessmentsDescription(assessmentID, assessName, description, author)VALUES ('1','Testing', 'A test assessment','srt142')");

//mysql_query("UPDATE Scoring SET coursename='RLST001', section='SP11_WD' WHERE coursename = 'RLST001" and section=SP11_WD'");

/*$count=1;
$query = mysql_query("SELECT * from Assessments ");
	while($row = mysql_fetch_array($query)){
	mysql_query("UPDATE Assessments SET questionorder='$count' WHERE questionID='$count'");
	$count++;
	}
*/


?>