<?php
$link = mysql_connect('localhost', 'root', 'root')
  or die("Could not connect to MYSQL: " . mysql_error());
  
mysql_select_db('LAOCE', $link) 
  or die ("Could not connect to DB: " . mysql_error());
?>
