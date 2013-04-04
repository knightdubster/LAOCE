<?php
//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

include "functions.php";

$query = mysql_query("SELECT
	g.assessmentID,
	g.questionID,
	g.questionorder,
	q.questionText,
	q.type,
	a.answerText,
	a.ratingvalue
FROM
	Assessments g
LEFT JOIN Questions q
	ON g.questionID = q.questionID
LEFT JOIN Answers a
	ON q.questionID = a.questionid
WHERE
	g.assessmentID = 1
ORDER BY
	g.assessmentID, g.questionorder, a.ratingvalue desc");
	while($row = mysql_fetch_array($query)){
	$questionID=$row['questionID'];
	$questionText['$questionID'][]=$row['questionText'];
	echo $row['answerText'] . "<br/>";
	
	}
	
	
?>