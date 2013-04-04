<?php
//SAVE SCORE

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$coursename=$p_coursename;
$coursename = strtoupper($p_coursename);
checkit($coursename);
$firstname=ucfirst($p_firstname);
checkit($firstname);
$lastname= ucfirst($p_lastname);
checkit($lastname);
$instructorID=strtolower($p_instructorID);
checkit($instructorID);

function checkit($formvalue){
	if($formvalue ==""){
			echo"<script>
        alert('Please complete all entries in the form');
        history.go(-1);
        </script>";
        exit();
        }
   }



$query = mysql_query("INSERT INTO CourseAccess (coursename, userID, firstname, lastname)VALUES ('$coursename','$instructorID','$firstname','$lastname')");

//GO TO admin.php
$goto = "courseAccess.php";
echo "<script> window.location.href = '$goto' </script>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Assessment</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<script LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>

</script>

</head>
<body>
<div id="background">
<div id="container">
<div class="logo"><img src="../images/PSUblack-border10.png"></div>
<div id="header">
	<div class="laoce">Liberal Arts Online Course Evaluation</div>
</div>

<div id="content" class='roundcorners'>
<div style="float:right;"><a href="index.php">Admin Portal</a></div>
	<br/>



Submission Complete.




</div>
<br/><br/><br/><br/><br/><br/>
</div>

</body>
</html>