<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $ratings = $_POST['ratings'];
        $year_released = $_POST['year_released'];
        $description = $_POST['description'];

    // Validation
    if (empty($title) || empty($genre) || empty($ratings) || empty($year_released) || empty($description)) {
        $_SESSION['status'] = 'All fields are required!';
        header('Location: ../index.php');
        exit();
    }

  

    // SQL update query
    $sql = "UPDATE movies SET title='$title', genre='$genre', ratings='$ratings', year_released='$year_released', description='$description' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'Movie updated successfully!';
    } else {
        $_SESSION['status'] = 'Error updating movie: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the index
    header('Location: ../index.php');
    exit();
}
?>