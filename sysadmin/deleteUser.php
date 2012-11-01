<?php
//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";


import_request_variables("pg","p_");
$userID2 = $p_userID2;

$query = mysql_query("DELETE FROM Users WHERE userID = '$userID2'");


//return
$goto = "admin.php";
echo "<script> window.location.href = '$goto' </script>";

?>