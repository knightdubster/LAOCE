<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

include "functions.php";


//IMPORT VARIABLES (page called by admin search or adminTable)
import_request_variables("pg","p_");
if(isset($p_evalID)){
	$evalID=$p_evalID;
	$query = mysql_query("SELECT * from CourseInfo WHERE evalID = $evalID");
	$result = mysql_fetch_array($query);
	$coursename = $result['coursename'];
	$semester = $result['semester'];
	$section = $result['section'];
}else{
	$coursename = $p_coursename;
	$semester = $p_semester;
	$section = $p_section;
}

//GET COURSE INFO - SET ARRAY OF EVALID'S
$evalIDs[]=array();
$i=0;//increment evalIDs array

//SEARCH SPECIFIC COURSE
if($coursename != 'all'){ 
	
	//SEARCH ALL SEMESTERS AND SECTIONS OF COURSE
	if(($section=='all') && ($semester=='all')){
		$query = mysql_query("SELECT evalID from CourseInfo WHERE coursename='$coursename'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				$evalIDs[$i] = $row['evalID'];
				$i++;			
			}
		}

		
	//SEARCH SPECIFIC SEMESTER ALL SECTIONS OF COURSE	
	}elseif(($section=='all') && ($semester!='all')){
		$query = mysql_query("SELECT evalID from CourseInfo WHERE coursename='$coursename' AND semester='$semester'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				$evalIDs[$i] = $row['evalID'];
				$i++;
			}
		}
		
	
	
	//SEARCH SPECIFIC COURSE/SEMESTER/SECTION OF COURSE	
	}elseif(($section!='all') && ($semester!='all')){
		$query = mysql_query("SELECT * from CourseInfo WHERE coursename='$coursename' AND semester='$semester' AND section='$section'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				$evalIDs[$i] = $row['evalID'];
				$i++;
				$instructorName=$row['firstname'] . " " . $row['lastname'];
			}
		}
	
	
	//SEARCH SPECIFIC SECTION OF COURSE	ALL SEMESTERS
	}elseif(($section!='all') && ($semester=='all')){
		$query = mysql_query("SELECT evalID from CourseInfo WHERE coursename='$coursename' AND section='$section'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['evalID'])){
				$evalIDs[$i] = $row['evalID'];
				$i++;
			}
		}
	
	}

	
}else{//coursename=='all'
	
	//SEARCH ALL COURSES FOR SPECIFIC SEMESTER
	if(($semester!='all') && ($section=='all')){
	$section = "All";
		$query = mysql_query("SELECT evalID from CourseInfo WHERE semester='$semester'");
			while($row = mysql_fetch_array($query)){
				if(isset($row['evalID'])){
					$evalIDs[$i] = $row['evalID'];
					$i++;
				}
			}
		
	//SEARCH ALL COURSES
	}elseif($semester=='all'){
		$section = "All";
		$query = mysql_query("SELECT evalID from CourseInfo");
			while($row = mysql_fetch_array($query)){
				if(isset($row['evalID'])){
					$evalIDs[$i] = $row['evalID'];
					$i++;
				}
			}
	}

}



//HOW MANY SUBMITTED THIS EVALUATION
$submitted=0;
foreach($evalIDs as $evalID){
$query = mysql_query("SELECT * from Scoring WHERE evalID='$evalID' AND questionID=1");
	while($row = mysql_fetch_array($query)){
	$submitted++;
	}
}

//HOW MANY ENROLLED
$enrolled = 0;
foreach($evalIDs as $evalID){
$query = mysql_query("SELECT enrollment from CourseInfo WHERE evalID='$evalID'");
	while($row = mysql_fetch_array($query)){
	$enrolled = $enrolled + $row['enrollment'];
	}
}


		

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
	<div style="float:right;"><a href="index.php">Admin Portal</a></div>
	<div class='heading'>
	Course: <?php echo $coursename; ?> &nbsp;&nbsp;&nbsp;
	Semester: <?php echo $semester; ?> &nbsp;&nbsp;&nbsp;
	Section: <?php echo $section; ?> <br/>
	<?php
	
	//IF SPECIFIC COURSE/SEMESTER/SECTION SHOW INSTRUCTOR
	if(count($evalIDs) == 1){
		echo "Instructor: " . $instructorName . "&nbsp;&nbsp;&nbsp;";
	}
		
	echo $submitted .  " Submissions from " . $enrolled . " enrolled.&nbsp;&nbsp;&nbsp;";
	
	if(count($evalIDs) > 1){
		echo count($evalIDs) . " courses.";
	}
	
	echo "</div><br/>";


//IF NO SUBMISSIONS DISPLAY NO DATA FOUND
if($submitted==0){
	echo "<div style='text-align:center;height:400px;'><h3>No entries found for this search criteria.</h3></div>";
	}else{

$i=1;//question counter	

//INSTRUCTOR ASSESSMENT
//******************************************************************
//ARE INSTRUCTOR QUESTIONS INCLUDED?
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment=1");
$result = mysql_fetch_array($query);
if(isset($result['instructorAssessment'])){
	$assessmentID=2;
	//GET QUESTION ID'S USED IN THIS ASSESSMENT
	$query = mysql_query("SELECT * from Assessments WHERE assessmentID='$assessmentID' ORDER BY questionorder");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
        
        //GET QUESTION TEXT
     	$query3 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
		$result = mysql_fetch_array($query3);
		$questionText=$result['questionText'];
		$questionType = $result['type'];
		
//LIKERT		
		if($questionType == 'likert'){
   		echo "Q" . $i . ": " . $questionText;
   		
   			//GET ANSWERS TO THIS QUESTION ID
			$answers[]=array();
			$x=0;
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID' ORDER BY ratingvalue");
			while($row = mysql_fetch_array($query2)){
			$answers[$x]=$row['answerText'];
			$x++;
			}
        	        		
			//GET SCORE FOR EACH QUESTION
			$questionTotalScore=0;
			$howmanyscores = 0;
		foreach($evalIDs as $evalID){//array of sorted evals
			$query4 = mysql_query("SELECT * from Scoring WHERE questionID='$questionID' AND evalID='$evalID'");
			while($thisrow = mysql_fetch_array($query4)){	
				$score =  $thisrow['score'];
				$howmanyscores++;				
				$questionTotalScore= $questionTotalScore + $score;
			}
		}//close evalID loop
			
			// DO THE BAR GRAPHS IF TOTAL SCORE > 0
			if($questionTotalScore>0){
				$topScoreAvailable = topratingvalue($questionID) * $howmanyscores;
				$fraction= number_format($questionTotalScore/$topScoreAvailable * 900);
				echo"<div class='scorebox'><div class='score' style='width:" . $fraction . "px;'/>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average . "/4";
				
				//percent calculation
				$percent = number_format($questionTotalScore/$topScoreAvailable * 100);
				echo "&nbsp;&nbsp;&nbsp;" . $percent . "%";
				echo "</div></div>";
			}else{
				echo"<div class='scorebox'>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average;
				echo "</div>";
			}
						
			//SHOW SCALE
			echo "<div style='width:900px;font-size:.7em;color:#990000;'>";
			echo "<div style='float:left;width:165px;'>" . $answers[0] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[1] . "</div>";
			echo "<div style='float:left;width:190px;text-align:center;'>" . $answers[2] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[3] . "</div>";
			echo "<div style='float:right;width:165px;text-align:right;'>" . $answers[4] . "</div>";
			echo "</div><br/>";
			
			$i++;//increment counter			
		}
		

//MULTIPLE CHOICE OR RADIO OR TRUE/FALSE
		elseif(($questionType == 'mc-check') || ($questionType == 'mc-radio') || ($questionType == 'tf')){
			echo "Q" . $i . ": " . $questionText;
			//GET ALL ANSWERS FOR THIS QUESTION
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID'");
				while($row = mysql_fetch_array($query2)){
				$answerID= $row['answerID'];
				//COUNT HOW MANY FROM SCORING
				$howmanyscores=0;
			foreach($evalIDs as $evalID){//array of sorted evals
				$query4 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID'AND score = '$answerID' AND evalID='$evalID'");
				while($thisrow = mysql_fetch_array($query4)){	
				$howmanyscores++;				
				}
			}//close evalID loop
			echo "<div class='indent'>" . $howmanyscores . " - " . $row['answerText'] . "</div>";
			}
			echo"<br/>";
			$i++;//increment counter
		}

//HEADING
		elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
		}

//TEXT RESPONSE		
		elseif($questionType == 'text'){
		foreach($evalIDs as $evalID){//array of sorted evals
			$query5 = mysql_query("SELECT * from TextOption WHERE questionID ='$questionID' AND evalID='$evalID' ORDER BY rand() LIMIT 10");
			while($row = mysql_fetch_array($query5)){
			$textoption = $row['textoption'];
			$textoption = stripslashes($textoption);
     			$questionID= $row['questionID'];//this is to list question only once 
					if(!in_array($questionID,$questionlist)){
					$questionlist[]=$questionID;
				
					$query6 = mysql_query("SELECT questionText from Questions WHERE questionID='$questionID'");
					$result = mysql_fetch_array($query6);
					$questionText=$result['questionText'];					
					echo "Q" . $i . ": " . $questionText;
						
						//display 'all replies link' for section search
						if(($section != 'all') && ($semester != 'all')){
							echo"<div class='smallred indent'>random 10 - <a href='allreplies.php?evalID=" . $evalID . "&questionID=" . $questionID . "'>See all replies.</a></div>";
						}else{
							echo"<div class='smallred indent'>random 10</div";
						}
					}
						
			echo"<div class='indent'>-" . $textoption . "</div>";
			
			}
			
			
		}//close evalID loop
		echo "<br/>";
		$i++;//increment counter
		}
		
	}
	
}

        

//ITTERATE THROUGH STANDARD ASSESSMENT
//******************************************************************
$assessmentID=1;
$query = mysql_query("SELECT questionID from Assessments WHERE assessmentID='$assessmentID' ORDER BY questionorder");
while($row = mysql_fetch_array($query)){
     $questionID= $row['questionID'];
	    	
     	//GET QUESTION TEXT
     	$query3 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
		$result = mysql_fetch_array($query3);
		$questionText=$result['questionText'];
		$questionType = $result['type'];
		
//LIKERT		
		if($questionType == 'likert'){
   		echo "Q" . $i . ": " . $questionText;
   		
   			//GET ANSWERS TO THIS QUESTION ID
			$answers[]=array();
			$x=0;
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID' ORDER BY ratingvalue");
			while($row = mysql_fetch_array($query2)){
			$answers[$x]=$row['answerText'];
			$x++;
			}
        	        		
			//GET SCORE FOR EACH QUESTION
			$questionTotalScore=0;
			$howmanyscores = 0;
		foreach($evalIDs as $evalID){//array of sorted evals
			$query3 = mysql_query("SELECT * from Scoring WHERE questionID='$questionID' AND evalID='$evalID'");
			while($thisrow = mysql_fetch_array($query3)){	
				$score =  $thisrow['score'];
				$howmanyscores++;				
				$questionTotalScore= $questionTotalScore + $score;
			}
		}//close evalID loop
			
			// DO THE BAR GRAPHS IF TOTAL SCORE > 0
			if($questionTotalScore>0){
				$topScoreAvailable = topratingvalue($questionID) * $howmanyscores;
				$fraction= number_format($questionTotalScore/$topScoreAvailable * 900);
				echo"<div class='scorebox'><div class='score' style='width:" . $fraction . "px;'/>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average  . "/4";
				
				//percent calculation
				$percent = number_format($questionTotalScore/$topScoreAvailable * 100);
				echo "&nbsp;&nbsp;&nbsp;" . $percent . "%";
				echo "</div></div>";
			}else{
				echo"<div class='scorebox'>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average;
				echo "</div>";
			}
						
			//SHOW SCALE
			echo "<div style='width:900px;font-size:.7em;color:#990000;'>";
			echo "<div style='float:left;width:165px;'>" . $answers[0] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[1] . "</div>";
			echo "<div style='float:left;width:190px;text-align:center;'>" . $answers[2] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[3] . "</div>";
			echo "<div style='float:right;width:165px;text-align:right;'>" . $answers[4] . "</div>";
			echo "</div><br/>";
			
			$i++;//increment counter			
		}
		

//MULTIPLE CHOICE OR RADIO OR TRUE/FALSE	
		elseif(($questionType == 'mc-check') || ($questionType == 'mc-radio') || ($questionType == 'tf')){
			echo "Q" . $i . ": " . $questionText;
			//GET ALL ANSWERS FOR THIS QUESTION
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID'");
				while($row = mysql_fetch_array($query2)){
				$answerID= $row['answerID'];
				//COUNT HOW MANY FROM SCORING
				$howmanyscores=0;
			foreach($evalIDs as $evalID){//array of sorted evals
				$query3 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID'AND score = '$answerID' AND evalID='$evalID'");
				while($thisrow = mysql_fetch_array($query3)){	
				$howmanyscores++;				
				}
			}//close evalID loop
			echo "<div class='indent'>" . $howmanyscores . " - " . $row['answerText'] . "</div>";
			}
			echo"<br/>";
			$i++;//increment counter
		}

//HEADING
		elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
		}

//TEXT RESPONSE		
		elseif($questionType == 'text'){
		
		//PLACE ALL ROWIDS THAT MATCH IN ARRAY
		$rowcounter=0;
		$textrows = array();
		foreach($evalIDs as $evalID){//array of sorted evals			
			$query2 = mysql_query("SELECT rowID FROM TextOption WHERE questionID ='$questionID' AND evalID='$evalID'");
			while($row = mysql_fetch_array($query2)){
			$textrows[$rowcounter]=$row['rowID'];
			$rowcounter++;
			}			
		}//close evalID loop
		
		shuffle($textrows);
		$tenrows = array_slice($textrows,0,10);
		foreach($tenrows as $thisone){
			
			//GET TEXT FOR THESE TEN RANDOM CHOICES
			$query5 = mysql_query("SELECT * from TextOption WHERE rowID ='$thisone' ");
			while($row = mysql_fetch_array($query5)){
			$textoption = $row['textoption'];
			$textoption = stripslashes($textoption);
     			//$questionID= $row['questionID'];
     				//this is to list question only once 
					if(!in_array($questionID,$questionlist)){
					$questionlist[]=$questionID;
				
					$query6 = mysql_query("SELECT questionText from Questions WHERE questionID='$questionID'");
					$result = mysql_fetch_array($query6);
					$questionText=$result['questionText'];					
					echo "Q" . $i . ": " . $questionText;
						
						//display 'all replies link' for section search
						if(($section != 'all') && ($semester != 'all')){
							echo"<div class='smallred indent'>random 10 - <a href='allreplies.php?evalID=" . $evalID . "&questionID=" . $questionID . "'>See all replies.</a></div>";
						}else{
							echo"<div class='smallred indent'>random 10</div>";
						}
					}
						
			echo"<div class='indent'>- " . $textoption . "</div>";
			
			}
			
			
		}//close shuffled ten loop
		echo "<br/>";
		$i++;//increment counter
		}
		
}


//CUSTOM QUESTIONS
//*****************************************************************
//SELECT QUESTIONS FROM CUSTOM EVAL
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment = 0 ORDER BY rowID");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
    
    //GET QUESTION TEXT
     	$query3 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
		$result = mysql_fetch_array($query3);
		$questionText=$result['questionText'];
		$questionType = $result['type'];
		
//LIKERT		
		if($questionType == 'likert'){
   		echo "Q" . $i . ": " . $questionText;
   		
   			//GET ANSWERS TO THIS QUESTION ID
			$answers[]=array();
			$x=0;
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID' ORDER BY ratingvalue");
			while($row = mysql_fetch_array($query2)){
			$answers[$x]=$row['answerText'];
			$x++;
			}
        	        		
			//GET SCORE FOR EACH QUESTION
			$questionTotalScore=0;
			$howmanyscores = 0;
		foreach($evalIDs as $evalID){//array of sorted evals
			$query4 = mysql_query("SELECT * from Scoring WHERE questionID='$questionID' AND evalID='$evalID'");
			while($thisrow = mysql_fetch_array($query4)){	
				$score =  $thisrow['score'];
				$howmanyscores++;				
				$questionTotalScore= $questionTotalScore + $score;
			}
		}//close evalID loop
			
			// DO THE BAR GRAPHS IF TOTAL SCORE > 0
			if($questionTotalScore>0){
				$topScoreAvailable = topratingvalue($questionID) * $howmanyscores;
				$fraction= number_format($questionTotalScore/$topScoreAvailable * 900);
				echo"<div class='scorebox'><div class='score' style='width:" . $fraction . "px;'/>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average;
				
				//percent calculation
				$percent = number_format($questionTotalScore/$topScoreAvailable * 100);
				echo "&nbsp;&nbsp;&nbsp;" . $percent . "%";
				echo "</div></div>";
			}else{
				echo"<div class='scorebox'>";
				//number calculation
				$average = number_format($questionTotalScore/$howmanyscores, 1);
				echo "&nbsp;" . $howmanyscores . " Scores&nbsp;&nbsp;&nbsp;Average: " . $average;
				echo "</div>";
			}
						
			//SHOW SCALE
			echo "<div style='width:900px;font-size:.7em;color:#990000;'>";
			echo "<div style='float:left;width:165px;'>" . $answers[0] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[1] . "</div>";
			echo "<div style='float:left;width:190px;text-align:center;'>" . $answers[2] . "</div>";
			echo "<div style='float:left;text-align:center;width:190px;'>" . $answers[3] . "</div>";
			echo "<div style='float:right;width:165px;text-align:right;'>" . $answers[4] . "</div>";
			echo "</div><br/>";
			
			$i++;//increment counter			
		}
		

//MULTIPLE CHOICE OR RADIO OR TRUE/FALSE	
		elseif(($questionType == 'mc-check') || ($questionType == 'mc-radio') || ($questionType == 'tf')){
			echo "Q" . $i . ": " . $questionText;
			//GET ALL ANSWERS FOR THIS QUESTION
			$query2 = mysql_query("SELECT * from Answers WHERE questionID= '$questionID'");
				while($row = mysql_fetch_array($query2)){
				$answerID= $row['answerID'];
				//COUNT HOW MANY FROM SCORING
				$howmanyscores=0;
			foreach($evalIDs as $evalID){//array of sorted evals
				$query4 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID'AND score = '$answerID' AND evalID='$evalID'");
				while($thisrow = mysql_fetch_array($query4)){	
				$howmanyscores++;				
				}
			}//close evalID loop
			echo "<div class='indent'>" . $howmanyscores . " - " . $row['answerText'] . "</div>";
			}
			echo"<br/>";
			$i++;//increment counter
		}

//HEADING
		elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
		}

//TEXT RESPONSE		
		elseif($questionType == 'text'){
		foreach($evalIDs as $evalID){//array of sorted evals
			$query5 = mysql_query("SELECT * from TextOption WHERE questionID ='$questionID' AND evalID='$evalID' ORDER BY rand() LIMIT 10");
			while($row = mysql_fetch_array($query5)){
			$textoption = $row['textoption'];
			$textoption = stripslashes($textoption);
     			$questionID= $row['questionID'];//this is to list question only once 
					if(!in_array($questionID,$questionlist)){
					$questionlist[]=$questionID;
				
					$query6 = mysql_query("SELECT questionText from Questions WHERE questionID='$questionID'");
					$result = mysql_fetch_array($query6);
					$questionText=$result['questionText'];					
					echo "Q" . $i . ": " . $questionText;
						
						//display 'all replies link' for section search
						if(($section != 'all') && ($semester != 'all')){
							echo"<div class='smallred indent'>random 10 - <a href='allreplies.php?evalID=" . $evalID . "&questionID=" . $questionID . "'>See all replies.</a></div>";
						}else{
							echo"<div class='smallred indent'>random 10</div";
						}
					}
						
			echo"<div class='indent'>-" . $textoption . "</div>";
			
			}
			
			
		}//close evalID loop
		echo "<br/>";
		$i++;//increment counter
		}
		
}



}//CLOSE NO SUBMISSIONS FOUND 

?>

</div>
</div>
 </body>
 </html>