<html>
<head>
<title>Assessment Tables</title>
</head>
<body>

<?php

include "../dbconnect.php";


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
 echo "<table border=1><tr><th>AssessmentID</th><th>QuestionID</th><th>Order</th></tr>\n";
    
$query = mysql_query("SELECT * from Assessments");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[assessmentID]</td><td>$row[questionID]</td><td>$row[questionorder]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";

//Questions TABLE
echo"<b>Questions</b>";   
 echo "<table border=1><tr><th>QuestionID</th><th>Question Text</th><th>Author</th></tr>\n";
    
$query = mysql_query("SELECT * from Questions");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[questionID]</td><td>$row[questionText]</td><td>$row[author]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";

//Answers TABLE
echo"<b>Answers</b>";   
 echo "<table border=1><tr><th>AnswerID</th><th>Question ID</th><th>Answer Text</th><th>RatingValue</th><th>TextOption</th></tr>\n";
    
$query = mysql_query("SELECT * from Answers");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[answerID]</td><td>$row[questionID]</td><td>$row[answerText]</td><td>$row[ratingvalue]</td><td>$row[textoption]</td></tr>\n";
}

 echo "</table>\n";

echo "<br>";


?>

</body>
</html>