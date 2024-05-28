<?php
$db_host = "auth-db994.hstgr.io";
$db_user = "root";                 
$db_pass = "";                     
$db_name = "u877255869_FYP_2024_01_DB";  

// Attempt to connect to the MySQL database
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
echo "Connected successfully";
?>
