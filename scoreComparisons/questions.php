<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

//include "validateID.php";

//include "functions.php";

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
	Questions Used for Average Score
	</div>
	<div class="indent smallred">Strongly disagree = 0 &nbsp; Strongly agree = 4: </div>

<form  name='assessmentForm' method='post' action='saveScore.php' onsubmit='submitbutton.disabled = true; return true;'>

<?php
$questionIDs = array(1,3,4,5,6,7,2,8,9,10,24); 
$qi=1;
foreach($questionIDs as $questionID){

	//GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=nl2br($questionText);
			$questionText=stripslashes($questionText);
			$questionType = $result['type'];
		
			echo "<div class='question'>Q" . $qi . ": " . $questionText . "<br/>";							
			//GET ANSWERS
			$query4 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY ratingvalue asc");
			$labelcount=1;//for creating unique ID for each answer
			while($row = mysql_fetch_array($query4)){
        		$answerText=$row['answerText'];
        		$ratingvalue=$row['ratingvalue'];
   				echo "<span class='answer'><input name='Q" . $questionID . "' id='Q" . $questionID . "_" . $labelcount . "' type='radio' value='" . $ratingvalue . "'/><label for='Q" . $questionID . "_" . $labelcount . "'> " . $answerText . "</label></span>";
   				$labelcount++;
			}
			echo "</div>";
			$qi++;
			
}
?>

</form>

</div>
</div>
 </body>
 </html>