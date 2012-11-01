<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";


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
	<div style="float:right;"><a href="admin.php">Admin Portal</a></div>
	<div class='heading'></div>

<?php

//CREATE Comparison TABLE
mysql_query("DROP TABLE Comparison");

mysql_query( "CREATE TABLE Comparison (rowID int primary key auto_increment, courses varchar(30), semester text, score integer, evals integer)") or die(mysql_error());

echo"<h3>A new 'Comparison' table has been created.</h3><br/>";



//GET REGISTERED SEMESTER NAMES
$semesters=array(SP11,SU111,SU211,SU11,);//used for initial setup for ordering


//GET CourseInfo SEMESTER NAMES
$query = mysql_query("SELECT semester from CourseInfo");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[] = $row['semester'];
				
			}
		}
	}
	


$questionIDs = array(1,2,3,4,5,6,7,8,9,10,24); 



//ALL SCORES - ALL SEMESTERS
//**********************************************
//set all semesters variables
$allSemestersEvals = 0;
$allSemestersScore = 0;
$allSemestersNumberofscores = 0;

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
	echo $semester . " Total Score " . $totalPercent . "<br/>"; 
	echo "Total courses: " . count($evalIDs) . "<br/>";
	
	$semesterEvals = count($evalIDs);
	
	//variables for all semesters
	$allSemestersEvals = $allSemestersEvals + $semesterEvals;
	$allSemestersScore = $allSemestersScore + $totalScore;
	$allSemestersNumberofscores = $allSemestersNumberofscores + $totalnumberofscores;
	
	//insert semester totals
	mysql_query("INSERT INTO Comparison (courses, semester, score, evals)VALUES ('all','$semester', '$totalPercent', '$semesterEvals')");

}//close semester loop


$allSemestersTopScoreAvailable = $allSemestersNumberofscores * 4;
$allSemestersPercent = number_format($allSemestersScore/$allSemestersTopScoreAvailable *100);


echo "All Semesters Score: " . $allSemestersPercent . "<br/>";
echo "Total courses: " . $allSemestersEvals;

//insert all totals
mysql_query("INSERT INTO Comparison (courses, semester, score,evals)VALUES ('all','all', '$allSemestersPercent', '$allSemestersEvals')");


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
	
foreach($departments as $departname){
	echo $departname . ", ";
}


foreach($semesters as $semester){
	echo "<br/>" . $semester . "<br/>";
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
			echo $departname . ": ";
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
		echo "Total Evals:" . $totalEvals . "<br/>";
		
		mysql_query("INSERT INTO Comparison (courses, semester, score,evals)VALUES ('$departname','$semester', '$totalPercent',$totalEvals )");
		
		}//CLOSE ! EMPTY evalID conditional

	}//CLOSE DEPARTMENT LOOP

}//CLOSE SEMESTER LOOP


?>

</div>
</div>
 </body>
 </html>