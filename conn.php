<?php

$host = 'localhost';
$db = 'db_bw_normilized_tables';
$user = 'root';
$pass = '';

// setup the connection
$conn = mysql_pconnect($host, $user, $pass) or trigger_error(mysql_error(), E_USER_ERROR); 

// select the database
mysql_select_db($db, $conn);

?>