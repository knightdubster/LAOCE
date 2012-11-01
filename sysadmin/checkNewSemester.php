<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

$today = time();

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



//GET REGISTERED SEMESTER NAMES
//$semesters=array(SP11,SU111,SU211,SU11,FA11);//used for initial setup for ordering

$semesters=array(SP11,SU111,SU211,SU11);
$comparisonSemesters=array();
$newSemesters=array();

//GET CourseInfo SEMESTER NAMES
$query = mysql_query("SELECT semester from CourseInfo");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[] = $row['semester'];
				
			}
		}
	}

echo "Registered Semesters: ";
foreach($semesters as $val){
	echo $val . ", ";
	}
	
echo "<br/><br/>";
	
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

//CHECK TO SEE IF AN EVAL IN THIS NEW SEMESTER IS STILL OPEN
$openEval=array();//SET FLAG
echo "Semester to be updated: ";
foreach($newSemesters as $sem){
	echo $sem . ", ";	
}

echo "<br/><br/>";

foreach($newSemesters as $sem){
	echo"<form method='post' action='comparisonTableUpdate.php?addSemester=" . $sem . "'>";
	echo $sem . " <input type='submit' value='Add This Semester To Comparisons'></form>";
	
	//CHECK TO SEE IF AN EVAL IN THIS NEW SEMESTER IS STILL OPEN
	$query = mysql_query("SELECT * from CourseInfo WHERE semester='$sem'");
		while($row = mysql_fetch_array($query)){
			if($row['end'] > $today){
			    //echo $row['evalID'] . " is still open.";
				$openEval[] = $row['evalID'];
			}
		}
	
	if($openEval[0] != ""){
		echo "<div class='indent smallred'> An evaluation in the " . $sem . " semester to be updated is still open.<br/>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;Open eval ID's: ";
		foreach($openEval as $thiseval){
		    echo $thiseval . ", ";
		}
		echo "<br/>This could affect accuracy of stored values.</br>You can view/edit End dates for evaluations from the Course Info table via the Admin panel.</div>";
	}
	
	echo "<br/>";	
}

?>
<br/>
<div>Be patient. It may take 5-10 minutes for this script to run. On completion a page displays updated values entered into the table.</div>
</div>
</div>
 </body>
 </html>