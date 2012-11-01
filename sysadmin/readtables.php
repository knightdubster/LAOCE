<html>
<head>
<title>Read Tables</title>
</head>
<body>

<?php

include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";
/*
//Users TABLE
echo"<b>Users</b>";
echo "<table border=1><tr><th>UserID</th><th>Firstname</th><th>Lastname</th><th>Role</th><th>Lastlogin</th></tr>";


$query = mysql_query("SELECT * from Users");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[userID]</td><td>$row[firstname]</td><td>$row[lastname]</td><td>$row[role]</td><td>$row[lastlogin]</td></tr>";
}

 echo "</table>\n"; 

echo "<br>";

//CourseInfo TABLE

echo"<b>CourseInfo</b>";   
 echo "<table border=1><tr><th>EvalID</th><th>Course Name</th><th>Semester</th><th>Section</th><th>InstructorID</th><th>Firstname</th><th>Lastname</th></tr>";
    
$query = mysql_query("SELECT * from CourseInfo");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[evalID]</td><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[instructorID]</td><td>$row[firstname]</td><td>$row[lastname]</td></tr>";
}

 echo "</table>";

echo "<br>";

//CourseAccess TABLE

echo"<b>CourseAccess</b>";   
 echo "<table border=1><tr><th>Course Name</th><th>InstructorID</th><th>Firstname</th><th>Lasttname</th></tr>";
    
$query = mysql_query("SELECT * from CourseAccess");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[coursename]</td><td>$row[userID]</td><td>$row[firstname]</td><td>$row[lastname]</td></tr>";
}

 echo "</table>";

echo "<br>";
*/
//CustomEval TABLE

echo"<b>CustomEval</b>";   
 echo "<table border=1><tr><th>RowID</th><th>Course Name</th><th>InstructorAssessment?</th><th>AdditionalQuestions</th></tr>";
    
$query = mysql_query("SELECT * from CustomEval ORDER BY rowID");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[rowID]</td><td>$row[coursename]</td><td>$row[instructorAssessment]</td><td>$row[questionID]</td></tr>";
}

 echo "</table>";

echo "<br>";

//CustomEvalArchivve TABLE

echo"<b>CustomEvalArchive</b>";   
 echo "<table border=1><tr><th>RowID</th><th>Course Name</th><th>InstructorAssessment?</th><th>AdditionalQuestions</th></tr>";
    
$query = mysql_query("SELECT * from CustomEvalArchive ORDER BY rowID");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[rowID]</td><td>$row[coursename]</td><td>$row[instructorAssessment]</td><td>$row[questionID]</td></tr>";
}

 echo "</table>";

echo "<br>";


/*
//Scoring TABLE

echo"<b>Scoring</b>";   
 echo "<table border=1><tr><th>evalID</th><th>questionID</th><th>submittedBy</th><th>Score</th><th>DateSubmitted</th></tr>";
    
$query = mysql_query("SELECT * from Scoring WHERE evalID=25");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[evalID]</td><td>$row[questionID]</td><td>$row[submittedBy]</td><td>$row[score]</td><td>$row[datesubmitted]</td></tr>";
}

 echo "</table>";

echo "<br>";


//TextOption TABLE

echo"<b>Text Option</b>";   
 echo "<table border=1><tr><th>toID</th><th>evalID</th><th>questionID</th><th>submittedBy</th><th>textoption</th><th>DateSubmitted</th></tr>";
    
$query = mysql_query("SELECT * from TextOption WHERE evalID=423");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[rowID]</td><td>$row[evalID]</td><td>$row[questionID]</td><td>$row[submittedBy]</td><td>$row[textoption]</td><td>$row[datesubmitted]</td></tr>";
}

 echo "</table>";

echo "<br>";


//AssessmentsDescription TABLE
echo"<b>AssessmentsDescription</b>";   
 echo "<table border=1><tr><th>AssessmentID</th><th>Assessment Name</th><th>Description</th><th>Author</th></tr>\n";
    
$query = mysql_query("SELECT * from AssessmentsDescription");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[assessmentID]</td><td>$row[assessName]</td><td>$row[description]</td><td>$row[author]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";


//Assessments TABLE
echo"<b>Assessments</b>";   
 echo "<table border=1><tr><th>AssessmentID</th><th>QuestionID</th><th>Order</th><th>Require?</th></tr>\n";
    
$query = mysql_query("SELECT * from Assessments");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[assessmentID]</td><td>$row[questionID]</td><td>$row[questionorder]</td><td>$row[require]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";


//Questions TABLE
echo"<b>Questions</b>";   
 echo "<table border=1><tr><th>QuestionID</th><th>Question Text</th><th>Type</th><th>Author</th></tr>\n";
    
$query = mysql_query("SELECT * from Questions");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[questionID]</td><td>$row[questionText]</td><td>$row[type]</td><td>$row[author]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";


//Answers TABLE
echo"<b>Answers</b>";   
 echo "<table border=1><tr><th>AnswerID</th><th>Question ID</th><th>Answer Text</th><th>RatingValue</th></tr>\n";
    
$query = mysql_query("SELECT * from Answers");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[answerID]</td><td>$row[questionID]</td><td>$row[answerText]</td><td>$row[ratingvalue]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";
*/

?>

</body>
</html>