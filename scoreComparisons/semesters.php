<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//include "functions.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Instructor Portal</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type='text/css'>

</style>

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
	<div style="float:right;"><a href="../admin/">Admin Portal</a></div>
	
	<div class='heading'>
	Semester Comparison</div>
	<div class='indent smallred'>The scores displayed are an average of all scores submitted for <a href="questions.php">these questions</a>.
	</div>
	<div class='indent smallred'><a href="flowchart.png">Flowchart</a> of comparison pages.
	</div>
	<br/>

<?php
$query = mysql_query("SELECT * from Comparison WHERE courses='all' AND semester='all'");
		while($row = mysql_fetch_array($query)){
			$semester = $row['semester'];
			$score = $row['score'];

			// DO THE BAR GRAPHS			
			$fraction= number_format(($score/100) * 900);
			echo"<div class='scorebox'>";
			if($score < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			
			echo "All Semesters &nbsp;&nbsp;&nbsp;All Courses";
			
			echo "&nbsp;&nbsp;&nbsp;" . $score . "%";
			echo "&nbsp;&nbsp;&nbsp;" . $row['evals'] . " courses.";
			 
			echo "</div></div>";
			echo "<div><a href='semesterDepartments.php?semester=" . $semester . "'>Compare  Departments All Semesters</a></div><br/>";
		}
		

$query = mysql_query("SELECT * from Comparison WHERE courses='all'");
		while($row = mysql_fetch_array($query)){
			$semester = $row['semester'];
			$score = $row['score'];

			// DO THE BAR GRAPHS			
			$fraction= number_format(($score/100) * 900);
			if($row['semester'] !== "all"){
			echo"<div class='scorebox'>";
			if($score < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			
			echo $semester . " Semester&nbsp;&nbsp;&nbsp; All Courses";
			echo "&nbsp;&nbsp;&nbsp;" . $score . "%";
			echo "&nbsp;&nbsp;&nbsp;" . $row['evals'] . " courses.";
			 
			echo "</div></div>";
			echo "<div><a href='semesterDepartments.php?semester=" . $semester . "'>Compare " . $semester . " Departments</a></div><br/>";
			}
		}
		
?>

</div>
</div>
 </body>
 </html>