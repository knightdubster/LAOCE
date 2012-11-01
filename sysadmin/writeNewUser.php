<?php

include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

$userID2 = $_POST['userID'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$coursename = $_POST['coursename'];
$groupname = $_POST['groupname'];
$lastlogin=date("Y-m-d h:i");


$date=date("Y.m.d");

//IS THIS USER ALREADY REGISTERED
$query = mysql_query("SELECT userID from Users WHERE userID='$userID2'");
$result = mysql_fetch_array($query);

if(!isset($result['userID'])){//NOT REGISTERED - INSERT NEW

	$query1 = mysql_query("INSERT INTO Users (userID, firstname,lastname,role,lastlogin)VALUES ('$userID2','$firstname','$lastname','$role', '$lastlogin')");

	}else{//REGISTERED - JUST UPDATE NAME, ROLE

$query1 = mysql_query("UPDATE Users SET firstname='$firstname',lastname='$lastname', role='$role' WHERE userID = '$userID2'");

}


//GO TO admin.php
$goto = "admin.php";
echo "<script> window.location.href = '$goto' </script>";


?>
