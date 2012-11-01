<?php
//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

//include "validateID.php";

echo"<b>Comparison</b>";   
 echo "<table border=1><tr><th>courses</th><th>semester</th><th>score</th><th># Courses</th></tr>";
    
$query = mysql_query("SELECT * from Comparison");
while($row = mysql_fetch_array($query)){
        echo "<tr><td>$row[courses]</td><td>$row[semester]</td><td>$row[score]</td><td>$row[evals]</td></tr>";
}

 echo "</table>";

echo "<br>";



?>