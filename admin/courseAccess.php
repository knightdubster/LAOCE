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
<title>LAOCE Additional Access to Data</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type="text/css">

td, th{padding:3px;}

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
<div style="float:right;"><a href='index.php'>Admin Page</a><br/></div>
<h3>Viewing Access to Data</h3>
<div class="indent">Individuals registered here can be given customized access to data. This is to accommodate those who might wish to see data for a course across semesters, for all courses within a department, or even all courses. 
<br/><br/>

<p>The "dept" value entered will search for a match or partial match within the coursenames.</p>

<p>For example, APLNG802 would have access to all evaluations for APLNG802. APLNG would have access to all evaluations for APLNG802, APLNG803, APLNG804, etc.</p>

<p>Make separate entries for anyone needing access across departments, i.e., APLNG and ECON.</p>

<p>In addition "ALL" can be entered to allow viewing of all data.</p>

<p>Once entered the individual will have access to this page which will provide the custom search options.</p>
<div style='text-align:center'><pre>https://laonline.psu.edu/LAOCE/department/</pre></div>
<br/>
<p>Those given "ALL" access can also be directed to the Score Comparison page:</p>
<div style='text-align:center'><pre>https://laonline.psu.edu/LAOCE/scoreComparison/</pre></div>

</div>
<br/><br/>
<div style="float:right; width:50%;margin-left:10px;">

<form method="post" action="saveAddAccess.php">


<div class="heading">Assign Access</div>


<div class='roundcorners' style="padding:12px;background-color:#D7D2D6;">
<form name="register" method="post" action="saveCourseRegister.php">

Dept: <input name="coursename" type="text" size="12" maxlength="8"/>

<div class="smallred indent">EX: LER100, LER, RLST, CMLIT or ALL</div>
<br/>

Firstname: <input name="firstname" type="text" size="20" maxlength="30"/><br/><br/>
Lastname: <input name="lastname" type="text" size="20" maxlength="30"/><br/><br/>
UserID: <input name="instructorID" type="text" size="20" maxlength="7"/><br><br/>
<br/>
<input type="submit" value="SUBMIT CUSTOM ACCESS"/>
</form>
</div>
<br/>

<br/>

</div>



<div class="heading">Current View Access</div>   
<table border=1><tr><th>Lasttname</th><th>Firstname</th><th>InstructorID</th><th> Access</th><th>Remove</td></tr>
<?php
//CourseInfo TABLE
    
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