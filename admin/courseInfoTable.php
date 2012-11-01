<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$semester = $p_semester;

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


<div id="content" class='roundcorners'>
<?php
//CourseInfo TABLE

echo"<b>Registered Courses for Semester " . $semester . "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='index.php'>Return</a>"; 

 echo "<table border=1><tr><th>EvalID</th><th>Course Name</th><th>Semes</th><th>Sec</th><th>InstrID</th><th>Firstname</th><th>Lastname</th><th>Begin</th><th>End</th><th>Enrolled</th><th>Submits</th><th>View Data</th><th>Edit</td></tr>";
    
$query = mysql_query("SELECT * from CourseInfo WHERE semester = '$semester' ORDER BY coursename");
while($row = mysql_fetch_array($query)){
		$coursename = $row['coursename'];
		$section = $row['section'];
		$evalID = $row['evalID'];
		$begin = date('M-d-Y',$row['begin']);
		$end = date('M-d-Y',$row['end']);
        echo "<tr><td>$row[evalID]</td><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[instructorID]</td><td>$row[firstname]</td><td>$row[lastname]</td><td>" . $begin . "</td><td>" . $end . "</td><td>" .  $row['enrollment'] . "</td>";
        $submitted=0;
        $query2 = mysql_query("SELECT submittedby from Scoring WHERE evalID = '$evalID' AND questionID=1");
        while($result = mysql_fetch_array($query2)){
        	$submitted++;
		 } 
		
		echo "<td>" . $submitted . "</td>";
		echo "<td><a href='displayScores.php?evalID=" . $evalID . "'>View Data</a></td>";
		
		echo "<td><a href='editCourseInfo.php?evalID=" . $evalID . "'>Edit</a></td></tr>";
		
}

 echo "</table>";

echo "<br>";
?>
<br/>
</div>
<br/><br/><br/>
</div>
</body>
</html>