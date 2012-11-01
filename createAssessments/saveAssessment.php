<?php
//called by createAssessment.php

import_request_variables("pg","p_");
$assessName= $p_assessName;
$assessName = stripslashes($assessName);
$assessName = mysql_escape_string($assessName);
$description = $p_description;
$description = stripslashes($description);
$description = mysql_escape_string($description);


include "../dbconnect.php";

//WRITE TO AssessmentsDescription TABLE
mysql_query("INSERT INTO AssessmentsDescription(assessmentID, assessName, description, author)VALUES ('$p_assessmentID','$assessName', '$description','$p_userID')");



//GO TO addQuestion.php
$goto ="addQuestion.php?assessmentID=" . $p_assessmentID;
echo "<script> window.location.href = '$goto' </script>";

?>