<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateDept.php";

//CREATE ARRAY OF COURSENAMES FOR ACCESS
$i=0;
$courseAccess[]=array();
	$query = mysql_query("SELECT coursename from CourseAccess WHERE userID ='$userID'");
	while($row = mysql_fetch_array($query)){
		$courseAccess[$i]=$row['coursename'];
		$i++;
	}


//GET COURSE INFO - SET ARRAY OF EVALID'S
$evalIDs[]=array();
$i=0;//increment evalIDs array

foreach($courseAccess as $access){
	$query = mysql_query("SELECT * from CourseInfo");
		while($row = mysql_fetch_array($query)){
			$coursename=$row['coursename'];
			$pos = (strpos($coursename,$access));
			if($pos !== false){
				$evalIDs[$i] = $row['evalID'];
				$i++;
			}
		}
}

//reverse order of evalIDs
$evalIDs = array_reverse($evalIDs);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAOCE Department View</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type="text/css">
td,th{padding:2px 6px 2px 0px;}
th{text-align:left;}

</style>

</head>
<body>
<div id="background">
<div id="container">
	<div class="logo"><img src="../images/PSUblack-border10.png"></div>
		<div id="header">
		<div class="laoce">Liberal Arts Online Course Evaluation</div>
		<div>Department View: <?php echo $name; ?><br/></div>
		</div>
	
<div id="content" class='roundcorners'>
<h3>Course Access: 
<?php
foreach($courseAccess as $access){
	echo $access . "  ";
}
?>
</h3>
<br/><br/>
<!--VIEWING DATA-->
<div class="roundcorners" style="border:1px solid #000;padding:10px;">
<div class="heading">Viewing Data</div>
<div class='indent smallred'>Make selections from drop down lists.</div>
<br/>
<div class='indent'>
<form method='post' action='displayScores.php'>
<strong>Course: </strong>
<select name='coursename'>
<?php
// GET ALL COURSENAMES		
	$coursenames[]=array();
	$i=0; //increment lessonids array
foreach($evalIDs as $accessgiven){
	$query = mysql_query("SELECT coursename from CourseInfo WHERE evalID='$accessgiven'");
	while($row = mysql_fetch_array($query)){
		if(isset($row['coursename'])){
			if(!in_array($row['coursename'],$coursenames)){
				$coursenames[$i] = $row['coursename'];
				echo "<option value='" . $coursenames[$i] . "'>" . $coursenames[$i] . "</option> ";
				$i++;
			}
		}
	}
}

echo "</select>&nbsp;&nbsp;&nbsp;";

//SEMESTERS
echo "<strong>Semester: </strong><select name='semester'><option value='all'>All</option>";
$semesters[]=array();
	$i=0; //increment lessonids array
	$query = mysql_query("SELECT semester from CourseInfo");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[$i] = $row['semester'];
				echo "<option value='" . $semesters[$i] . "'>" . $semesters[$i] . "</option> ";
				$i++;
			}
		}
	}
echo "</select>&nbsp;&nbsp;&nbsp;";

?>

<strong>Section:</strong>
<select name="section">
<option value='all'>All</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
</select>


&nbsp;&nbsp;&nbsp;<input type='submit' value='GO'>

</form></div>
<br/>
</div><br/>
<?php

echo"<b>Data for these courses/sections is available.</b>";   
 echo "<table border=0><tr><th>Course</th><th>Semester</th><th>Section</th><th>Instructor</th></tr>";

foreach($evalIDs as $accessgiven){
    
	$query = mysql_query("SELECT * from CourseInfo WHERE evalID='$accessgiven'");
	while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[firstname] $row[lastname]</td></tr>";
	}
}

?>

</table>

<br>
</div>
<br/>

