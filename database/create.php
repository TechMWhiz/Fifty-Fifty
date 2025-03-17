<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $ratings = $_POST['ratings'];
    $year_released = $_POST['year_released'];
    $description = $_POST['description'];

    if (empty($title) || empty($genre) || empty($ratings) || empty($year_released) || empty($description)) {
        $_SESSION['status'] = "Please fill out all fields!";
        header('Location: ../index.php');
        exit();
    }

    $title = mysqli_real_escape_string($conn, $title);
    $genre = mysqli_real_escape_string($conn, $genre);
    $ratings = mysqli_real_escape_string($conn, $ratings);
    $year_released = mysqli_real_escape_string($conn, $year_released);
    $description = mysqli_real_escape_string($conn, $description);

    $check_sql = "SELECT * FROM movies WHERE title = '$title' AND year_released = '$year_released'";
    $result = mysqli_query($conn, $check_sql);

    if (!$result) {
        $_SESSION['status'] = "SQL Error: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = "Movie already exists!";
    } else {
        // Movie doesn't exist proceed with adding Mae is here
        $sql = "INSERT INTO movies (title, genre, ratings, year_released, description) VALUES ('$title', '$genre', '$ratings', '$year_released', '$description')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = "Movie added successfully!";
        } else {
            $_SESSION['status'] = "SQL Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    header('Location: ../index.php');
    exit();
}
?>
