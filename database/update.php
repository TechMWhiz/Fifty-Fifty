‎<?php
‎session_start();
‎include_once 'database.php';
‎
‎if ($_SERVER['REQUEST_METHOD'] == 'POST') {
‎    // Get the data from the form
‎    $id = $_POST['id'];
‎    $title = $_POST['title'];
‎    $genre = $_POST['genre'];
‎    $ratings = $_POST['ratings'];
‎    $year_released = $_POST['year_released'];
‎    $description = $_POST['description'];
‎
‎    // Simple validation
‎    if (empty($title) || empty($genre) || empty($ratings) || empty($year_released) || empty($description)) {
‎        $_SESSION['status'] = 'All fields are required!';
‎        header('Location: ../dashboard.php');
‎        exit();
‎    }
‎
‎  
‎
‎    // SQL update query
‎    $sql = "UPDATE movies SET title='$title', genre='$genre', ratings='$ratings', year_released='$year_released', description='$description' WHERE id=$id";
‎
‎    if (mysqli_query($conn, $sql)) {
‎        $_SESSION['status'] = 'Movie updated successfully!';
‎    } else {
‎        $_SESSION['status'] = 'Error updating movie: ' . mysqli_error($conn);
‎    }
‎
‎    // Close the database connection
‎    mysqli_close($conn);
‎
‎    // Redirect to the dashboard
‎    header('Location: ../dashboard.php');
‎    exit();
‎} else {
‎    header('Location: ../dashboard.php');
‎    exit();
‎}
‎?>