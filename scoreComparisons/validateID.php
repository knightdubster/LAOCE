<?php

//ADMIN OR ID ACCESS? 
		$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
		$result = mysql_fetch_array($query);
		if(isset($result['userID'])){
			//GET USER INFO
			$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
			$result = mysql_fetch_array($query);
			$firstname =  $result['firstname'];
			$lastname =  $result['lastname'];
			$name = $firstname . " " . $lastname;
			$role= $result['role'];
		}else{
			echo"<div style='text-align:center;'><br/><h3>You do not have access to this page.</h3></div>";
			exit();
		}
        	

?>