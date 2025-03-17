<?php
session_start();
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $ratings = $_POST['ratings'];
    $year_released = $_POST['year_released'];
    $description = $_POST['description'];


    $sql = "INSERT INTO movies (title, year_released, genre, ratings, description) VALUES ('$title', '$genre', '$ratings', '$year_released', '$description')";

    if (mysqli_query($conn,$sql)) {
        $_SESSION['status'] = "created";
    } else {
        $_SESSION['status'] = "error: " . $stmt->error;
    }

    mysqli_close($conn);
    header('Location: index.php');
    exit();
}
?>
