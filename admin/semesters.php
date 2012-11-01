<?php
//THIS INCLUDE FILE GIVES $userID
//include "../validateUser.php";

include "../dbconnect.php";

//include "validateID.php";


if (isset($_POST['data'])){
	$course = $_POST['data'];
	}
	

if($course == "all"){
	//semester option does not include "All"
	echo "<option value='all'>Select Semester</option>";
	$semesters[]=array();
	$i=0; //increment lessonids array
	$query = mysql_query("SELECT semester from CourseInfo");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[$i] = $row['semester'];
				echo "<option value='" . $semesters[$i] . "'>" . $semesters[$i] . "</option> ";
				$i++;
			}
		}
	}
	
}else{
	//semester option does include "All"
	echo "<option value='all'>Select Semester</option>";
	$semesters[]=array();
	$i=0; //increment lessonids array
	$query = mysql_query("SELECT semester from CourseInfo WHERE coursename='$course'");
	while($row = mysql_fetch_array($query)){
		if(isset($row['semester'])){
			if(!in_array($row['semester'],$semesters)){
				$semesters[$i] = $row['semester'];
				$i++;
			}
		}
	}
	
	if(count($semesters) > 1){
		echo "<option value='all'>All</option>";
		}
		foreach($semesters as $val){
			echo "<option value='" . $val . "'>" . $val . "</option> ";
		}

}

?>
