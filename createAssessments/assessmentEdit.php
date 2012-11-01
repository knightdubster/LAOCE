<?php

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$assessmentID=$p_assessmentID;

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

//CHECK INSTRUSCTOR OR ADMIN ROLE - gets user info- $name
include "validateID.php";


//ASSESSMENT DISPLAY EDIT   
//GET DESCRIPTION AND AUTHOR USERID 

	$query = mysql_query("SELECT * from AssessmentsDescription WHERE assessmentID='$assessmentID'");
		$result = mysql_fetch_array($query);
		$description =  $result['description'];
		$author = $result['author'];
		$assessName=$result['assessName'];
		
//GET USER INFO
		$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
		$result = mysql_fetch_array($query);
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$name = $firstname . " " . $lastname;



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Assessment Edit</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />
<style type="text/css">
li{
list-style:none;
cursor:move;
}

</style>

<script type="text/javascript" src="../scripts/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.8.9.custom.min.js"></script>

<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
<!--hide script from old browsers

//jQuery for drag and drop poistioning of questions
$(document).ready(function(){
 
    $(function() {
        $("#container ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
            $.post("updateQuestionOrder.php", order, function(theResponse){
                $("#contentRight").html(theResponse);
            });
        }
        });
    });
 
});

//-->
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
<div style="float:right;"><a href="../admin/">Admin Portal</a></div>
<span class="heading">Assessment No. <?php echo $assessmentID;?> </span>

<form style="margin:auto;border: 1px solid #000099;padding:10px;text-align:left;" name="assessment" method="post"  action="saveAssessmentEdit.php">
<input style="float:right;" type="submit" value="Save Changes"/>
Assessment Name <input name="assessName" size="50" value="<?php echo $assessName; ?>"><br/>
Description<br/><textarea name="description" style="width:920px;" rows="2"><?php echo $description; ?></textarea>
<input name="userID" type="hidden" value="<?php echo $userID; ?>"/><br>
<input name="assessmentID" type="hidden" value="<?php echo $assessmentID; ?>"/>
</form>

<span class='smallred'>Question boxes can be dragged to arrange order.</span>
<?php
	//GET QUESTION ID'S USED IN THIS ASSESSMENT
	$i=1;
	echo"<ul>";
	$query = mysql_query("SELECT questionID from Assessments WHERE assessmentID='$assessmentID' ORDER BY questionorder");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
        
        //GET QUESTION
        $query2 = mysql_query("SELECT * from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
			$questionText=$result['questionText'];
			$questionText=stripslashes($questionText);
			$questionText=nl2br($questionText);
			echo"<li id='recordsArray_" . $questionID . "'>";
			echo "<div class='question'>Question " . $i . ": " . $questionText;
			echo "<div class='editButton'><form method='post' action='editQuestion.php'><input name='questionID' type='hidden' value='" . $questionID . "'/><input name='assessmentID' type='hidden' value='" . $assessmentID . "'/><input type='submit' value='Edit/Delete'></form></div>";
			
		
		//GET ANSWERS
		$query3 = mysql_query("SELECT * from Answers WHERE questionID='$questionID' ORDER BY answerID desc ");
		while($row = mysql_fetch_array($query3)){
			if($row['textoption']==0){
        	$answerText = $row['answerText'];
        	//$answerText = stripslashes($answerText);
   			echo "<div class='answer'><input type='checkbox'/> " . $row['answerText'] . "</div>";
   			}else{
   			echo"<div style='border:solid 1px #000;padding:20px;'>This question has a text area for response.</div>";
   			}
		}
		echo "</div><br>";
		echo "</li>";
		$i++;//increment question counter
	}
	
        	

//ADD QUESTION BUTTON
echo"<form method='post' action='addQuestion.php'>
<input name='userID' type='hidden' value='" . $userID . "'/>
<input name='description' type='hidden' value='" .  $description .  "'/>
<input name='assessmentID' type='hidden' value='" .  $assessmentID . "'/>
<input style='float:left;' type='submit' value='Add another question'/>
</form>";
/*
//DELETE ASSESSMENT BUTTON
echo"<form style='float:right;' method='post' action='deleteAssessment.php'>
<input name='assessmentID' type='hidden' value='" .  $assessmentID . "'/>
<input type='submit' value='Delete Assessment'/>
</form>";
*/
?>
<br/>
</div>
</div>
<br/><br/>
</div>
</body>
</html>