<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$questionID = $p_questionID;
$assessmentID = $p_assessmentID;

include "../dbconnect.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assessment Edit</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<script type="text/javascript">
	//THIS FUNCTION IS CALLED WITH ADD ANOTHER CHOICE BUTTON
	//SUBMITS ENTIRE FORM BUT CHANGES HIDDEN addChoice FORM VALUE TO 1
	function submitform(){
		document.getElementById('addChoice').value=1;
		document.getElementById('editQuestions').submit();
	}
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
<form id='editQuestions' method='post' action='saveEditQuestion.php'>
<?php
	
//GET QUESTION
        $query = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query);
			$questionText=$result['questionText'];
			$questionType=$result['type'];
			echo "<div style='float:right;width:180px;'>Question Type: " . $questionType . "</div>";
			echo "<div class='question'>Question:<br/> <textarea name='question' rows='5' style='width:100%;' >" . $questionText . "</textarea>";
		
		
		//GET ANSWERS
	$i=1;
		$query = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY answerID");
		while($row = mysql_fetch_array($query)){
        	if($questionType=='likert'){
   			echo "<div class='answer'>Score " . $row['ratingvalue'] . "<br/><textarea name='answer" . $i . "' rows='5' style='width:100%;' >" . $row['answerText'] . "</textarea><input name='answerID-" . $i . "' type='hidden' value='" . $row['answerID'] . "'/></div>";
   			$totalAnswers=$i;
   			$i++;
   			}elseif(($questionType=='mc-check') || ($questionType=='mc-radio')){
   				echo "<div class='answer'>Choice " . $i;
   				/*
   				echo "<div style='float:right;width:130px;'> <form method='post' action='deleteChoice.php'><input type='hidden' value='" . $row['answerID'] . "'><input type='submit' value='Delete this choice'></form></div>"; 
   				*/
   				echo "<div style='float:right;width:130px;'><a href='deleteChoice.php?answerID=" . $row['answerID'] . "&assessmentID=" . $assessmentID . "'>Delete this choice</a></div>";
   				
   				echo "<br/><textarea name='answer" . $i . "' rows='4' style='width:100%;' >" . $row['answerText'] . "</textarea><input name='answerID-" . $i . "' type='hidden' value='" . $row['answerID'] . "'/></div>";
   			$totalAnswers=$i;
   			$i++;
   			}elseif($questionType=='text'){
   			echo"<div style='border:solid 1px #000;padding:20px;'>This question has a text area for response.</div>";
   			$totalAnswers=1;
   			
   			}elseif($questionType=='tf'){
   			echo"<div style='border:solid 1px #000;padding:10px;'>" . $row['answerText'] . "</div>";
   			$totalAnswers=1;
   			}
		}
		
		echo"</div><br/>";
		
//IF MULTIPLE CHOICE QUESTION ADD ANOTHER CHOICE OPTION

		if(($questionType=='mc-check') || ($questionType=='mc-radio')){
			/*echo "<div style='float:right;width:130px;'><form method='post'>";
			echo"<input type='button' name='submit' value='Add another choice' onclick='submitform()';>";
			echo "</form>";			
			echo"</div>"; */			
			
			echo "<div style='float:right;width:170px;'><a href='addChoice.php?questionID=" . $questionID . "&assessmentID=" . $assessmentID . "'>Add another choice</a></div>";
			
			
			}

echo "<input name='totalAnswers' type='hidden' value='" . $totalAnswers . "'/>";
echo "<input name='questionID' type='hidden' value='" . $questionID . "'/>";
echo "<input name='assessmentID' type='hidden' value='" . $assessmentID . "'/>";
//echo "<input id='addChoice' name='addChoice' type='hidden' value='0'/>";
?>
<div><input type='submit' value='Save Changes'></form></div>

<!--DELETE QUESTION-->
<div style="float:left;margin-left:100px;margin-top:-1.2em;">
<form method='post' action='deleteQuestion.php'>
<?php 
echo "<input name='questionID' type='hidden' value='" . $questionID. "'/>";
echo "<input name='assessmentID' type='hidden' value='" . $assessmentID. "'/>";
?>
<input type='submit' value='Delete Question'>
</form></div>

<!--CANCEL-->
<div style="float:left;margin-left:10px;margin-top:-1.2em;">
<form method='post' action='assessmentEdit.php'>
<?php echo "<input name='assessmentID' type='hidden' value='" . $assessmentID. "'/>";?>
<input type='submit' value='Cancel'>
</form></div>
<br/>
</div>
<br/><br/><br/>
</div>
</div>
</body>
</html>