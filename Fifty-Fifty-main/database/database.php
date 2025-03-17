<?php

$servername = "localhost";
$db_name = "movie_db";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Mali TANGA ulitin mo: " . $conn->connect_error);
} else {
    echo "Ayyy galing mo konek na!";

}
?>