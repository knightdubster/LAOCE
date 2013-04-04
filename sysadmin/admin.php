<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>System Admin Portal</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />




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
<div style="float:right;width:300px;"><a href="../admin/index.php">EvalAdmin Portal</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="setupInstructions.php">Setup Instructions</a></div>
<div class="heading">Data Tables</div>
<div>Data is stored in 10 tables in a database named LAOCE.<br> The tables are Users, CourseInfo, CustomEval, CourseAssessments, AssessmentsDescription, Assessments, Questions, Answers, TextOption, Scoring, and Comparison</div><br/>


<div style="float:left;">
<strong>View data specific to a course:</strong>
<form name="readCourse" method="post" action="readCourseTables.php">
Select Course: <select name='coursename'>
<?php

// GET ALL coursenames		
		$coursename[]=array();
		$i=0; //increment coursename array
		$query = mysql_query("SELECT coursename from CourseInfo");
		while($row = mysql_fetch_array($query)){
		if(!in_array($row['coursename'],$coursename)){
			$coursename[$i] = $row['coursename'];
			echo "<option value='" . $coursename[$i] . "'>" . $coursename[$i] . "</option>";
			$i++;
			}	
		}	
?>
</select>

<input type="submit" value="Go"/>
</form>
</div>

<div style="float:left;margin-left:30px;">
<strong>View scoring table for entered evalID.</strong><br/>
<form name="readCourse" method="post" action="readScoring.php">
Eval ID <input type='text' name='evalID' size='6'/>
<input type='submit' value='GO'/>
</form>
</div>

<br/><br/><br/>
<div class='formstyles' style='clear:both;'>

	<div style="float:right;width:500px;padding:5px;margin:5px;">
		- ID's or admins can be added here.<br/>
		- If user already exists this will update firstname, lastname, and role.<br/>
		- Delete users from Users Table.
		<br/>
		<p><a href="readUsers.php" target="_blank">Users Table</a></p>
	</div>

	<form  name="register" method="post" onsubmit="return checkit()" action="writeNewUser.php">
	<div class="heading">Register/Edit User</div><br />
	User ID: <input name="userID" type="text" size="20"/><br>
	Firstname: <input name="firstname" type="text" size="20"/><br>
	Lastname: <input name="lastname" type="text" size="20"/><br>
	Role: 
	<select name="role">
	<option value="id">id</option>
	<option value="admin">admin</option>
	</select><br>
	<input type="submit" value="Register/Edit User"/>
	</form>
	
</div>
<br/>
<strong>Score Comparison</strong>
<div class="indent">March 2012 - code added to display bar graphs comparing scores between semesters, departments, or courses within a department. Because these past scores do not change, cummulative values that take a while to generate are stored in a Comparison table to speed the viewing process. At the end of each evaluation cycle, typically the end of a semester, this script should be run to update this table.</div>
<div align='center'><a href='readComparisonTable.php'>View Comparison Table</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href='checkNewSemester.php'>Update the Comparison Table</a>
</div>
<br/>

</div>


</body>
</html>