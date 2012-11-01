<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

$evalID = $_POST['evalID'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$instructorID = $_POST['instructorID'];
$enrollment = $_POST['enrollment'];


$beginMonth = $_POST['beginMonth'];
$beginDay = $_POST['beginDay'];
$beginYear = $_POST['beginYear'];
$beginStamp = mktime(0,0,0,$beginMonth,$beginDay,$beginYear);

$endMonth = $_POST['endMonth'];
$endDay = $_POST['endDay'];
$endYear = $_POST['endYear'];
$endStamp = mktime(23,59,59,$endMonth,$endDay,$endYear);


$query = mysql_query("UPDATE CourseInfo SET begin='$beginStamp', end='$endStamp',firstname='$firstname',lastname='$lastname',instructorID='$instructorID',enrollment='$enrollment' WHERE evalID = '$evalID'");



//GO TO admin.php
$goto = "editCourseInfo.php?evalID=" . $evalID;
echo "<script> window.location.href = '$goto' </script>";
?>