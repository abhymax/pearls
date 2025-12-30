<?php
$servername = "localhost";
$username = "mas7415dyn_pearls";
$password = "SZpr,}m4GZSj";
$dbname = "mas7415dyn_pearls";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");