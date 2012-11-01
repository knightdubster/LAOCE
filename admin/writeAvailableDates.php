<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateID.php";

$semester = $_POST['semester'];

$beginMonth = $_POST['beginMonth'];
$beginDay = $_POST['beginDay'];
$beginYear = $_POST['beginYear'];
$beginStamp = mktime(0,0,0,$beginMonth,$beginDay,$beginYear);


$endMonth = $_POST['endMonth'];
$endDay = $_POST['endDay'];
$endYear = $_POST['endYear'];
$endStamp = mktime(23,59,59,$endMonth,$endDay,$endYear);


$query = mysql_query("UPDATE CourseInfo SET begin='$beginStamp', end='$endStamp' WHERE semester = '$semester'");



//GO TO admin.php
$goto = "index.php";
echo "<script> window.location.href = '$goto' </script>";
?>