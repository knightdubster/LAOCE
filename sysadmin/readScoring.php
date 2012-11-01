
<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Scoring Tables</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />




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
<div style="float:right;"><a href="admin.php">Return</a></div>

<?php
//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID=$p_evalID;

echo"<b>CourseInfo</b>";   
 echo "<table border=1><tr><th>EvalID</th><th>Course Name</th><th>Semester</th><th>Section</th><th>InstructorID</th><th>Firstname</th><th>Lasttname</th></tr>";
    
$query = mysql_query("SELECT * from CourseInfo WHERE evalID = '$evalID'");
while($row = mysql_fetch_array($query)){
		$coursename = $row['coursename'];
        echo "<tr><td>$row[evalID]</td><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[instructorID]</td><td>$row[firstname]</td><td>$row[lastname]</td></tr>";
}

 echo "</table>";

echo "<br>";

//CustomEval TABLE

echo"<b>CustomEval</b>";   
 echo "<table border=1><tr><th>RowID</th><th>Course Name</th><th>InstructorAssessment?</th><th>AdditionalQuestions</th></tr>";
    
$query = mysql_query("SELECT * from CustomEval ORDER BY rowID");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[rowID]</td><td>$row[coursename]</td><td>$row[instructorAssessment]</td><td>$row[questionID]</td></tr>";
}


//Scoring TABLE

echo"<b>Scoring</b>";   
 echo "<table border=1><tr><th>evalID</th><th>questionID</th><th>submittedBy</th><th>Score</th><td>DateSubmitted</td></tr>";
    
$query = mysql_query("SELECT * from Scoring WHERE evalID='$evalID'");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[evalID]</td><td>$row[questionID]</td><td>$row[submittedBy]</td><td>$row[score]</td><td>$row[datesubmitted]</td></tr>";
}

 echo "</table>";

echo "<br>";

//TextOption TABLE

echo"<b>TextOption</b>";   
 echo "<table border=1><tr><th>evalID</th><th>questionID</th><th>submittedBy</th><th>TextOption</th><td>DateSubmitted</td></tr>";
    
$query = mysql_query("SELECT * from TextOption WHERE evalID='$evalID'");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[evalID]</td><td>$row[questionID]</td><td>$row[submittedBy]</td><td>$row[textoption]</td><td>$row[datesubmitted]</td></tr>";
}

 echo "</table>";

echo "<br>";


?>
</div>
</body>
</html>