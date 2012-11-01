<html>
<head>
<title>Read Tables</title>
</head>
<body>

<?php
//one time script to copy CustomEval table to new customEvalArchive table

include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";



echo"<b>CustomEval</b>";   
 echo "<table border=1><tr><th>RowID</th><th>Course Name</th><th>InstructorAssessment?</th><th>AdditionalQuestions</th></tr>";
    
$query1 = mysql_query("SELECT * from CustomEval ORDER BY rowID");
while($row = mysql_fetch_array($query1)){
        echo "<tr><td>$row[rowID]</td><td>$row[coursename]</td><td>$row[instructorAssessment]</td><td>$row[questionID]</td></tr>";
}

 echo "</table>";

echo "<br>";

$query2 = mysql_query("SELECT * from CustomEval ORDER BY rowID");
	while($row = mysql_fetch_array($query2)){
		$coursename = $row['coursename'];
		$instructorAssessment = $row['instructorAssessment'];
		$questionID = $row['questionID'];
		mysql_query("INSERT INTO CustomEvalArchive (coursename,instructorAssessment, questionID)VALUES ('$coursename',$instructorAssessment,'$questionID')");
		}
		
echo"<b>CustomEvalArchive</b>";   
 echo "<table border=1><tr><th>RowID</th><th>Course Name</th><th>InstructorAssessment?</th><th>AdditionalQuestions</th></tr>";
    
$query3 = mysql_query("SELECT * from CustomEvalArchive ORDER BY rowID");
	while($row = mysql_fetch_array($query3)){
        echo "<tr><td>$row[rowID]</td><td>$row[coursename]</td><td>$row[instructorAssessment]</td><td>$row[questionID]</td></tr>";
	}

 echo "</table>";

echo "<br>";		

?>

</body>
<html>