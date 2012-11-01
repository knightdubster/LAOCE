<?php
//IN COURSEACCESS TABLE?
	$query = mysql_query("SELECT * from CourseAccess WHERE userID ='$userID'");
	$result = mysql_fetch_array($query);
	if(!isset($result['userID'])){
		echo"<div style='text-align:center;'><br/><h3>You do not have access to this page.<br/>If you think this is in error please contact administrator.</h3></div>";
		exit();
	}else{
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$name = $firstname . " " . $lastname;
	}
	

?>