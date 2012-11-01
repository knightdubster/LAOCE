
<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Scoring Tables</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />




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
<div style="float:right;"><a href="admin.php">Return</a></div>

<?php
//Users TABLE
echo"<b>Users</b>";
echo "<table border=1><tr><th>UserID</th><th>Firstname</th><th>Lastname</th><th>Role</th><th>Lastlogin</th><th>Delete</th></tr>";
    
$query = mysql_query("SELECT * from Users");

while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[userID]</td><td>$row[firstname]</td><td>$row[lastname]</td><td>$row[role]</td><td>$row[lastlogin]</td>";
        echo"<td><a href='deleteUser.php?userID2=" . $row[userID] . "'>Delete</a></td></tr>";
}

 echo "</table>\n"; 

echo "<br></div>";

?>

</div>
</div>
</body>
</html>