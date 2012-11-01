<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

$today = time();

//SEMESTER TO ADD PASSED FROM SYSADMIN PAGE
import_request_variables("pg","p_");
$newSemesters[] = $p_addSemester;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Instructor Portal</title>

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
	<div style="float:right;"><a href="admin.php">System Admin Portal</a></div>
	<div class='heading'></div>

<?php



//GET REGISTERED SEMESTER NAMES
//$semesters=array(SP11,SU111,SU211,SU11,FA11);//used for initial setup for ordering

$semesters=array(SP11,SU111,SU211,SU11);//array initialized to correct order
$comparisonSemesters=array();

//GET CourseInfo SEMESTER NAMES
$query = mysql_query("SELECT semester from CourseInfo");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[] = $row['semester'];
				
			}
		}
	}

/*
//Switched to adding one semester at a time
//$newSemesters array gotten from passed variable	
//GET Comparison SEMESTER NAMES
$query = mysql_query("SELECT semester from Comparison");
	while($row = mysql_fetch_array($query)){
			$comparisonSemesters[] = $row['semester'];			
	}

//CREATE ARRAY OF SEMESTERS MISSING FROM Comparison TABLE	
foreach($semesters as $val){
	if(!in_array($val,$comparisonSemesters)){
		$newSemesters[] = $val;				
	}
}
*/

$questionIDs = array(1,2,3,4,5,6,7,8,9,10,24); 




//ALL SCORES - ALL SEMESTERS
//**********************************************
$semesterScores = array();
$totalEvals = 0;

foreach($semesters as $semester){
echo $semester . ", ";
}

echo "<br/>";

//loop through semesters
foreach($semesters as $semester){
	$evalIDs = array();
	//echo "<br/><br/>Semester:" . $semester . "-";
	//WHAT EVAL IDS?
	$query = mysql_query("SELECT evalID from CourseInfo WHERE semester='$semester'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				$evalIDs[] = $row['evalID'];
			}
		}

	$totalScore = 0;
	$totalnumberofscores = 0;

	foreach($evalIDs as $evalID){//array of sorted evalIDs
	
		
		$questionTotalScore=0;
		$howmanyscores = 0;
		foreach($questionIDs as $questionID){//array of questionids
			$query4 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID' AND evalID='$evalID'");
			while($thisrow = mysql_fetch_array($query4)){	
				$score =  $thisrow['score'];
				$howmanyscores++;				
				$questionTotalScore= $questionTotalScore + $score;
			}
			
		}//close questionID loop
			
		$totalnumberofscores = $totalnumberofscores +  $howmanyscores++;
		$totalScore = $totalScore + $questionTotalScore;
		
						
	}//close evalID loop
	
	$totalTopScoreAvailable = $totalnumberofscores * 4;
	$totalPercent = number_format($totalScore/$totalTopScoreAvailable * 100);
	//echo"Number of scores: " . $totalnumberofscores . "<br/>";
	//echo"Total Score: " . $totalScore. "<br/>";
	echo $semester . " Total Score " . $totalPercent . "&nbsp;&nbsp;&nbsp;"; 
	echo "Total courses: " . count($evalIDs) . "<br/>";
	
	$semesterEvals = count($evalIDs);
	$totalEvals = $totalEvals + $semesterEvals;
	
	//IF NEW SEMESTER INSERT TOTAL
	if(in_array($semester,$newSemesters)){
		mysql_query("INSERT INTO Comparison (courses, semester, score, evals)VALUES ('all','$semester', '$totalPercent', '$semesterEvals')");
	}
	
	$allSemesters = $allSemesters + $totalPercent;
	
}//close semester loop

//average of all semesters
$allSemesters = number_format($allSemesters/count($semesters));

echo "All Semesters Score: " . $allSemesters . "&nbsp;&nbsp;&nbsp;";
echo "Total courses: " . $totalEvals . "<br/>";

//update all totals
mysql_query("UPDATE Comparison SET score='$allSemesters', evals='$totalEvals' WHERE courses='all' AND semester='all'");


// DEPARTMENT TOTALS - EACH SEMESTER
//********************************************

//CREATE DEPARTMENT AND EVALIDS ARRAYS
$departments = array();
$pattern = '/[0-9.-]/';


$name = preg_replace($pattern,"",$name);

$query = mysql_query("SELECT coursename from CourseInfo ORDER BY coursename");
	while($row = mysql_fetch_array($query)){
		if(isset($row['coursename'])){
			$coursename =$row['coursename'];
			$coursename = substr($coursename, 0, 5);//just take first 5 characters
			$deptname = preg_replace($pattern,"",$coursename);//remove numbers
			if(!in_array($deptname,$departments)){
				$departments[] = $deptname;
			}
		}
	}
	



foreach($newSemesters as $semester){
	echo "<br/><br/><strong>" . $semester . "</strong><br/>";
	//GET evalIDs for each department this semester	
	foreach($departments as $departname){
		$evalIDs = array();
		$totalEvals = 0;
		$query = mysql_query("SELECT * from CourseInfo WHERE semester='$semester'");
		while($row = mysql_fetch_array($query)){
		$coursename = $row['coursename'];
		$coursename = substr($coursename, 0, 5);//just take first 5
		$thisDeptName = preg_replace($pattern,"",$coursename);
			if($thisDeptName == $departname){
				$evalIDs[] = $row['evalID'];
			}
		}
		
		if(!empty($evalIDs)){
			echo $departname . ": EvalIDs: ";
			foreach ($evalIDs as $num){
				echo $num . ", ";
				}
				
			echo"<br/>";

			
		//GET SCORES FOR ALL EVALIDS THIS SEMESTER, THIS DEPARTMENT
		
		$totalScore = 0;
		$totalnumberofscores = 0;


		foreach($evalIDs as $evalID){//array of sorted evals

		$questionTotalScore=0;
		$howmanyscores = 0;
			
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
		echo number_format($questionTotalScore/$evalTopScore * 100) . ", ";
		
		$totalEvals++;
		}//close evalID loop
	
		$totalTopScoreAvailable = $totalnumberofscores * 4;
		$totalPercent = number_format($totalScore/$totalTopScoreAvailable * 100);
		//echo"Number of scores: " . $totalnumberofscores . "<br/>";
		//echo"Total Score: " . $totalScore. "<br/>";
		echo " Average Score " . $totalPercent . "<br/>";
		//echo "Total Evals:" . $totalEvals . "<br/>";
		$semesterScores[] = $totalPercent;
		$allSemesters = $allSemesters + $totalPercent;
		
		mysql_query("INSERT INTO Comparison (courses, semester, score,evals)VALUES ('$departname','$semester', '$totalPercent',$totalEvals )");
		
		}//CLOSE ! EMPTY evalID conditional

	}//CLOSE DEPARTMENT LOOP

}//CLOSE SEMESTER LOOP


?>

</div>
</div>
 </body>
 </html>