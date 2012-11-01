<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID = $p_evalID;

$query = mysql_query("SELECT * from CourseInfo WHERE evalID = '$evalID'");
$result = mysql_fetch_array($query);
		$coursename = $result['coursename'];
		$section = $result['section'];
		$semester = $result['semester'];
		$instructorID = $result['instructorID'];
		$firstname = $result['firstname'];
		$lastname = $result['lastname'];
		$begin = $result['begin'];
		$end = $result['end'];
		$beginDate = date('M-d-Y',$result['begin']);
		$endDate = date('M-d-Y',$result['end']);
		$enrollment = $result['enrollment']; 
		
//HAS ANY DATA BEEN SUBMITTED?
$submitted=0;
    $query = mysql_query("SELECT submittedby from Scoring WHERE evalID = '$evalID'");
    	$result = mysql_fetch_array($query);
       if(isset($result['submittedby'])){
       		$submitted=1;
       	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAOCE Course Info</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

</head>
<div id="background">
<div id="container">
<div class="logo"><img src="../images/PSUblack-border10.png"></div>
<div id="header">
	<div class="laoce">Liberal Arts Online Course Evaluation</div>
	<div>Admin: <?php echo $name; ?><br/></div>
</div>


<div id="content" class="roundcorners">
<div style='float:right;'>
<a href="courseInfoTable.php?semester=<?php echo $semester; ?>">Course Info</a>&nbsp;&nbsp;&nbsp;
<a href="index.php">Admin Portal</a></div>
<?php
echo"<div style='color:#006633;font-size:1.3em;font-weight:bold;'>Course: " . $coursename . "&nbsp;&nbsp;&nbsp;Semester: " . $semester . "&nbsp;&nbsp;&nbsp;Section: ". $section . "</div>";
?>
<div class="roundcorners" style="border:1px solid #000;padding:10px;">

<form name="register" method="post" action="saveEditCourseInfo.php">
<input type='hidden' name='evalID' value='<?php echo $evalID; ?>'/>
<div style="clear:both;">
<strong>Instructor</strong>&nbsp;&nbsp;&nbsp;
<span class="smallred">- has access to this course's evaluation data</div>
<div class='indent'>
Firstname: <input name="firstname" type="text" size="20" maxlength="30" value="<?php echo $firstname; ?>"/>&nbsp;&nbsp;&nbsp;
Lastname: <input name="lastname" type="text" size="20" maxlength="30" value="<?php echo $lastname; ?>"/>&nbsp;&nbsp;&nbsp;
UserID: <input name="instructorID" type="text" size="20" maxlength="7" value="<?php echo $instructorID; ?>"/><br>
</div><br/>
This evaluation is currently <strong>available</strong> from <?php echo $beginDate . " to " . $endDate . "."; ?>
<p>The <strong>enrollment</strong> is: <input name="enrollment" type="text" size="5" maxlength="3" value="<?php echo $enrollment; ?>"/> </p>


<div><strong>Change Availability Dates</strong></div>
<div class="indent smallred">- Note: Setting the dates to all courses by semester will overwrite these values. Make these changes after that has been done. </div>


<div class="indent" style="margin-top:8px;">

Begin

<?php
//CHOOSE BEGIN MONTH
echo"<select name='beginMonth'>";
$selectedMonth = date("m",$begin);
for($x=1;$x<=12;$x++){
$monthname = date("F",mktime(0,0,0,$x,1,0));
	if($x==$selectedMonth){
	echo "<option value='" . $x. "' selected>" . $monthname . "</option>";
	}else{
	echo "<option value='" . $x. "'>" . $monthname . "</option>";
	}
}

//CHOOSE BEGIN DAY
echo "</select>&nbsp;<select name='beginDay'>";
$selectedDay = date("d",$begin);
for($x=1;$x<=31;$x++){
	if($x==$selectedDay){
	echo "<option value='" . $x. "' selected>" . $x . "</option>";
	}else{
	echo "<option value='" . $x . "'>" . $x . "</option>";
	}
}

//CHOOSE BEGIN YEAR
echo "</select>&nbsp;<select name='beginYear'>";
$selectedYear = date("Y",$begin);
for($x=2010;$x<=2020;$x++){
	if($x==$selectedYear){
	echo "<option value='" . $x. "' selected>" . $x . "</option>";
	}else{
	echo "<option value='" . $x . "'>" . $x . "</option>";
	}
}

echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;End ";

//CHOOSE END MONTH
echo"<select name='endMonth'>";
$selectedMonth = date("m",$end);
for($x=1;$x<=12;$x++){
$monthname = date("F",mktime(0,0,0,$x,1,0));
	if($x==$selectedMonth){
	echo "<option value='" . $x. "' selected>" . $monthname . "</option>";
	}else{
	echo "<option value='" . $x. "'>" . $monthname . "</option>";
	}
}

//CHOOSE END DAY
echo "</select>&nbsp;<select name='endDay'>";
$selectedDay = date("d",$end);
for($x=1;$x<=31;$x++){
	if($x==$selectedDay){
	echo "<option value='" . $x. "' selected>" . $x . "</option>";
	}else{
	echo "<option value='" . $x . "'>" . $x . "</option>";
	}
}

echo "</select>&nbsp;<select name='endYear'>";
//CHOOSE END YEAR

$selectedYear = date("Y",$end);
for($x=2010;$x<=2020;$x++){
	if($x==$selectedYear){
	echo "<option value='" . $x. "' selected>" . $x . "</option>";
	}else{
	echo "<option value='" . $x . "'>" . $x . "</option>";
	}
}
?>
</select>&nbsp;&nbsp;&nbsp;

</div>

<br/>
<input type="submit" value="SAVE THESE CHANGES"/>
</form>
<br/>


<?php
if($submitted==0){
echo "<form method='post' action='deleteCourseInfo.php'>
No data has been submitted for this evaluation. It can be deleted. 
<input name='evalID' type='hidden' value='" . $evalID . "'/>
<input type='submit' value='DELETE THIS EVALUATION'/>
</form>";
}
?>
<br/>
</div>
<br/><br/>
</div>
</body>
</html>