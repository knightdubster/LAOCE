<?php
//THIS PAGE DISPLAYS ALL SCORES FOR A CUSTOM QUESTION FOR A GIVEN COURSENAME
//THIS WOULD INCLUDE ALL SEMESTERS AND SECTIONS

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

include "functions.php";


//IMPORT VARIABLES
import_request_variables("pg","p_");
	$coursename = $p_coursename;
	$questionID = $p_questionID;
	
		
//HOW MANY SUBMITTED THIS EVALUATION
$submitted=0;
$query = mysql_query("SELECT * from Scoring WHERE questionID='$questionID'");
	while($row = mysql_fetch_array($query)){
	$submitted++;
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
	<div style="float:right;"><a href="displayQuestionPool.php?assessmentID=3">Return</a></div>
	<div class='heading'>
	Course: <?php echo $coursename; ?> &nbsp;&nbsp;&nbsp;
	<br/>
	<?php
	
	
	echo "</div><br/>";


//IF NO SUBMISSIONS DISPLAY NO DATA FOUND
if($submitted==0){
	echo "<div style='text-align:center;height:400px;'><h3>No entries found for this search criteria.</h3></div>";
	}else{

$i=1;//question counter	


//CUSTOM QUESTIONS
//*****************************************************************

    
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
		
			$query4 = mysql_query("SELECT * from Scoring WHERE questionID='$questionID'");
			while($thisrow = mysql_fetch_array($query4)){	
				$score =  $thisrow['score'];
				$howmanyscores++;				
				$questionTotalScore= $questionTotalScore + $score;
			}
		
			
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
			
				$query4 = mysql_query("SELECT score from Scoring WHERE questionID='$questionID'AND score = '$answerID'");
				while($thisrow = mysql_fetch_array($query4)){	
				$howmanyscores++;				
				}
			
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
		
			$query5 = mysql_query("SELECT * from TextOption WHERE questionID ='$questionID' ORDER BY rand() LIMIT 10");
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
			
		echo "<br/>";
		$i++;//increment counter
		}
		


}//CLOSE NO SUBMISSIONS FOUND 

?>

</div>
</div>
</body>
</html>