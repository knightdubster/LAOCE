<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "../admin/validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename=strtoupper($p_coursename);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Customize Evaluation</title>

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
<div style="float:right;"><a href="displayEval.php?coursename=<?php echo $coursename; ?>">View this Evaluation</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='../admin/index.php'>Admin</a></div>
<div class="heading">Customize the Evaluation for <?php echo  strtoupper($coursename); ?> </div>
Additional questions specific to the course can be added to the standard evaluation. If an appropriate question is not available a new one can be added to the pool.
<div class='smallred indent'>Note: Additional questions to the evaluation will appear in the order they are shown here. Choose questions from the pool in the order you wish them to appear.</div>

<?php

//IF ANY CUSTOM QUESTIONS DISPLAY IN BLUE BOX
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment=0");
$result = mysql_fetch_array($query);
if(isset($result['questionID'])){
	 	echo"<div class='bluebox roundcorners'><strong>Current custom questions for this course:</strong><br/>";
	
		echo "<form  name='assessmentForm' method='post' action='deleteCustomEval.php'>";
		echo "<input type='hidden' name='coursename' value='" . $coursename . "'>";
	
	$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment=0 ORDER BY rowID");
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
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo" Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . " Heading: <strong>" . $questionText . "</strong></div>";
			$qi++;
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:800px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}	
	}
	echo "<input type='submit' value='DELETE CHECKED QUESTIONS'>";
	echo "</form></div>";
}

//INSTRUCTOR ASSESSMENT Y/N?
echo "<br/><br/><div style='float:left;'><strong>Instructor Assessment Questions</strong>&nbsp;&nbsp;</div>";
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment=1");
$result = mysql_fetch_array($query);
if(isset($result['instructorAssessment'])){
	echo "<br/><div class='bluebox roundcorners'>The evaluation for " . $coursename . " includes the Instructor Assessment questions.&nbsp;&nbsp;";
	echo "<form method='post' action='removeInstructorAssessment.php'>
	<input type='hidden' name='coursename' value='" . $coursename . "'/>
	<input type='submit' value='REMOVE'></form></div>";
}else{
	echo "<form method='post' action='addInstructorAssessment.php'>
	<input type='hidden' name='coursename' value='" . $coursename . "'/>
	<input type='submit' value='ADD'></form>";
	echo "<div class='indent smallred'>-this group of questions evaluates instructor performance</div>";
	
}


//DISPLAY QUESTION POOL
echo"<br/><div>";
echo "<strong>Question Pool</strong>";
echo "<form  name='assessmentForm' method='post' action='saveCustomEval.php'>";
echo "<input type='hidden' name='coursename' value='" . $coursename . "'>";

//GET QUESTION ID'S USED IN THIS ASSESSMENT
	$qi = 1; //question increment
	$query = mysql_query("SELECT * from Assessments WHERE assessmentID=3 ORDER BY questionorder");
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
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo" Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'>&bull; " . $answerText . "</span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . " Heading: <strong>" . $questionText . "</strong></div>";
			$qi++;
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'>";
			echo "<input type='checkbox' name='question[]' value='" . $questionID . "'>";
			echo " Q" . $qi . ": " . $questionText . "<br/>";							
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:800px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}	
	}
	
	echo "<input type='submit' value='ADD THESE QUESTIONS TO THIS COURSE'>";
echo "</form></div>";

?>
<div style="width:200px;margin:-20px 300px;"> 
<form method='post' action='addQuestion.php?assessmentID=3'>
<input type='submit' value='ADD A NEW QUESTION TO THE POOL'>
</form>
</div>
<p>&nbsp;</p>
</div>
</body>
</html>