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

<style type="text/css">

td{padding:2px;}

</style>

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

echo"<b>Course Access</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='index.php'>Return</a>";   
 echo "<table border=1><tr><th>Lasttname</th><th>Firstname</th><th>InstructorID</th><th>Course Access</th><th>Edit</td></tr>";
    
$query = mysql_query("SELECT * from CourseAccess ORDER BY lastname");
while($row = mysql_fetch_array($query)){
		$coursename = $row['coursename'];
		$section = $row['section'];
		$rowID = $row['rowID'];
        echo "<tr><td>$row[lastname]</td><td>$row[firstname]</td><td>$row[userID]</td><td>$row[coursename]</td>";		
		echo "<td><a href='deleteCourseAccess.php?rowID=" . $rowID . "'>Delete</a></td></tr>";
		
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