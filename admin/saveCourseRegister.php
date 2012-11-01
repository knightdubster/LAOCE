<?php
//SAVE SCORE

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";
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
	<div>Admin: <?php echo $name; ?><br/></div>
</div>

<div id="content" class='roundcorners'>
<div style="float:right;"><a href="index.php">Admin Portal</a></div>
	<br/>


<?php

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

//IF INPUT BOX EMPTY USE DROPDOWN VALUE
if(empty($p_coursename)){
	$coursename=$p_existingcoursename;
	}else{
	$coursename=$p_coursename;
	$coursename = strtoupper($p_coursename);
	}
	
$semester=$p_semester;
$section = $p_section;
$firstname=ucfirst($p_firstname);
checkit($firstname);
$lastname= ucfirst($p_lastname);
checkit($lastname);
$instructorID=strtolower($p_instructorID);
checkit($instructorID);
$enrollment = $p_enrollment;

function checkit($formvalue){
	if($formvalue ==""){
			echo"<script>
        alert('Please complete all entries in the form');
        history.go(-1);
        </script>";
        exit();
        }
   }

//HAS THIS COMBINATION OF COURSENAME, SEMESTER, SECTION BEEN USED BEFORE?
$query = mysql_query("SELECT evalID from CourseInfo WHERE coursename='$coursename' AND semester='$semester' AND section='$section'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				echo "<script> alert('This Coursename, Semester, Section has already been registered. Please try again.'); history.go(-1);</script>";
			}			
		}


//default timestamp is 1/1/2011, hide is set to 1
$query = mysql_query("INSERT INTO CourseInfo (coursename, semester, section, instructorID, firstname, lastname,begin,end,enrollment)VALUES ('$coursename','$semester','$section', '$instructorID','$firstname','$lastname',1293861600,1293861600,'$enrollment')");
$result = mysql_fetch_array($query);

$courseID = mysql_insert_id();


echo"<br/><div align='center'><h3>This course, " . $coursename . " " . $semester . "-". $section . ", has been registered. </h3>";

echo"<p>&nbsp;</p>";

echo"<div style='text-align:left;width:600px;'>Use this link for students to submit the form";
echo"<pre>https://laonline.psu.edu/LAOCE/student/evaluation.php?eval=" . $courseID . "</pre>";

echo "<br/><div>Use this link to share results with instructor:</div>";
echo"<pre>https://laonline.psu.edu/LAOCE/instructor/viewData.php?eval=" . $courseID . "</pre>";


echo"</div>";

echo"<br/><br/></div>";

?>

</div>
<br/><br/><br/><br/><br/><br/>
</div>

</body>
</html>