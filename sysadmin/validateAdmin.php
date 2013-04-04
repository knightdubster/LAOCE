<?php

//GET USER INFO
$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
		$result = mysql_fetch_array($query);
		if(isset($result['userID'])){
			$firstname =  $result['firstname'];
			$lastname =  $result['lastname'];
			$name = $firstname . " " . $lastname;
			$role= $result['role'];
			echo $role;
        }
        
        //EXIT IF NOT ADMIN
			if($role !='admin'){
        	echo"<div style='text-align:center;'><br/><h3>You are not registered as an administrator and do not have access to this page.</h3></div>";
			exit();
        	}

?>