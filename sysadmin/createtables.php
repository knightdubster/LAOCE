<?php

/*echo"This file is run on set up of this software to set up initial tables in the database. 
Running this deletes all information in any existing tables. As a precaution comment tags have been inserted to prevent accidental deletion. If you are certain you want to run this file you must open the file in a text editor and delete the comment tags and save the file before running it from your browser.";
*/

include "../validateUser.php";

include "../dbconnect.php";

include "validateAdmin.php";

//mysql_query("CREATE DATABASE LAOCE");


/*
//CREATE USERS TABLE
mysql_query("DROP TABLE Users");


mysql_query("CREATE TABLE Users(rowID int, userID varchar(8) primary key, firstname varchar(30), lastname varchar(30), role varchar(10), lastlogin varchar(30))") or die(mysql_error()); 

echo"<h3>A new 'users' table has been created.</h3><br/>";



//CREATE CourseInfo TABLE
mysql_query("DROP TABLE CourseInfo");

mysql_query( "CREATE TABLE CourseInfo (evalID int primary key auto_increment, coursename varchar(50), semester varchar(20), section varchar(20), instructorID varchar(8), firstname varchar(30), lastname varchar(30),begin integer, end integer, hide integer)") or die(mysql_error());

echo"<h3>A new 'CourseInfo' table has been created.</h3><br/>";



//CREATE Comparison TABLE
mysql_query("DROP TABLE Comparison");

mysql_query( "CREATE TABLE Comparison (rowID int primary key auto_increment, courses varchar(30), semester text, score integer, evals integer)") or die(mysql_error());

echo"<h3>A new 'Comparison' table has been created.</h3><br/>";


//CREATE CourseAccess TABLE
mysql_query("DROP TABLE CourseAccess");

mysql_query( "CREATE TABLE CourseAccess (rowID int primary key auto_increment, coursename varchar(50), userID varchar(8), firstname varchar(30), lastname varchar(30))") or die(mysql_error());

echo"<h3>A new 'CourseAccess' table has been created.</h3><br/>";



//CREATE CustomEval TABLE
//CURRENT CUSTOM QUESTIONS ADDED TO EVALUATION
mysql_query("DROP TABLE CustomEval");

mysql_query( "CREATE TABLE CustomEval (rowID int primary key auto_increment, coursename varchar(50),instructorAssessment integer, questionID integer)");

echo"<h3>A new 'CustomEval' table has been created.</h3><br/>";

//CREATE CustomEvalArchive TABLE
//RETAINS PAST CUSTOM QUESTION/COURSENAME EVEN IF QUESTION IS DELETED FROM CURRENT EVAL
mysql_query("DROP TABLE CustomEvalArchive");

mysql_query( "CREATE TABLE CustomEvalArchive (rowID int primary key auto_increment, coursename varchar(50),instructorAssessment integer, questionID integer)");

echo"<h3>A new 'CustomEvalArchive' table has been created.</h3><br/>";



//CREATE Scoring TABLE
mysql_query("DROP TABLE Scoring");

mysql_query( "CREATE TABLE Scoring (rowID int primary key auto_increment, evalID integer, questionID integer, submittedBy varchar(8), score varchar(6), datesubmitted varchar(30))");

echo"<h3>A new 'Scoring' table has been created.</h3><br/>";


//CREATE TextOption TABLE
mysql_query("DROP TABLE TextOption");

mysql_query( "CREATE TABLE TextOption (rowID int primary key auto_increment, evalID integer, questionID integer, submittedBy varchar(8), textoption text, datesubmitted varchar(30))");

echo"<h3>A new 'TextOption' table has been created.</h3><br/>";



//CREATE AssessmentsDescription TABLE
mysql_query("DROP TABLE AssessmentsDescription");

mysql_query( "CREATE TABLE AssessmentsDescription (assessmentID integer primary key, assessName varchar(50), description varchar(200), author varchar(8))");

echo"<h3>A new 'AssessmentsDescription' table has been created.</h3><br/>";



//CREATE Assessments TABLE
mysql_query("DROP TABLE Assessments");

mysql_query( "CREATE TABLE Assessments (assessmentID integer, questionID integer, questionorder integer, required integer)");

echo"<h3>A new 'Assessments' table has been created.</h3><br/>";



//CREATE Questions TABLE
mysql_query("DROP TABLE Questions");

mysql_query( "CREATE TABLE Questions (questionID integer primary key, questionText text, type varchar(10), author varchar(8))");

echo"<h3>A new 'Questions' table has been created.</h3><br/>";



//CREATE Answers TABLE
mysql_query("DROP TABLE Answers");

mysql_query("CREATE TABLE Answers (answerID integer primary key, questionID integer, answerText text, ratingvalue integer)");

echo"<h3>A new 'Answers' table has been created.</h3><br/>";
*/

?>

