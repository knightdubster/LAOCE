<?php
//THIS INCLUDE FILE GIVES $userID
//include "../validateUser.php";

include "../dbconnect.php";

//include "validateID.php";

//RECEIVE COURSENAME AND SEMESTER FROM AJAX CALL
if (isset($_POST['coursename'])){
	$coursename = $_POST['coursename'];
	$semester = $_POST['semester'];
	}
	

$sections[]=array();
$i=0; //increment sections array
$hit = 0; //flag

if($coursename == 'all'){
	echo "<option value='all'>All</option>";
	/*
	$query = mysql_query("SELECT section from CourseInfo WHERE semester='$semester'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['section'])){
				$hit=1;
				if(!in_array($row['section'],$sections)){
				$sections[$i] = $row['section'];
				$i++;
				}
			}
		}
	*/	
}elseif($semester == 'all'){
	$query = mysql_query("SELECT section from CourseInfo WHERE coursename='$coursename'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['section'])){
				$hit=1;
				if(!in_array($row['section'],$sections)){
				$sections[$i] = $row['section'];
				$i++;
				}
			}
		}
		if(count($sections) > 1){
		echo "<option value='all'>All</option>";
		}
		foreach($sections as $val){
			echo "<option value='" . $val . "'>" . $val . "</option> ";
		}
		
}else{
	$query = mysql_query("SELECT section from CourseInfo WHERE coursename='$coursename' AND semester='$semester'");
		while($row = mysql_fetch_array($query)){
			if(isset($row['section'])){
				$hit=1;
				if(!in_array($row['section'],$sections)){
				$sections[$i] = $row['section'];
				$i++;
				}
			}
		}
		if(count($sections) > 1){
		echo "<option value='all'>All</option>";
		}
		foreach($sections as $val){
			echo "<option value='" . $val . "'>" . $val . "</option> ";
		}
}


/*		
//check for integer value in array
echo count($sections);

if($hit == 0){
	echo "do nothing";
}else{
	echo "<option value='all'>All</option>";
	foreach($sections as $val){
		echo "<option value='" . $val . "'>" . $val . "</option> ";
	}
}
*/	
?>