<?php
//CREATE ASSESSMENT

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

//CONNECT TO DB
include "../dbconnect.php";

//CHECK INSTRUSCTOR OR ADMIN ROLE - gets user info- $name
include "validateID.php";


//GET ID OF LAST ASSESSMENT
$query = mysql_query("SELECT assessmentID from AssessmentsDescription");
$result = mysql_fetch_array($query);
if(isset($result['assessmentID'])){
	$assessmentID = mysql_num_rows($query) + 1;
 }else{
 	$assessmentID=1;
 	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Evaluation Assessments</title>
<link rel="stylesheet" type="text/css" href="../styles.css" />
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

<form style="margin:auto;border: 1px solid #000099;padding:10px;text-align:left;" name="assessment" method="post"  action="saveAssessment.php">
<strong>Create New Assessment</strong><br />
Name <input name="assessName" size="50"><br/>
Description<br/><textarea name="description" style="width:530px;" rows="10">Helpful info seen only by instructors when selecting assessments to use.</textarea><br>
<input name="userID" type="hidden" value="<?php echo $userID; ?>"/><br>
<input name="assessmentID" type="hidden" value="<?php echo $assessmentID; ?>"/><br>
<input type="submit" value="Add Question"/>
</form>
</div>
</div>
</div>
</body>
</html>

