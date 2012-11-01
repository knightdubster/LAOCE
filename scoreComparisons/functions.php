<?php

//FUNCTION TO FIND TOP SCORE AVAILABLE FOR EACH QUESTION
function topratingvalue($questionID){
	$topratingvalue=0;
	//GET HIGHEST ratingvalue FOR THIS QUESTION
	$query = mysql_query("SELECT ratingvalue from Answers WHERE questionID='$questionID'"); 
	while($row = mysql_fetch_array($query)){
        $ratingvalue= $row['ratingvalue'];
        if($topratingvalue < $ratingvalue){$topratingvalue = $ratingvalue;}
        }
        return $topratingvalue;
    }

//GET USER INFO    
function userInfo($userID){
		$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
		$result = mysql_fetch_array($query);
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$name = $firstname . " " . $lastname;
		
		return $name;
}

function lastnamefirst($userID){
		global $db_handle;
		$query = mysql_query("SELECT * from Users WHERE userID='$userID'");
		$result = mysql_fetch_array($query);
		$firstname =  $result['firstname'];
		$lastname =  $result['lastname'];
		$lastnamefirst = $lastname . ", " . $firstname;
		
		return $lastnamefirst;
}


?>
