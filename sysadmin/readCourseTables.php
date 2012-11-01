<html>
<head>
<title>Read Tables</title>
</head>
<body>

<?php

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$coursename=$p_coursename;

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";


//CourseInfo TABLE

echo"<b>CourseInfo</b>";   
 echo "<table border=1><tr><th>EvalID</th><th>Course Name</th><th>Semester</th><th>Section</th><th>InstructorID</th><th>Firstname</th><th>Lasttname</th></tr>";
    
$query = mysql_query("SELECT * from CourseInfo WHERE coursename = '$coursename'");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[evalID]</td><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[instructorID]</td><td>$row[firstname]</td><td>$row[lastname]</td></tr>";
}

 echo "</table>";

echo "<br>";


//CustomEval TABLE

echo"<b>CustomEval</b>";   
 echo "<table border=1><tr><th>Course Name</th><th>QuestionID</th></tr>";
    
$query = mysql_query("SELECT * from CustomEval WHERE coursename = '$coursename'");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[coursename]</td><td>$row[questionID]</td></tr>";
}

 echo "</table>";

echo "<br>";


?>

</body>
</html>