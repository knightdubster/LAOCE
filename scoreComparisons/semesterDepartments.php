<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateIDorDept.php";


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$semester=$p_semester;

//CREATE DEPARTMENT ARRAY FROM COMPARISON TABLE
$departments = array();
$pattern = '/[0-9.-]/';

$query = mysql_query("SELECT courses from Comparison ORDER BY courses");
	while($row = mysql_fetch_array($query)){
		if($row['courses'] != 'all'){
			$coursename =$row['courses'];
			$coursename = substr($coursename, 0, 5);//just take first 5 characters
			$deptname = preg_replace($pattern,"",$coursename);//remove numbers
			if(!in_array($deptname,$departments)){
				$departments[] = $deptname;
			}
		}
	}

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
	<div style="float:right;"><a href="index.php">Return</a></div>
	<div class='heading'>
	Department Comparison 
	<?php 
	if($semester =='all'){
		echo "All Semesters";
	}else{
		echo $semester . " Semester";
	}
	?>
	</div>
	<div class='indent smallred'>The scores displayed are an average of all scores submitted for <a href="questions.php">these questions</a>.
	</div>
	<br/>

<?php
if($semester=='all'){

	foreach($departments as $departname){
	$deptscore = 0;
	$deptevals = 0;
	$howmanysemesters = 0;
	
	$query = mysql_query("SELECT * from Comparison WHERE courses='$departname'");
		while($row = mysql_fetch_array($query)){
			$deptscore = $deptscore + $row['score'];
			$deptevals = $deptevals + $row['evals'];
			$howmanysemesters++;
		}
		
		
			$deptscore = number_format($deptscore/$howmanysemesters);

			// DO THE BAR GRAPHS			
			$fraction= number_format(($deptscore/100) * 900);
			echo"<div class='scorebox'>";
			if($deptscore < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			echo $departname . "&nbsp;&nbsp;&nbsp;";
			echo "All Courses &nbsp;&nbsp;&nbsp;";
			
			echo "&nbsp;&nbsp;&nbsp;" . $deptscore . "%";
			echo "&nbsp;&nbsp;&nbsp;" . $deptevals . " courses.";
			 
			echo "</div></div>";
			
			echo "<div><a href='departmentSemesters.php?department=" . $departname . "&semester=" . $semester . "'>View All " . $departname . " Semesters" . "</a></div><br/>";
				
	}



}else{

	foreach($departments as $departname){

	$query = mysql_query("SELECT * from Comparison WHERE courses='$departname' AND semester='$semester'");
		while($row = mysql_fetch_array($query)){
		
			$score = $row['score'];

			// DO THE BAR GRAPHS			
			$fraction= number_format(($score/100) * 900);
			echo"<div class='scorebox'>";
			if($score < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			echo $departname . "&nbsp;&nbsp;&nbsp;" . $semester;
			echo " All Courses &nbsp;&nbsp;&nbsp;";
			
			echo "&nbsp;&nbsp;&nbsp;" . $score . "%";
			echo "&nbsp;&nbsp;&nbsp;" . $row['evals'] . " courses.";
			 
			echo "</div></div>";
			if($row['evals'] < 2){
				echo "<div><a href='displayScores.php?semester=" . $semester . "&department=" . $departname . "'>View Course Evaluation</a>";
			}else{
				echo "<div><a href='coursesDeptSemester.php?semester=" . $semester . "&department=" . $departname . "'>View " . $semester . " " . $departname . " Courses</a>";
			}
			echo "</div><br/>";
		}
		
	}

}
		
?>

</div>
</div>
 </body>
 </html>