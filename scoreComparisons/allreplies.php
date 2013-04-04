
<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

include "validateIDorDept.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$evalID=$p_evalID;
$questionID = $p_questionID;



//GET COURSE INFO
$query = mysql_query("SELECT * from CourseInfo WHERE evalID='$evalID'");
		$result = mysql_fetch_array($query);
		$instructor = $result['firstname'] . " " . $result['lastname'];
		$coursename = $result['coursename'];
		$semester = $result['semester'];
		$section = $result['section'];

?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Assessment</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<script LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>

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
<div style="float:right;"><FORM><INPUT TYPE="BUTTON" VALUE="Go Back" 
ONCLICK="history.go(-1)"></FORM></div>
	<div class='heading'>
	Course: <?php echo $coursename; ?> &nbsp;&nbsp;&nbsp;
	Semester: <?php echo $semester; ?> &nbsp;&nbsp;&nbsp;
	Section: <?php echo $section; ?> &nbsp;&nbsp;&nbsp;
	</div>
	<br/>

<?php

$query = mysql_query("SELECT * from TextOption WHERE evalID='$evalID' AND questionID = '$questionID'");
while($row = mysql_fetch_array($query)){
	
		//this is to list question only once 
		if(!in_array($questionID,$questionlist)){
			$questionlist[]=$questionID;
			$query2 = mysql_query("SELECT questionText from Questions WHERE questionID='$questionID'");
			$result = mysql_fetch_array($query2);
			$questionText=stripslashes($result['questionText']);
			echo "<h3>Q" . $questionID . ": " . $questionText . "</h3>";
		}
			
	echo "<div class='indent'>- " . $row['textoption'] . "</div>";

}

?>
</div>
</div>
<br/><br/><br/>
</div>

</body>
</html>