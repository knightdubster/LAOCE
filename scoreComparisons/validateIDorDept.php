<?php
$access = 0;//set flag

//ADMIN OR ID ACCESS? 
	$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
	$result = mysql_fetch_array($query);
		if(isset($result['userID'])){
			//GET USER INFO
			$firstname =  $result['firstname'];
			$lastname =  $result['lastname'];
			$name = $firstname . " " . $lastname;
			$role= $result['role'];
			$access = 1;
		}
		
if($access == 0){ //not admin or ID, check for dept access

//DEPT ACCESS

	//IN COURSEACCESS TABLE?
	$query = mysql_query("SELECT * from CourseAccess WHERE userID ='$userID'");
	$result = mysql_fetch_array($query);
	if(isset($result['userID'])){
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$name = $firstname . " " . $lastname;
		
		//CREATE ARRAY OF COURSENAMES FOR ACCESS
		$courseAccess[]=array();
		$query = mysql_query("SELECT coursename from CourseAccess WHERE userID ='$userID'");
		while($row = mysql_fetch_array($query)){
		$courseAccess[] = $row['coursename'];
		}
		
		if(in_array($departname,$courseAccess)){
			$access=1; //passed department name matches allowed CourseAccess
		}

	}
}
	

if($access == 0){
	echo"<div style='text-align:center;'><br/><h3>You do not have access to this page.<br/>If you think this is in error please contact administrator.</h3></div>";
		exit();
}



        	

?>