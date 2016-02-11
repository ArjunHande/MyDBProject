<?php
$host = "localhost";
		$user = "root";
		$pass = "root";
		mysql_connect($host, $user, $pass)or die(mysql_error());
		mysql_select_db('db_project')or die(mysql_error());              
?>
