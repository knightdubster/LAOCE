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
	<?php echo $departname . " " . $semester?> Course Comparison </div>
	<div class='indent smallred'>The scores displayed are an average of all scores submitted for <a href="questions.php">these questions</a>.
	</div>
	<br/>

<?php

$evalIDs = array();
$coursenames = array();
$questionIDs = array(1,2,3,4,5,6,7,8,9,10,24);
$pattern = '/[0-9.-]/';

//SELECT COURSE NAMES IN THIS SEMESTER
//FILTER FOR DEPARTMENT NAME MATCH
$query = mysql_query("SELECT * from CourseInfo WHERE semester = '$semester' ORDER BY coursename");
	while($row = mysql_fetch_array($query)){
			$coursename =$row['coursename'];
			
			$coursenameShort = substr($coursename, 0, 5);//just take first 5 characters
			$deptname = preg_replace($pattern,"",$coursenameShort);//remove numbers
									
			if($deptname == $departname){
				$evalIDs[] = $row['evalID'];
				if(!in_array($coursename,$coursenames)){
				$coursenames[]=$coursename;
				}
			}
	}	

?>


Compare a course across all semesters:
<form style="display:inline;" method='post' action='courseAllSemesters.php'>
<select name='coursename'>

<?php
foreach($coursenames as $course){
	echo "<option value='" . $course . "'>" . $course . "</option>";
	}

echo "</select>&nbsp;&nbsp;<input type='submit' value='GO'></form><br/><br/>";

				
foreach($evalIDs as $evalID){				
			$questionTotalScore=0;
			$howmanyscores = 0;
				
			$query = mysql_query("SELECT * from CourseInfo WHERE evalID='$evalID'");
			$result = mysql_fetch_array($query);
			$coursename =$result['coursename'];
			$section = $result['section'];
			$name = $result['firstname'] . " " . $result['lastname'];
			
			
				foreach($questionIDs as $questionID){
					$query4 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID' AND evalID='$evalID'");
					while($thisrow = mysql_fetch_array($query4)){	
					$score =  $thisrow['score'];
					$howmanyscores++;				
					$questionTotalScore= $questionTotalScore + $score;
					}
			
				}//close questionID loop
			
			$totalnumberofscores = $totalnumberofscores +  $howmanyscores++;
			$totalScore = $totalScore + $questionTotalScore;
		
			$evalTopScore = $howmanyscores * 4;
			$totalPercent =  number_format($questionTotalScore/$evalTopScore * 100);
			
			
			// DO THE BAR GRAPHS			
			$fraction= number_format(($questionTotalScore/$evalTopScore) * 900);
			echo"<div class='scorebox'>";
			if($totalPercent < 70){
				echo"<div class='badscore' style='width:" . $fraction . "px;'/>";
			}else{
				echo "<div class='score' style='width:" . $fraction . "px;'/>";
			}
			echo "<a href='displayScores.php?evalID=" .$evalID . "'>" . $result['coursename'] . "</a> Section: " . $section;
			
			echo "&nbsp;&nbsp;&nbsp;Instructor: " . $name;
			
			echo "&nbsp;&nbsp;&nbsp;" . $totalPercent . "%";
			 
			echo "</div></div><br/>";
		
	}



