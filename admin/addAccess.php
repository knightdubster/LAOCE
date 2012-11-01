<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAOCE Administration</title>

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



<!--COURSE REGISTRATION-->
<div class="roundcorners" style="border:1px solid #000;padding:10px;">


<form method="post" action="saveAddAccess.php">


<div class="heading" style="margin-bottom:12px;">Additional Access</div>
Individuals registered here can be given customized access to data. This is to accommodate those who might wish to see all course data in a department. 
<br/><br/>

<p>The "dept" value entered will search for a match or partial match within the coursenames.</p>

<p>For example, APLNG802 would have access to all sections of APLNG802. APLNG would have access to APLNG802, APLNG803, APLNG804, etc.</p>

<p>Make separate entries for anyone needing access across departments, i.e., APLNG and ECON.</p>

<div class='indent roundcorners' style="padding:12px;background-color:#D7D2D6;">
<form name="register" method="post" action="saveCourseRegister.php">

Dept: <input name="coursename" type="text" size="12" maxlength="8"/>

<div class="smallred indent">EX: LER100, LER, RLST, CMLIT</div>
<br/>

Firstname: <input name="firstname" type="text" size="20" maxlength="30"/>&nbsp;&nbsp;&nbsp;
Lastname: <input name="lastname" type="text" size="20" maxlength="30"/>&nbsp;&nbsp;&nbsp;
UserID: <input name="instructorID" type="text" size="20" maxlength="7"/><br>
<br/>
<input type="submit" value="SUBMIT CUSTOM ACCESS"/>
</form>
</div>
<br/>
Once entered the individual will have access to this page which will provide the custom search options.<br/><br/>
<div style='text-align:center'><pre>https://laonline.psu.edu/LAOCE/department/</pre></div>

<br/>

</div>

</div>
</div>
</body>
</html>