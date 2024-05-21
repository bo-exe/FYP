<?php
$db_host = "auth-db994.hstgr.io";  // Database server address
$db_user = "root";                 // Database username
$db_pass = "";                     // Database password (empty in this case)
$db_name = "u877255869_FYP_2024_01_DB";  // Database name

// Attempt to connect to the MySQL database
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
