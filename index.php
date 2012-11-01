<?php

//THIS INCLUDE FILE GIVES $userID
include "validateUser.php";
/*
//IMPORT VARIABLE assessmentID
import_request_variables("pg","p_");
$coursename=strtoupper($p_coursename);
$section = strtoupper($p_section);


//GET USER INFO
		$query = ($db_handle->query("SELECT role from Users WHERE userID='$userID'"));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$role = $result['role'];
		
if($role=="id"){
	$goto = admin/index.php
	echo "<script> window.location.href = '$goto' </script>";
	}
	
if($role=="admin"){
	$goto = sysadmin/admin.php
	echo "<script> window.location.href = '$goto' </script>";
	}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Liberal Arts Online Course Evaluation</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<style type="text/css">
body{
	background-color:#000;
	}
#background{
	width:1180px;
	margin:0 auto;
	background-image:url('images/sparks2.jpg');
	background-color:#c7cbcc;
	background-repeat:no-repeat;
	}
#container1{
	width:960px;
	margin:0 auto;
	}
#content1{
	background-color:#fff;
	padding:20px;
	opacity:.7;
	text-align:center;
	}
</style>
</head>
<body>
<div id="background">
<div id="container1">

<div>
	<div style="float:left;width:130px;margin-top:6px;"><img src="images/PSUblack-border10.png"></div>
	<div style="font-family:'Times New Roman',Times,serif;font-size:1.6em;padding-top:10px;">Liberal Arts Online Course Evaluation</div>
</div>


<br/><br/><br/><br/>
<div id='content1' class='roundcorners'>
<br/><br/><br/>
<h2>Restricted Access</h2>
<br/><br/><br/>
</div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
</div>

</body>
</html>