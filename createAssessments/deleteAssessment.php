<html>
<head>
<title>Delete Assessment</title>
</head>
<body>

<?php

include "../dbconnect.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$assessmentID=$p_assessmentID;

//IS THIS ASSESSMENT BEING USED?
//CAN ONLY BE DELETED IF NOT ASSOCIATED WITH A COURSE SCHEDULE OF ASSESSMENTS
$query = ($db_handle->query("SELECT caID from CourseAssessments WHERE assessmentID = '$assessmentID'"));
	$result = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($result['caID'])){
		echo "<div align='center'><h3>This assessment is in use by a Course Schedule of Assessments<br/>It must be deleted there before it can be removed from the system.</h3></div>
		<script type='text/javascript'>
		setTimeout('goto()', 3000);
		function goto()
		history.go(-1);
		</script>";
		exit();
		}

//DELETE FROM CourseAssessments
foreach ($db_handle->query("SELECT caID from CourseAssessments WHERE assessmentID = '$assessmentID'") as $row){
	$caID=$row['caID'];
	
	//DELETE ALL FROM SCORING TABLE
	$query = $db_handle->exec( "DELETE FROM SCORING WHERE caID = '$caID'");
	
	//DELETE FROM COURSE ASSESSMENTS
	$query = $db_handle->exec( "DELETE FROM CourseAssessments WHERE caID = '$caID'");
}


//DELETE FROM AssessmentsDescription
$query = $db_handle->exec( "DELETE FROM AssessmentsDescription WHERE assessmentID = '$assessmentID'");


//GET ALL QUESTIONS FROM Assessments
//AND DELETE ANSWERS FOR THOSE QUESTIONS
foreach ($db_handle->query("SELECT questionID from Assessments WHERE assessmentID = '$assessmentID'") as $row){
      $questionID=$row['questionID'];
      //DELETE ALL ANSWERS FOR THIS questionID
      $query = $db_handle->exec( "DELETE FROM Answers WHERE questionID = '$questionID'");
      //DELETE THE QUESTION
      $query = $db_handle->exec( "DELETE FROM Questions WHERE questionID = '$questionID'");
}

//DELETE THE ASSESSMENT
$query = $db_handle->exec( "DELETE FROM Assessments WHERE assessmentID = '$assessmentID'");

//GO TO admin.php
$goto = "../instructor/instructor.php";
echo "<script> window.location.href = '$goto' </script>";

?>

</body>
</html>