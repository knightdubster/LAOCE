<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Setup Instructions</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />


</head>
<body>

<div id="container">
	<div id="header" class='roundcorners'>
	<div class='pa'>COURSE EVALUATION.....</div>
	<div id="titlebox">
	<div class='heading'>SysAdmin: <?php echo $name; ?><br/></div>
	</div>
	</div>

<div id="content" class='roundcorners'>
<div class='heading'>Course Evaluation Survey</div>

<div><strong>Objective: Gather evaluation data from students taking Liberal Arts Online courses.</strong></div><br/>

<div class='heading'>Process:</div>
	<div class='indent'><strong>Students</strong> - login with WebAccess via Angel. Submit form. Only one submission.</div>
	<br/>
	
	<div class='indent'><strong>Instructors</strong> - Ability to review submitted anonymous data for a particular course</div>
	<br/>
	
	<div class='indent'><strong>Departments</strong> - Ability to review submitted anonymous data for a particular department. From the admin page select Add Additonal Access to Data. Entered user ID will have access to what ever is entered in Dept. input box.</div>
	<br/>
	
	<div class='indent'><strong>ID's</strong> - View all data from all courses. Make changes to survey questions. Customize individual course evaluations. Display data as desired by: coursename(or all), semester(or all), section(or all)</div>
	</br/>
	
	<div class='indent'><strong>Admin</strong> - View all data from all courses. Make changes to survey questions. Display data as desired by: coursename(or all), semester(or all), section(or all). Management of users. Updating CourseComparison table at end of evaluation cycles.</div>
	
<br/>	
<div class='heading'>Setup:</div>
In each course using the survey two links are needed: student and instructor.
The student link points to the evaluaiton form and the instructor link points to a display of submitted data for that course.<br/><br/>
Both links need to be customized for the course and section.
The student form URL: 	https://laonline.psu.edu/laoce/student/evaluation.php?eval=9<br/>
The instructor URL:
https://laonline.psu.edu/laoce/instructor/view.php?eval=9<br/>

</div>

<div class='heading'>Score Comparisons</div>
<div class='indent'></div>

</body>
</html>