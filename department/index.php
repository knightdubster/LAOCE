<?php

//THIS INCLUDE FILE GIVES $userID
include "../validateUser.php";

include "../dbconnect.php";

include "validateDept.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAOCE Department View</title>

<link rel="stylesheet" type="text/css" href="../styles.css" />

<style type="text/css">
td,th{padding:2px 6px 2px 0px;}
th{text-align:left;}

</style>

<script type="text/javascript" src="../scripts/jquery-1.4.4.min.js"></script>


<script type="text/javascript">
//JQUERY FORM OPTIONS
$(document).ready(function(){
	$("#semesterbox").hide();
	$("#sectionbox").hide();
	$("#go").hide();
	$("#loadinggif").hide();
 
 //ON CHANGE GET SEMESTERS
    $("#coursename").change( function() {
        $("#sectionbox").hide();
		$("#go").hide();
		$("#loadinggif").hide();
        $.ajax({
            type: "POST",
            data: "data=" + $(this).val(),
            url: "semesters.php",
            success: function(msg){
                if (msg != ''){
                	$("#semesterbox").show();
                    $("#semester").html(msg).show();
                    //$("#semester").html('');
                }
                else{
                    $("#semester").html('<em>No item result</em>');
                }
            }
        });
    });
    
	//ON CHANGE GET SECTIONS
    $("#semester").change( function() {
       $("#section").hide();
      // $("#sectionMsg").html('Retrieving ...');
        var chosenCourse = document.getElementById('coursename').value;
        $.ajax({
            type: "POST",
            data: "semester=" + $(this).val() + "&coursename=" + chosenCourse,
            url: "sections.php",
            success: function(msg){
                if (msg != ''){
                	$("#sectionbox").show();
                    $("#section").html(msg).show();
                    $("#go").show();
                    //$("#sectionMsg").html('');
                }
                else{
                    $("#sectionMsg").html('<em>No item result</em>');
                }
            }
        });
    });
    
    //ON SUBMIT DISPLAY LOADING GIF
    $('#selectionform').submit(function() {
    	$("#loadinggif").show();
    });
   
   
});
</script>


</head>
<body>
<div id="background">
<div id="container">
	<div class="logo"><img src="../images/PSUblack-border10.png"></div>
		<div id="header">
		<div class="laoce">Liberal Arts Online Course Evaluation</div>
		<div>Department View: <?php echo $name; ?><br/></div>
		</div>
	
<div id="content" class='roundcorners'> 
<?php
//CREATE ARRAY OF COURSENAMES FOR ACCESS
$displayComparisonLinks=0; //set flag - only show comparison links if department access
$i=0;
$courseAccess[]=array();
	$query = mysql_query("SELECT coursename from CourseAccess WHERE userID ='$userID'");
	while($row = mysql_fetch_array($query)){
		$coursename=$row['coursename'];
		$courseAccess[$i]=$coursename;
		//if no course number then department access, set flag to display
		if (!preg_match('#[0-9]#',$coursename)){
			$displayComparisonLinks = 1;
		}
		$i++;
	}

if(in_array('ALL',$courseAccess)){
	//FULL ACCESS - ALL EVALID'S
	$evalIDs[]=array();
	$i=0;//increment evalIDs array
	$query = mysql_query("SELECT * from CourseInfo");
		while($row = mysql_fetch_array($query)){
			$evalIDs[$i] = $row['evalID'];
			$i++;
		}
}else{
	//LIMITED ACCESS - GET COURSE INFO - SET ARRAY OF EVALID'S
	$evalIDs[]=array();
	$i=0;//increment evalIDs array

	foreach($courseAccess as $access){
		$query = mysql_query("SELECT * from CourseInfo");
			while($row = mysql_fetch_array($query)){
				$coursename=$row['coursename'];
				$pos = (strpos($coursename,$access));
				if($pos !== false){
				$evalIDs[$i] = $row['evalID'];
				$i++;
				}
			}
	}
}

//reverse order of evalIDs
$evalIDs = array_reverse($evalIDs);


echo "<h3>Course Access: ";
//display what access is given
foreach($courseAccess as $access){
	echo $access . "  ";
}
?>
</h3>
<br/>
<!--VIEWING DATA-->
<div class="roundcorners" style="border:1px solid #000;padding:10px;">

<?php
//DISPLAY COMPARISON LINKS IF DEPARTMENT ACCESS GIVEN
if($displayComparisonLinks == 1){
	echo"<div style='float:right;'><strong>Department Score Comparisons</strong><br/>";

	//ONLY SHOW COMPARISONS LINK IF ACCESS GIVEN TO DEPT NAME, NO COURSE NUMBER
	foreach($courseAccess as $access){
		if($access == 'ALL'){
			echo "<a href='../scoreComparisons/index.php'>" . $access . "</a><br/>";
		}else{
			$access = str_replace(" ","",$access);//make sure no whitespaces
				if (!preg_match('#[0-9]#',$access)){
					echo "<a href='../scoreComparisons/departmentSemesters.php?department=" . $access . "'>" . $access . "</a><br/>";
     			}
		}
	}
	echo "</div>";
}
?>
<div class="heading">Viewing Data</div>
<div class='indent smallred'>Make selections from drop down lists.</div>
<br/>
<div class='indent'>
<form id = "selectionform" method='post' action='displayScores.php'>
<div style="float:left;display:inline;"><span class="smallred">Select Course</span><br/><strong>Course: </strong>
<select id="coursename" name='coursename'>
<option value='none'>Select course</option>

<?php
// GET COURSENAMES	FOR ACCESS GIVEN	
	$coursenames[]=array();
	$i=0; //increment lessonids array
foreach($evalIDs as $accessgiven){
	$query = mysql_query("SELECT coursename from CourseInfo WHERE evalID='$accessgiven'");
	while($row = mysql_fetch_array($query)){
		if(isset($row['coursename'])){
			if(!in_array($row['coursename'],$coursenames)){
				$coursenames[$i] = $row['coursename'];
				echo "<option value='" . $coursenames[$i] . "'>" . $coursenames[$i] . "</option> ";
				$i++;
			}
		}
	}
}
?>

</select></div>&nbsp;&nbsp;&nbsp;

<!--SEMESTERS-->
<div style='float:left;margin-left:20px;' id='semesterbox'>
<div class='smallred'>Select Semester</div>
<strong>Semester: </strong>
<select id='semester' name='semester'>[Semester dropdown options]</select>
</div>
&nbsp;&nbsp;&nbsp;

<!--SECTIONS-->
<div style='float:left;margin-left:20px;' id='sectionbox'>
<div class='smallred'>Select Section</div>
<strong>Section: </strong>
<!--<span id="sectionMsg">[retrieving or no data]</span>-->
<select id='section' name='section'>[Section dropdown options]</select>
</div>
&nbsp;&nbsp;&nbsp;


<!--SUBMIT-->
<div style='float:left;margin-left:20px;' id='go'>
<div class='smallred'>Submit Selections</div>
<input type='submit' value='GO'>
<div id="loadinggif" style="display:inline;"><img src="../images/ajax-loader.gif"> please wait...</div>
</div>


</form>
</div>

<br/>
</div><br/>
<?php
//ONLY DISPLAY LIST OF COURSES IF LIMITED ACCESS
if(!in_array('ALL',$courseAccess)){
echo"<b>Data for these courses/sections is available.</b>";   
 echo "<table border=0><tr><th>Course</th><th>Semester</th><th>Section</th><th>Instructor</th></tr>";

	foreach($evalIDs as $accessgiven){
    
		$query = mysql_query("SELECT * from CourseInfo WHERE evalID='$accessgiven'");
		while($row = mysql_fetch_array($query)){
        	echo "<tr><td>$row[coursename]</td><td>$row[semester]</td><td>$row[section]</td><td>$row[firstname] $row[lastname]</td></tr>";
		}
	}
}

?>

</table>

<br>
</div>
<br/>

