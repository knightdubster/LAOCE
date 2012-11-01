
<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID=$p_eval;


//CONNECT TO DB
include "../dbconnect.php";

//GET COURSE INFO
$query = mysql_query("SELECT * from CourseInfo WHERE evalID='$evalID'");
		$result = mysql_fetch_array($query);
		$coursename=$result['coursename'];
		$semester = $result['semester'];
		$section = $result['section'];
		$begin = $result['begin'];
		$end = $result['end'];
		
$today = time();

?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Evaluation Form</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type="text/css">
#background{
	width:1000px;
	background-image:url('../images/sparks1000.jpg');
	}

#container{
	width:800px;
	}

</style>

</head>
<body>
<div id="background">
<div id="container">

<div class="logo"><img src="../images/PSUblack-border10.png" alt="Penn State Logo"></div>
<div id="header">
<div class="laoce">Liberal Arts Online Course Evaluation</div>
</div>

<?php


echo "<div id='content' class='roundcorners'>";
echo"<div style='color:#006633;font-size:1.3em;font-weight:bold;'>Course: " . $coursename . "&nbsp;&nbsp;&nbsp;Section: " . $semester . "-". $section . "</div>";

echo"<div id='leftcol1' class='roundcorners'>";

//CONDITIONALS TO DISPLAY SURVEY
//*********************************************
//HAS THIS USER ALREADY SUBMITTED FOR THIS EVALUATION?
$query = mysql_query("SELECT submittedBy from Scoring WHERE evalID = '$evalID'  AND submittedBy = '$userID'");
        $result = mysql_fetch_array($query);
		if(isset($result['submittedBy'])){
			echo"<div style='text-align:center;'><h3>You have previously sumitted this evaluation.</h3></div>";
			exit();
		}

//EVALID DOES NOT EXIST
$query = mysql_query("SELECT evalID from CourseInfo WHERE evalID = '$evalID'");
        $result = mysql_fetch_array($query);
		if(!isset($result['evalID'])){
			echo"<div style='text-align:center;margin:40px;'><h3>ERROR: This evaluation can not be found.</h3>If you think this is in error contact your course administrator.</div>";
			exit();
		}
		
//NOT IN AVAILABLE DATES WINDOW
	if(($today < $begin) || ($today > $end)){
		echo"<div style='text-align:center;margin:40px;'><h3>This evaluation is not available at this time.</h3></div>";
		exit();
	}



//BEGIN FORM
//***************************
echo "<form  name='assessmentForm' method='post' action='saveScore.php' onsubmit='submitbutton.disabled = true; return true;'>";

$qi = 1; //question increment

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
        
        //GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=nl2br($questionText);
			$questionText=stripslashes($questionText);
			$questionType = $result['type'];
	
		if($questionType == 'likert'){		
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $ratingvalue . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "[]' id='Q" . $questionID . "_" . $labelcount . "' type='checkbox' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'><label for='Q" .  $questionID . "_1'> Q" . $qi . ": " . $questionText . "</label><br/>";							
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:700px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}	
	}

}//CLOSE IF INSTRUCTOR QUESTIONS CONDITIONAL




//STANDARD ASSESSMENT
//*****************************************************
$assessmentID=1;


	//GET QUESTION ID'S USED IN THIS ASSESSMENT
	$query = mysql_query("SELECT * from Assessments WHERE assessmentID='$assessmentID' ORDER BY questionorder");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
        
        //GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=nl2br($questionText);
			$questionText=stripslashes($questionText);
			$questionType = $result['type'];
	
		if($questionType == 'likert'){		
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $ratingvalue . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "[]' id='Q" . $questionID . "_" . $labelcount . "' type='checkbox' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'><label for='Q" .  $questionID . "_1'> Q" . $qi . ": " . $questionText . "</label><br/>";							
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:700px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}	
	}


//CUSTOM QUESTIONS
//*****************************************************************
//SELECT QUESTIONS FROM CUSTOM EVAL
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment != 1 ORDER BY rowID");
while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
       //GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=nl2br($questionText);
			$questionText=stripslashes($questionText);
			$questionType = $result['type'];
	
		if($questionType == 'likert'){		
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $ratingvalue . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "[]' id='Q" . $questionID . "_" . $labelcount . "' type='checkbox' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";	
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'><label for='Q" .  $questionID . "_1'> Q" . $qi . ": " . $questionText . "</label><br/>";							
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:700px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;					
		}	
	
}




echo "<input name='evalID' type='hidden' value='" . $evalID . "'/>";

echo "<input type='submit' name='submitbutton' value='SUBMIT THIS COURSE EVALUATION' />";
echo"</form>";

echo "</div>";//close form box
?>

<br/>
</div>
<br/>
</div><!--close background-->
</body>
</html>