
<?php


//CONNECT TO DB
include "dbconnect.php";


//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
//$assessmentID=$p_assessmentID;


$query = mysql_query("SELECT * from AssessmentsDescription WHERE assessmentID='$assessmentID'");
		$result = mysql_fetch_array($query);
		$assessName= $result['assessName'];
		$description = $result['description'];
		
$assessments=array(1,2);


?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Assessment</title>

<link rel="stylesheet" type="text/css" href="styles.css" />

<script LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>

</script>

</head>
<body>
<div id="background">
<div id="container">
<div class="logo"><img src="images/PSUblack-border10.png"></div>
<div id="header">
	<div class="laoce">Liberal Arts Online Course Evaluation</div>
	
</div>

<div id="content" class='roundcorners'>

<?php
echo"<div class='heading'>" . $assessName . "</div>";

echo "<form  name='assessmentForm' method='post' action='#'>";
$qi = 1; //question increment
foreach($assessments as $assessmentID){

	//GET QUESTION ID'S USED IN THIS ASSESSMENT
	
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
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
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
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
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
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
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
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
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
			echo "<div class='question'><label for='Q" .  $questionID . "_1'> Q" . $qi . ": " . $questionText . "<label><br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID'");
				echo"<div class='answer'><textarea name='Q" . $questionID . "' id='Q" .  $questionID . "_1' style='width:800px;' rows='5'></textarea></div>";		
			echo "</div>";
			$qi++;			
			
		//echo "</div>";
		
		}	
	}
	echo "<br/>";


}

echo "<input type='submit' value='Submit This Course Evaluation' />";
echo"</form>";

echo "</div>";//close form box


?>

</div>
<br/><br/><br/>
</div>

</body>
</html>