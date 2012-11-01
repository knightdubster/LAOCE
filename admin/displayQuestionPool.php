
<?php
/*
THIS PAGE IS CALLED BY THE QUESTION POOL VIEW LINK 
IT IS THE SAME AS displayAssessment.php EXCEPT IT INCLUDES 
ADDITIONAL INFO/LINKS FOR THE QUESTION POOL ASSESSMENT
*/

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

include "validateID.php";

//the question pool assessment id is 3
$assessmentID=3;


$query = mysql_query("SELECT * from AssessmentsDescription WHERE assessmentID='$assessmentID'");
		$result = mysql_fetch_array($query);
		$assessName= $result['assessName'];
		$description = $result['description'];

?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Assessment</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<script LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>

</script>

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
<div style="float:right;margin-left:10px;"><a href="index.php">Return</a></div>
<div style="float:right;width:350px;">
<ul class='smallred'>
<li>"Questions" in bold are headings. No data.</li>
<li>Coursename links display data for all semesters, all sections for that course.</li>
<li>"All" link displays all data for every instance of the question regardless of course.</li>
<ul>
</div>


<?php
echo"<div class='heading'>" . $assessName . "</div>";

echo "<form  name='assessmentForm' method='post' action='#'>";


	//GET QUESTION ID'S USED IN THIS ASSESSMENT
	$qi = 1; //question increment
	$query = mysql_query("SELECT * from Assessments WHERE assessmentID='$assessmentID' ORDER BY questionorder");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
        
        //GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=nl2br($questionText);
			$questionType = $result['type'];
	
		if($questionType == 'likert'){		
			echo "<div class='question'>Q" . $questionID . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue desc ");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $ratingvalue . "'/><label for='Q" . $questionID . "_" . $labelcount . "'>" . $answerText . "</label></span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'mc-check'){
			echo "<div class='question'>Q" . $questionID . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "[] id='Q" . $questionID . "_" . $labelcount . "' type='checkbox' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";		
			}
			echo "</div>";
			$qi++;
		
		}elseif($questionType == 'mc-radio'){
			echo "<div class='question'>Q" . $questionID . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'>" . $answerText . "</label></span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'tf'){
			echo "<div class='question'>Q" . $questionID . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
				$answerID=$row['answerID'];
        		$answerText=$row['answerText'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $answerID . "'/><label for='Q" . $questionID . "_" . $labelcount . "'>" . $answerText . "</label></span>";		
			}
			echo "</div>";
			$qi++;
			
		}elseif($questionType == 'heading'){
			echo "<br/><h3>" . $questionText . "</h3>";
			
			
		}elseif($questionType == 'text'){
			echo "<div class='question'><label for='Q" .  $questionID . "_1'> Q" . $questionID . ": " . $questionText . "<label><br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:800px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}
		
		
		//INFO FOR EACH QUESTION DISPLAYED HERE		
		//FIND COURSES THAT USED THIS QUESTION
			$queryCustom = mysql_query("SELECT * from CustomEvalArchive WHERE questionID = '$questionID'");
			echo "&nbsp;&nbsp;&nbsp;&nbsp;Used in: ";
			while($row = mysql_fetch_array($queryCustom)){
			echo "<a href='displayCustomScores.php?coursename=" .$row['coursename'] . "&questionID=" . $questionID . "'>" . $row['coursename'] . "</a>, ";
			}
			
			//IF QUESTION USED IN MORE THAN ONE COURSENAME, DISPLAY 'ALL' LINK
			if (mysql_num_rows($queryCustom) > 1) {
			echo "<a href='displayAllCustomScores.php?coursename=all&questionID=" . $questionID . "'>" . All . "</a>, ";
			}
		echo "<br/><br/>";
	}
	

	

echo"<br/>";
echo "<input type='submit' value='Submit This Course Evaluation' />";
echo"</form>";

echo "</div>";//close form box
?>

</div>
<br/><br/><br/>
</div>

</body>
</html>