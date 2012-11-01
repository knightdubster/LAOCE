<?php
	/*
if(isset($_SERVER['REMOTE_USER'])){
	$userID = $_SERVER['REMOTE_USER'];
}else{
	echo "You do not have permission to view this site";
	exit();
	}
*/

$userID="cjh145";
$userID=strtolower($userID);


// The file to be used as the database:
$databasefile = "data/PeerAssessment";

if(! $db_handle = new PDO("sqlite:$databasefile")){
   echo $sqlite_error;
   echo "Did not connect";
	exit;
    }

//GET USER INFO
		$query = ($db_handle->query("SELECT * from Users WHERE userID='$userID'"));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$name = $firstname . " " . $lastname;
		$role = $result['role'];
		
if($role=="instructor"){
	header( 'Location: instructor/instructor.php' );
	}

?>