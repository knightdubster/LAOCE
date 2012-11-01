<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$departname = $p_department;
$semester = $p_semester;

include "validateIDorDept.php";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Instructor Portal</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type='text/css'>
.score{
	padding:5px;
	}
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
	<div style="float:right;"><a href="#" onclick="history.back(-1);">Return</a></div>
	<div class='heading'>
	<?php echo $departname; ?> Department Semester Comparison
	</div>
	<div class='indent smallred'>The scores displayed are an average of all scores submitted for <a href="questions.php">these questions</a>.
	</div>
	<br/>

<?php



	$query = mysql_query("SELECT * from Comparison WHERE courses='$departname'");
		while($row = mysql_fetch_array($query)){
		
			$score = $row['score'];
			$semester = $row['semester'];

			// DO THE BAR GRAPHS			
			$fraction= number_format(($score/100) * 900);
			echo"<div class='scorebox'>";
			if($score < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			echo $departname . " " . $semester . " All Courses &nbsp;&nbsp;&nbsp;";
			
			echo "&nbsp;&nbsp;&nbsp;" . $row['score'] . "%";
			echo "&nbsp;&nbsp;&nbsp;" . $row['evals'] . " courses.";
			 
			echo "</div></div>";
			if($row['evals'] < 2){
				echo "<div><a href='displayScores.php?semester=" . $semester . "&department=" . $departname . "'>View Course Evaluation</a>";
			}else{
				echo "<div><a href='coursesDeptSemester.php?semester=" . $semester . "&department=" . $departname . "'>View " . $semester . " " . $departname . " Courses</a>";
			}
			echo "<br/><br/>";
			
		}
		
	


		
?>

</div>
</div>
 </body>
 </html>