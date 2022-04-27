<?php

/**
$dbServerName = "localhost";
$dbUsername = "toolpqtu_toolhubuser";
$dbPassword = "toolhubpassword";
$dbName = "toolpqtu_toolhub";
**/

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "toolhub";
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>