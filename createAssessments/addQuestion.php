<?php
//CREATE Question & Answers

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");

$assessmentID = $p_assessmentID;
echo $assessmentID;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PA - Add Question</title>
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
<form style="margin:auto;border: 1px solid #000099;padding:10px;text-align:left;" name="assessment" method="post"  action="saveQuestion.php">
<div class="smallred" style="float:right;width:300px;">A Section Heading is a question without any answers. Enter desired heading in question box and select Section Heading from drop down list. On Assessment editing page drag heading to desired position.</div>
<strong>Question</strong><br />
<textarea name="question" style="width:530px;" rows="10">Write your question here.</textarea><br>
Select type of question:<br>
<select name="type">
<option value="likert">Likert</option>
<option value="mc-check">Multiple Choice-checkbox</option>
<option value="mc-radio">Multiple Choice-radio</option>
<option value="tf">True/False</option>
<option value="text">Text Box</option>
<option value="heading">Section Heading</option>
</select><br><br>
<input name="assessmentID" type="hidden" value="<?php echo $assessmentID; ?>"/><br>
<input type="submit" value="Next"/>
</form>
</div>
</div></div>
</body>
</html>

