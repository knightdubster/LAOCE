<?php
//called by createAssessment.php

import_request_variables("pg","p_");
$assessmentID = $p_assessmentID;
$assessName= $p_assessName;
$assessName = stripslashes($assessName);
$assessName = mysql_escape_string($assessName);
$description = $p_description;
$description = stripslashes($description);
$description = mysql_escape_string($description);


include "../dbconnect.php";

//UPDATE AssessmentsDescription TABLE
$query=mysql_query("UPDATE AssessmentsDescription SET assessName='$assessName', description='$description' WHERE assessmentID='$assessmentID'");



//GO TO addQuestion.php
$goto ="assessmentEdit.php?assessmentID=" . $assessmentID;
echo "<script> window.location.href = '$goto' </script>";

?>