<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAOCE Administration</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

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

<!--VIEWING DATA-->
<div class="roundcorners" style="border:1px solid #000;padding:10px;">
<div class="heading">Viewing Data</div><br/>

<div class='indent'>
<form method='post' action='displayScores.php'>
<strong>Course: </strong>
<select name='coursename'>
<option value='all'>All</option>
<?php
// GET ALL COURSENAMES		
	$coursenames[]=array();
	$i=0; //increment lessonids array
	$query = mysql_query("SELECT coursename from CourseInfo ORDER BY coursename");
	while($row = mysql_fetch_array($query)){
		if(isset($row['coursename'])){
			if(!in_array($row['coursename'],$coursenames)){
				$coursenames[$i] = $row['coursename'];
				echo "<option value='" . $coursenames[$i] . "'>" . $coursenames[$i] . "</option> ";
				$i++;
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

</div>
<br/>

<!--COURSE REGISTRATION-->
<div class="roundcorners" style="border:1px solid #000;padding:10px;">

<div class='roundcorners' style="float:right;padding:12px;background-color:#D7D2D6;">View/Edit Registered Course Info: 
<form method="post" action="courseInfoTable.php">
<select name="semester">
<?php
foreach($semesters as $val){
			echo "<option value='" . $val . "'>" . $val . "</option> ";				
	}
?>
</select>
&nbsp;&nbsp;<input type='submit' value='GO'>
</form><br/>
<a href="addAccess.php">Add Additional Access to Data</a> <br/><br/><a href='courseAccessTable.php'>View/Delete Access</a>
</div>

<div class="heading" style="margin-bottom:12px;">Course Registration</div>


<form name="register" method="post" action="saveCourseRegister.php">
<div style="float:left;width:300px;padding-bottom:6px;">
<strong>Course Name: </strong>Enter new: <input name="coursename" type="text" size="12" maxlength="8"/>
<div style="margin-left:120px;">or Select: <select name="existingcoursename">
<option>Select Course</option>
<?php
$i=0;
foreach($coursenames as $val){
		echo "<option value='" . $coursenames[$i] . "'>" . $coursenames[$i] . "</option>";
		$i++;
}
?>
</select></div>
<div class="smallred indent">EX: LER100 RLST001 CMLIT108</div>
</div>

<div style="float:left;margin-left:20px;">
<strong>Semester: </strong>
<select name="semester">
<option value='SU111' selected='selected'>SU111</option>
<option value='SU211'>SU211</option>
<option value='SU11'>SU11</option>
<option value='FA11'>FA11</option>
<option value='SP12'>SP12</option>
<option value='SU112'>SU112</option>
<option value='SU212'>SU212</option>
<option value='FA12'>FA12</option>
<option value='SP13'>SP13</option>
<option value='SU113'>SU113</option>
<option value='SU213'>SU213</option>
<option value='FA13'>FA13</option>
<option value='SP11'>SP14</option>
</select>

</div>

<div style="float:left;margin-left:20px;">
<strong>Section:</strong>
<select name="section">
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='3'>7</option>
<option value='4'>8</option>
<option value='5'>9</option>
<option value='6'>10</option>
</select>
</div>
<div style="clear:left;margin-top:5px;margin-bottom:5px;">
<strong>Enrollment</strong>&nbsp;&nbsp;<input name="enrollment" type="text" size="5" maxlength="3"/>
<span class="smallred">&nbsp;&nbsp;- approximate enrollment for this course</span>
</div>
<div style="clear:both;">
<strong>Instructor</strong>&nbsp;&nbsp;&nbsp;
<span class="smallred">- will have access to this course's evaluation data</span>
</div>
<div class='indent'>
Firstname: <input name="firstname" type="text" size="20" maxlength="30"/>&nbsp;&nbsp;&nbsp;
Lastname: <input name="lastname" type="text" size="20" maxlength="30"/>&nbsp;&nbsp;&nbsp;
UserID: <input name="instructorID" type="text" size="10" maxlength="7"/><br>
</div><br/>
<input type="submit" value="REGISTER THIS COURSE"/>
</form>
<br/>

</div>

<br/>

<div class="roundcorners" style="border:1px solid #000;padding:10px;">
<div class="heading"><strong>Set Evaluation Availability By Semester</strong></div>
<div class="indent smallred">- this sets the begin and end dates to all courses registered to the chosen semester</div>


<div class="indent" style="margin-top:6px;">
<form name='availableDates' method='post' action='writeAvailableDates.php'>
Semester: 
<select name="semester">
<option value='SU111' selected='selected'>SU111</option>
<option value='SP11'>SP11</option>
<option value='SU211'>SU211</option>
<option value='SU11'>SU11</option>
<option value='FA11'>FA11</option>
<option value='SP12'>SP12</option>
<option value='SU112'>SU112</option>
<option value='SU212'>SU212</option>
<option value='FA12'>FA12</option>
<option value='SP13'>SP13</option>
<option value='SU113'>SU113</option>
<option value='SU213'>SU213</option>
<option value='FA13'>FA13</option>
<option value='SP14'>SP14</option>
</select>&nbsp;&nbsp;
Begin

<?php
//CHOOSE BEGIN MONTH
echo"<select name='beginMonth'>";
for($x=1;$x<=12;$x++){
$monthname = date("F",mktime(0,0,0,$x,1,0));
	echo "<option value='" . $x. "'>" . $monthname . "</option>";
}

//CHOOSE BEGIN DAY
echo "</select>&nbsp;<select name='beginDay'>";
for($x=1;$x<=31;$x++){
	echo "<option value='" . $x . "'>" . $x . "</option>";
}

//CHOOSE BEGIN YEAR
echo "</select>&nbsp;<select name='beginYear'>";
for($x=2011;$x<=2020;$x++){
	echo "<option value='" . $x . "'>" . $x . "</option>";
}

echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;End ";

//CHOOSE END MONTH
echo"<select name='endMonth'>";
for($x=1;$x<=12;$x++){
$monthname = date("F",mktime(0,0,0,$x,1,0));
	echo "<option value='" . $x . "'>" . $monthname . "</option>";
}

//CHOOSE END DAY
echo "</select>&nbsp;<select name='endDay'>";
for($x=1;$x<=31;$x++){
	echo "<option value='" . $x . "'>" . $x . "</option>";
}

echo "</select>&nbsp;<select name='endYear'>";
//CHOOSE END YEAR

for($x=2011;$x<=2020;$x++){
	echo "<option value='" . $x . "'>" . $x . "</option>";
}
?>
</select>&nbsp;&nbsp;&nbsp;
<input type="submit" value="REGISTER DATES"/>
</form>
</div>

</div>
<br/>




<div class="roundcorners" style="border:1px solid #000;padding:10px;">


<div class="heading"><strong>Customize A Course Evaluation</strong></div>
<div class="smallred indent">- for a given course additional questions can be addded to the standard evaluation.</div>
<div class="smallred indent">- applies to all sections with the same course name</div><br/>

<form class='indent' name='addInstructorQuestions' method='post' action='../createAssessments/customEval.php'>

Select course name/identifier:
<select name='coursename'>
<?php
$i=0;
foreach($coursenames as $val){
		echo "<option value='" . $coursenames[$i] . "'>" . $coursenames[$i] . "</option>";
		$i++;
}
?>
</select>
<input type='submit' value='GO'>
</form>
<br/>
<div class="heading">Evaluation Questions</div>
<?php
//ASSESSMENT LISTING
$i=1;

echo "<table class='courseassessmenttable'><tr class='coursetitle'><td>ID#</td><td>Assessment Name </td><td>Description</td><td>View</td><td>Edit</td></tr>\n";

$query = mysql_query("SELECT * from AssessmentsDescription");
while($row = mysql_fetch_array($query)){
		//odd-even shading of rows
		if ($i % 2 == 0 ){
			echo "<tr class='even'>";
			}else{
			echo"<tr class='odd'>";
			}
		echo "<td>" .  $row['assessmentID'] . "</td><td>" . $row['assessName']. "</td><td>" . $row['description'] . "</td><td><a href='displayAssessment.php?assessmentID=" .  $row['assessmentID'] . "'>View</a></td><td><a href='../createAssessments/assessmentEdit.php?assessmentID=" .  $row['assessmentID'] . "'>Edit</a></tr>" ;
		$i++;
	}
echo "</table>";
?>
<br/>

</div>


</div>
</div>
</body>
</html>