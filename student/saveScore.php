<?php
//SAVE SCORE

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID=$p_evalID;


//$datesubmitted=date("Y-m-d h:i");
$datesubmitted=time();

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

//GET COURSENAME
$query = mysql_query("SELECT * from CourseInfo WHERE evalID = '$evalID'");
        	$result = mysql_fetch_array($query);
        	$coursename=$result['coursename'];



//DID THIS USERID PREVIOUSLY SUBMIT?
		$query = mysql_query("SELECT submittedBy from Scoring WHERE evalID = '$evalID'  AND submittedBy = '$userID'");
        	$result = mysql_fetch_array($query);
			if(isset($result['submittedBy'])){
				echo"<div style='text-align:center;'><h3>You have previously sumitted this evaluation.</h3></div>";
				exit();
				}
			
/*
//CHECK FOR COMPLETED FORM	
//GET QUESTION ID'S USED IN THIS ASSESSMENT	
		$query = mysql_query("SELECT * from Assessments WHERE assessmentID='1'");
		while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
              
    	$score = "p_Q" . $questionID;
        if(!isset($$score)){
       		echo"<script>
       		alert('Please complete all entries in the form');
        	history.go(-1);
        	</script>";
        	exit();
        }
	}
	
//GET ADITIONAL QUESTION ID'S FROM CustomEval	
		$query = mysql_query("SELECT questionID from CustomEval WHERE coursename='$coursename'");
		while($row = mysql_fetch_array($query)){
    		$questionID= $row['questionID'];         
    		$score = "p_Q" . $questionID;
        	if(!isset($$score)){
       			echo"<script>
       			alert('Please complete all entries in the form');
        		history.go(-1);
        		</script>";
       			exit();
       		}
		}
//FORM IS COMPLETE - SAVE DATA TO SCORING TABLE		
*/


//STANDARD ASSESSMENT
//**************************************************
$assessmentID=1;
	$query = mysql_query("SELECT * from Assessments WHERE assessmentID='$assessmentID'");
	while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
       
        //FROM THE FORM THE ID/NAME OF EACH SCORE IS DYNAMIC ADDING QUESTION ID        
        $score = "p_Q" . $questionID;
        $getVal = $$score;
       
     	if($getVal != ""){//do not save null entries
        	//WHAT QUESTION TYPE?
        	$query2 = mysql_query("SELECT type from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
        	$questionType=$result['type'];

        
     		if($questionType=='likert'){
     		mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
     	
     		}elseif($questionType=='mc-check'){
     			foreach($getVal as $val){
     			//enter multiple answerID's as score for this checkbox mc question
     				mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$val', '$datesubmitted')");
     			}
     	
     		}elseif(($questionType=='mc-radio') || ($questionType=='tf')){
     			//enter answerID as score for this mc question
     			mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID','$questionID', '$userID', '$getVal', '$datesubmitted')");
     			
     		
     		}elseif($questionType=='text'){
     			//clean up $getVal text
				$getVal = strip_tags($getVal);
				$getVal = nl2br($getVal);
				//$getVal = htmlentities($getVal, ENT_QUOTES);
				$getVal = mysql_escape_string($getVal);
				if($getVal != ""){
					//WRITE TO TextOption TABLE
					mysql_query("INSERT INTO TextOption (evalID, questionID, submittedBy, textoption, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
					//WRITE 'text' SCORE TO SCORING TABLE
					//mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', 'text', '$datesubmitted')");
				}
		
			}
		
		}//close null entry conditional
	
	}

	
//CUSTOM QUESTIONS
//*****************************************************************
//SELECT QUESTIONS FROM CUSTOM EVAL
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename' AND instructorAssessment = 0 ORDER BY rowID");
while($row = mysql_fetch_array($query)){
        $questionID= $row['questionID'];
        
           
        //FROM THE FORM THE ID/NAME OF EACH SCORE IS DYNAMIC ADDING QUESTION ID        
        $score = "p_Q" . $questionID;
        $getVal = $$score;
       
     	if($getVal != ""){//do not save null entries
        	//WHAT QUESTION TYPE?
        	$query2 = mysql_query("SELECT type from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
        	$questionType=$result['type'];

        
     		if($questionType=='likert'){
     		mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
     	
     		}elseif($questionType=='mc-check'){
     			foreach($getVal as $val){
     			//enter multiple answerID's as score for this checkbox mc question
     				mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$val', '$datesubmitted')");
     			}
     	
     		}elseif(($questionType=='mc-radio') || ($questionType=='tf')){
     			//enter answerID as score for this mc question
     			mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID','$questionID', '$userID', '$getVal', '$datesubmitted')");
     			
     		
     		}elseif($questionType=='text'){
     			//clean up $getVal text
				$getVal = strip_tags($getVal);
				$getVal = nl2br($getVal);
				//$getVal = htmlentities($getVal, ENT_QUOTES);
				$getVal = mysql_escape_string($getVal);
				if($getVal != ""){
					//WRITE TO TextOption TABLE
					mysql_query("INSERT INTO TextOption (evalID, questionID, submittedBy, textoption, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
					//WRITE 'text' SCORE TO SCORING TABLE
					//mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', 'text', '$datesubmitted')");
				}
		
			}
		
		}//close null entry conditional
	
	}//close custom eval questions
	
	
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
    
     //FROM THE FORM THE ID/NAME OF EACH SCORE IS DYNAMIC ADDING QUESTION ID        
        $score = "p_Q" . $questionID;
        $getVal = $$score;
       
     	if($getVal != ""){//do not save null entries
        	//WHAT QUESTION TYPE?
        	$query2 = mysql_query("SELECT type from Questions WHERE questionID='$questionID'");
        	$result = mysql_fetch_array($query2);
        	$questionType=$result['type'];

        
     		if($questionType=='likert'){
     		mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
     	
     		}elseif($questionType=='mc-check'){
     			foreach($getVal as $val){
     			//enter multiple answerID's as score for this checkbox mc question
     				mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$val', '$datesubmitted')");
     			}
     	
     		}elseif(($questionType=='mc-radio') || ($questionType=='tf')){
     			//enter answerID as score for this mc question
     			mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID','$questionID', '$userID', '$getVal', '$datesubmitted')");
     			
     		
     		}elseif($questionType=='text'){
     			//clean up $getVal text
				$getVal = strip_tags($getVal);
				$getVal = nl2br($getVal);
				//$getVal = htmlentities($getVal, ENT_QUOTES);
				$getVal = mysql_escape_string($getVal);
				if($getVal != ""){
					//WRITE TO TextOption TABLE
					mysql_query("INSERT INTO TextOption (evalID, questionID, submittedBy, textoption, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', '$getVal', '$datesubmitted')");
					//WRITE 'text' SCORE TO SCORING TABLE
					//mysql_query("INSERT INTO Scoring (evalID, questionID, submittedBy, score, datesubmitted)VALUES ('$evalID', '$questionID', '$userID', 'text', '$datesubmitted')");
				}
		
			}
		
		}//close null entry conditional
	
	}//close assessment loop
	
}//close if instructor conditional
	
	

	
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Thank you</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<script LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>

</script>

</head>
<body>
<div id="background">
	<div id="container" style="height:650px;">
		<div class="logo"><img src="../images/PSUblack-border10.png"></div>
		<div id="header">
		<div class="laoce">Liberal Arts Online Course Evaluation</div>
		</div>
		<br/><br/><br/><br/><br/>
		<div id="content" class='roundcorners'>

		<br/>
      
			<div align='center'><h3>Your evaluation has been submitted. <br> Thank you!.</h3><div>

		</div>

	</div>
</div>

</body>
</html>



