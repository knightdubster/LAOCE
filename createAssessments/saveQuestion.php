<?php

//SAVE QUESTION AND ANSWER SLOTS
//CALLED BY addQuestion.php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//IMPORT VARIABLES FROM FORM
//assessmentID, question, responseNum

$assessmentID = $_POST['assessmentID'];
$questiontype = $_POST['type'];

$question=$_POST['question'];
//$question = stripslashes($question);
$question = mysql_escape_string($question);



//GET ID OF LAST QUESTION
$query = mysql_query("SELECT questionID from Questions ORDER BY questionID DESC LIMIT 1");
$result = mysql_fetch_array($query);
$questionID = $result['questionID'] + 1;


//GET NUMBER OF QUESTIONS IN THIS ASSESSMENT
$query2 = mysql_query("SELECT * from Assessments WHERE assessmentID='$assessmentID'");
$numberofquestions = mysql_num_rows($query2) + 1;

//WRITE TO Assessments TABLE
mysql_query("INSERT INTO Assessments (assessmentID, questionID,questionorder,required)VALUES ('$assessmentID','$questionID','$numberofquestions', 0)");

//WRITE TO Questions TABLE
mysql_query("INSERT INTO Questions (questionID, questionText, type, author)VALUES ('$questionID','$question', '$questiontype','$userID')");

//GET ID OF LAST ANSWER
$query = mysql_query("SELECT answerID from Answers ORDER BY answerID DESC LIMIT 1");
$result = mysql_fetch_array($query);
$answerID = $result['answerID'] + 1;



//WRITE TO Answers TABLE - 5 answers for likert type
if($questiontype=="likert"){
	for($i = 0; $i < 5; $i++){
	mysql_query("INSERT INTO Answers (answerID, questionID, ratingvalue)VALUES ('$answerID', '$questionID','$i')");
	$answerID++;
	}

}elseif($questiontype=="tf"){//two answers for true false

	mysql_query("INSERT INTO Answers (answerID, questionID, answerText, ratingvalue)VALUES ('$answerID', '$questionID', 'TRUE', 1)");
	$answerID++;
	mysql_query("INSERT INTO Answers (answerID, questionID, answerText, ratingvalue)VALUES ('$answerID', '$questionID', 'FALSE', 0)");
	
}elseif($questiontype=="heading"){
	//no answer saved
	
}elseif($questiontype=="text"){
	//nothing in answers table
	
}else{
	//type is mc-check, mc-radio
	mysql_query("INSERT INTO Answers (answerID, questionID)VALUES ('$answerID', '$questionID')");
}

//GO TO QUESTION EDIT
$goto ="editQuestion.php?assessmentID=" . $assessmentID . "&questionID=" . $questionID;
echo "<script> window.location.href = '$goto' </script>";


?>
